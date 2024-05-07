<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class ManageUser extends Component
{

    public $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function delete()
    {
        $this->user->delete();
        $this->dispatch('usersRefreshed');
    }

    public function render()
    {
        return view('livewire.manage-user');
    }
}
