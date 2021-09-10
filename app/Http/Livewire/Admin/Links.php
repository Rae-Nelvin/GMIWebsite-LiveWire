<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\WebContents;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class Links extends Component
{    
    use WithPagination;
    use WithFileUploads;

    public $sortBy = 'updated_at';
    
    public $modalFormVisible;
    public $modalConfirmDeleteVisible;
    public $types;
    public $gamemodes;
    public $link;
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
            'types' => 'required',
            'gamemodes' => 'required',
            'link' => 'required',
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
     * Loads the model data
     * of this component.
     *
     * @return void
     */
    public function loadModel()
    {
        $data = WebContents::find($this->modelId);
        $this->types = $data->content1;
        $this->gamemodes = $data->content2;
        $this->link = $data->content3;
    }
    
    /**
     * The check function.
     *
     * @return void
     */
    public function check()
    {
        $check = WebContents::query()
        ->where('section','=','Links')
        ->where('content1','=',$this->types)
        ->where('content2','=',$this->gamemodes)
        ->first();
        if($check == NULL)
        {
            $this->create();
        }else{
            $this->modelId = $check->id;
            $this->update();
        }
    }
    
    /**
     * The create function
     *
     * @return void
     */
    public function create()
    {
        $this->validate();
        
        $userID = Auth::user();
        $section = 'Links';

        WebContents::create([
            'section' => $section,
            'content1' => $this->types,
            'content2' => $this->gamemodes,
            'content3' => $this->link,
            'author_id' => $userID->id,
        ]);

        $this->resetVars();
        $this->modalFormVisible = false;
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

        WebContents::find($this->modelId)->update([
            'content3' => $this->link,
            'author_id' => $userID->id,
        ]);

        $this->resetVars();
        $this->modalFormVisible = false;
    }
    
    /**
     * The delete function.
     *
     * @return void
     */
    public function delete()
    {
        WebContents::destroy(($this->modelId));
        $this->modalConfirmDeleteVisible = false;
        $this->resetPage();
    }

    /**
     * Shows the form modal
     * of the create function.
     *
     * @return void
     */
    public function createShowModal()
    {
        $this->resetValidation();
        $this->resetVars();
        $this->modalFormVisible = true;
    }
    
    /**
     * Shows the form model
     * in update mode.
     *
     * @param  mixed $id
     * @return void
     */
    public function updateShowModal($id)
    {
        $this->resetValidation();
        $this->reset();
        $this->modelId = $id;
        $this->modalFormVisible = true;
        $this->loadModel();
    }
    
    /**
     * Shows the delete confirmation modal.
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
        $this->types = null;
        $this->gamemodes = null;
        $this->link = null;
    }

    /**
     * The read function.
     *
     * @return void
     */
    public function read()
    {
        return
        WebContents::query()
        ->where('section','=','Links')
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
        return view('livewire.admin.links', [
            'data' => $this->read(),
        ]);
    }
}
