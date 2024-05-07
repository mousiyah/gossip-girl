<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Comment;

class PostComment extends Component
{
    public $comment;
    
    public $commentDropdownOpen = false;
    public $showEditModal = false;

    public function toggleCommentDropdown()
    {
        $this->commentDropdownOpen = !$this->commentDropdownOpen;
    }

    public function isCurrentUser($userId)
    {
        return Auth::check() && $userId === Auth::user()->id;
    }

    public function delete()
    {
        $this->commentDropdownOpen = false;

        foreach ($this->comment->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $this->comment->delete();

        $this->dispatch('commentDeleted', $this->comment->id);
    }

    public function edit()
    {
        $this->showEditModal = true;
        $this->commentDropdownOpen = false;
    }

    protected $listeners = ['closeCommentEditModal'];

    public function closeCommentEditModal()
    {
        $this->showEditModal = false;
    }

    public function mount(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function render()
    {
        return view('livewire.post-comment');
    }
}
