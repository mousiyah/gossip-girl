<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\User;

class Users extends Component
{

    protected $listeners = ['usersRefreshed' => 'loadUsers'];

    public function render()
    {
        $currentUser = Auth::user();
        $users = User::where('id', '!=', $currentUser->id)
                     ->latest()
                     ->paginate(10);

        return view('livewire.users', [
            'users' => $users,
        ])->layout('layouts.app');
    }
}
