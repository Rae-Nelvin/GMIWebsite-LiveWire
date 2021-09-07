<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\WebPhotos;
use App\Models\WebContents;

class Dashboard extends Component
{
    /**
     * The galleries read function.
     *
     * @return void
     */
    public function galleries()
    {
        return WebPhotos::where('section','=','Galleries')->get();
    }
    
    /**
     * The news read function.
     *
     * @return void
     */
    public function news()
    {
        return WebContents::where('section','=','News')->get();
    }
    
    /**
     * The admins read function.
     *
     * @return void
     */
    public function admins()
    {
        return WebContents::where('section','=','Admins')->get();
    }
    
    /**
     * The links read function.
     *
     * @return void
     */
    public function links()
    {
        return WebContents::where('section','=','Links')->get();
    }
    
    /**
     * The roles read function.
     *
     * @return void
     */
    public function roles()
    {
        return WebContents::where('section','=','TTTRoles')->get();
    }

    /**
     * The render function.
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.dashboard', [
            'galleries' => $this->galleries(),
            'news' => $this->news(),
            'admins' => $this->admins(),
            'links' => $this->links(),
            'roles' => $this->roles(),
        ]);
    }
}
