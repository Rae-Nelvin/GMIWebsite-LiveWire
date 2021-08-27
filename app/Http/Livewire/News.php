<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\WebPhotos;
use App\Models\WebContents;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class News extends Component
{    
    use WithPagination;
    use WithFileUploads;

    public $sortBy = 'updated_at';
    
    public $modalFormVisible;
    public $modalConfirmDeleteVisible;
    public $title;
    public $description;
    public $link;
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
            'title' => 'required',
            'description' => 'required',
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
        $this->title = $data->content1;
        $this->description = $data->content2;
        $this->link = $data->content3;
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
        $section = "News";
        $filepath = $section . '/' . $this->photos->hashName();
        $this->photos->store('photos/'. $section .'/');
        WebPhotos::create([
            'section' => $section,
            'caption' => $this->title,
            'file_path' => $filepath,
            'author_id' => $userID->id,
        ]);
        $photoID = WebPhotos::where('file_path','=',$filepath)->first();
        WebContents::create([
            'section' => $section,
            'content1' => $this->title,
            'content2' => $this->description,
            'content3' => $this->link,
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
        $section = "News";
        $photoID = WebContents::find($this->modelId);
        WebContents::find($this->modelId)->update([
            'content1' => $this->title,
            'content2' => $this->description,
            'content3' => $this->link,
            'author_id' => $userID->id,
        ]);
        $filepath = $section . '/' . $this->photos->hashName();
        $this->photos->store('photos/'. $section . '/');
        WebPhotos::find($photoID->photo_id)->update([
            'caption' => $this->title,
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
        $this->title = null;
        $this->description = null;
        $this->link = null;
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
        ->where('section','=','News')
        ->orderBy($this->sortBy, $this->sortDirection)
        ->with('photos')
        ->paginate(5);
    }

    /**
     * The render function
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.news', [
            'data' => $this->read(),
        ]);
    }
}
