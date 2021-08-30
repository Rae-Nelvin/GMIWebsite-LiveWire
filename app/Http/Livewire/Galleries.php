<?php

namespace App\Http\Livewire;

use App\Models\WebContents;
use Livewire\Component;
use App\Models\WebPhotos;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class Galleries extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $sortBy = 'updated_at';
    
    public $modalFormVisible;
    public $modalConfirmDeleteVisible;
    public $modalAddMoreGamemodes;
    public $title;
    public $gamemodes;
    public $types;
    public $photos = [];
    public $modelId;
    public $selectedTypes = null;
    public $selectedGamemodes = null;
    public $sortDirection = 'desc';
    public $attachment;
    public $iteration;
    
    /**
     * The validation rules.
     *
     * @return void
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'gamemodes' => 'required',
            'types' => 'required',
            'photos.*' => 'image|required',
        ];
    }

    /**
     * The livewire mount function
     *
     * @return void
     */
    public function mount()
    {
        // Resets the pagination after reloading the page
        $this->resetPage();
    }
    
    /**
     * The check function.
     *
     * @return void
     */
    public function check()
    {
        $check = WebPhotos::where('section','=','Galleries')->where('content1','=','Background')->where('content2','=',$this->gamemodes)->first();
        if($check == NULL)
        {
            $this->create();
        }else{
            $this->update();
        }
    }
    
    /**
     * The create function.
     *
     * @return void
     */
    public function create()
    {
        $this->validate();

        $userID = Auth::user();
        $section = "Galleries";

        foreach($this->photos as $photo)
        {
            $filepath = $section . '/' . $this->types  . '/' . $this->gamemodes . '/' . $photo->hashName();
            $photo->store('photos/'.  $section . '/' . $this->types  . '/' . $this->gamemodes .'/');
            WebPhotos::create([
                'section' => $section,
                'caption' => $this->title,
                'content1' => $this->types,
                'content2' => $this->gamemodes,
                'author_id' => $userID->id,
                'file_path' => $filepath,
            ]);
        }
            
        $this->modalFormVisible = false;
        $this->resetVars();
    }
    
    /**
     * The update function.
     *
     * @return void
     */
    public function update()
    {
        $this->validate();

        $userID = Auth::user();
        $section = "Galleries";
        
        foreach($this->photos as $photo)
        {
            $filepath =  $section . '/' . $this->types  . '/' . $this->gamemodes  . '/' . $photo->hashName();
            $photo->store('photos/'.  $section . '/' . $this->types  . '/' . $this->gamemodes .'/');
            WebPhotos::where('section','=','Galleries')->where('content1','=','Background')->where('content2','=',$this->gamemodes)->update([
                'caption' => $this->title,
                'author_id' => $userID->id,
                'file_path' => $filepath,
            ]);
        }
        
        $this->modalFormVisible = false;
        $this->resetVars();
    }
    
    /**
     * The delete function.
     *
     * @return void
     */
    public function delete()
    {
        WebPhotos::destroy($this->modelId);
        $this->modalConfirmDeleteVisible = false;
        $this->resetPage();
    }
    
    /**
     * Shows the create form.
     *
     * @return void
     */
    public function createShowModal()
    {
        $this->resetValidation();
        $this->reset();
        $this->modalFormVisible = true;
    }
    
    /**
     * Shows the delete confirmation.
     *
     * @param  mixed $id
     * @return void
     */
    public function deleteShowModal($id)
    {
        $this->modelId = $id;
        $this->modalConfirmDeleteVisible = true;
    }
    
    /**
     * Function to reset the variables.
     *
     * @return void
     */
    public function resetVars()
    {
        $this->title = null;
        $this->types = null;
        $this->gamemodes = null;
        $this->photos = null;
        $this->attachment = null;
        $this->iteration ++;
    }
    
    /**
     * The read function.
     *
     * @return void
     */
    public function read()
    {
        return
        WebPhotos::query()
            ->where('section','=','Galleries')
            ->when($this->selectedTypes, function($query){
                $query->where('content1','=',$this->selectedTypes);
            })
            ->when($this->selectedGamemodes, function($query){
                $query->where('content2','=',$this->selectedGamemodes);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(5);
    }
    
    /**  
     * The render function.
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.galleries', [
            'data' => $this->read(),
        ]);
    }
}
