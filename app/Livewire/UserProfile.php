<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class UserProfile extends Component
{

    public $username;

    public function mount($username)
    {
        $this->username = $username;
    }
    
    public function render()
    {
        $user = User::where('name', $this->username)->firstOrFail();

        return view('livewire.user-profile', [
            'userPosts' => $user->posts()->latest()->paginate(10),
        ])->layout('layouts.app');
    }
}
