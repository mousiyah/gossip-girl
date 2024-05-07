<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use Illuminate\Support\Facades\Log;

class Dashboard extends Component
{
    protected $listeners = ['postsRefreshed' => 'loadPosts'];

    public function render()
    {
        return view('livewire.dashboard', [
            'posts' => Post::latest()->paginate(10),
        ])->layout('layouts.app');
    }
}
