<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\WebPhotos;
use App\Models\WebContents;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class Admins extends Component
{    
    use WithPagination;
    use WithFileUploads;

    public $sortBy = 'updated_at';
    
    public $modalFormVisible;
    public $modalConfirmDeleteVisible;
    public $steamName;
    public $realName;
    public $socialMedia;
    public $role;
    public $photos;
    public $modelId;
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
            'steamName' => 'required',
            'role' => 'required',
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
        $this->steamName = $data->content1;
        $this->realName = $data->content2;
        $this->socialMedia = $data->content3;
        $this->role = $data->content4;
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
        $section = 'Admins';

        $filepath = $section . '/' . $this->photos->hashName();
        $this->photos->store('photos/'. $section .'/');
        WebPhotos::create([
            'section' => $section,
            'caption' => $this->steamName,
            'file_path' => $filepath,
            'author_id' => $userID->id,
        ]);
        $photoID = WebPhotos::where('file_path','=',$filepath)->first();
        WebContents::create([
            'section' => $section,
            'content1' => $this->steamName,
            'content2' => $this->realName,
            'content3' => $this->socialMedia,
            'content4' => $this->role,
            'photo_id' => $photoID->id,
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
        $section = 'Admins';

        WebContents::find($this->modelId)->update([
            'content1' => $this->steamName,
            'content2' => $this->realName,
            'content3' => $this->socialMedia,
            'content4' => $this->role,
            'author_id' => $userID->id,
        ]);
        $filepath = $section . '/' . $this->photos->hashName();
        $this->photos->store('photos/'. $section .'/');
        $photoID = WebContents::find($this->modelId);
        WebPhotos::find($photoID->photo_id)->update([
            'caption' => $this->steamName,
            'file_path' => $filepath,
            'author_id' => $userID->id,
        ]);

        $this->resetVars();
        $this->modalFormVisible = false;
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
        $this->resetPage();
        $this->modalConfirmDeleteVisible = false;
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
        $this->steamName = null;
        $this->realName = null;
        $this->socialMedia = null;
        $this->role = null;
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
        ->where('section','=','Admins')
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
        return view('livewire.admin.admins', [
            'data' => $this->read(),
        ]);
    }
}
