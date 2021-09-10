<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\WebPhotos;
use App\Models\WebContents;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class TTTRoles extends Component
{    
    use WithPagination;
    use WithFileUploads;

    public $sortBy = 'updated_at';

    public $modalFormVisible;
    public $modalConfirmDeleteVisible;
    public $roles;
    public $description;
    public $teams;
    public $photos;
    public $attachment;
    public $iteration;
    public $modelId;
    public $selectedTypes = null;
    public $sortDirection = 'desc';
    
    /**
     * The validation rules.
     *
     * @return void
     */
    public function rules()
    {
        return [
            'roles' => 'required',
            'description' => 'required',
            'teams' => 'required',
            'photos' => 'image|required',
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
        $this->roles = $data->content1;
        $this->description = $data->content2;
        $this->teams = $data->content3;
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
        $section = 'TTTRoles';
        $filepath = $section . '/' . $this->teams . '/' . $this->photos->hashName();
        $this->photos->store('photos/'. $section .'/' . $this->teams . '/');
        WebPhotos::create([
            'section' => $section,
            'caption' => $this->roles,
            'file_path' => $filepath,
            'author_id' => $userID->id,
        ]);
        $photoID = WebPhotos::where('file_path','=',$filepath)->first();
        WebContents::create([
            'section' => $section,
            'content1' => $this->roles,
            'content2' => $this->description,
            'content3' => $this->teams,
            'photo_id' => $photoID->id,
            'author_id' => $userID->id,
        ]);

        $this->resetVars();
        $this->modalFormVisible = false;

        return redirect()->to('/TTTRoles');
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
        $section = "TTTRoles";
        $photoID = WebContents::find($this->modelId);
        WebContents::find($this->modelId)->update([
            'content1' => $this->roles,
            'content2' => $this->description,
            'content3' => $this->teams,
            'author_id' => $userID->id,
        ]);
        $filepath = $section . '/' . $this->teams . '/' . $this->photos->hashName();
        $this->photos->store('photos/'. $section . '/' . $this->teams . '/');
        WebPhotos::find($photoID->photo_id)->update([
            'caption' => $this->roles,
            'file_path' => $filepath,
            'author_id' => $userID->id,
        ]);

        $this->resetVars();
        $this->modalFormVisible = false;

        return redirect()->to('/TTTRoles');
    }

    /**
     * The delete function
     *
     * @return void
     */
    public function delete()
    {
        $photoID = WebContents::find($this->modelId);
        WebContents::destroy($this->modelId);
        WebPhotos::destroy($photoID->photo_id);
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
        $this->reset();
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
        $this->roles = null;
        $this->description = null;
        $this->teams = null;
        $this->photos = null;
        $this->attachment = null;
        $this->iteration++;
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
        ->where('section','=','TTTRoles')
        ->when($this->selectedTypes, function($query){
            $query->where('content3','=',$this->selectedTypes);
        })
        ->orderBy($this->sortBy, $this->sortDirection)
        ->with('photos')
        ->paginate(5);
    }

    /**
     * The render function.
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.admin.t-t-t-roles', [
            'data' => $this->read(),
        ]);
    }
}
