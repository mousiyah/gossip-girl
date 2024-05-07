<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Notifications\NewCommentNotification;
use App\Notifications\NewLikeNotification;

use Livewire\Component;
use App\Models\Post;
use App\Models\Comment;

use Livewire\WithFileUploads;

class PostComponent extends Component
{
    use WithFileUploads;

    public $post;
    public $isLikedByCurrentUser;
    public $showComments = false;
    public $newComment = '';

    public $postDropdownOpen = false;
    public $showEditModal = false;

    public $commentImages = [];
    public $newCommentImages = [];

    public function updatedNewCommentImages()
    {
        $this->validate([
            'newCommentImages.*' => 'image|max:2048', // max 2MB
        ]);

        $this->commentImages = array_merge($this->commentImages, $this->newCommentImages);
        $this->newCommentImages = [];
    }

    public function removeCommentImage($index)
    {
        unset($this->commentImages[$index]);
        $this->commentImages = array_values($this->commentImages);
    }

    public function mount(Post $post)
    {
        $this->post = $post;
    }

    public function render()
    {
        return view('livewire.post-component');
    }

    public function isCurrentUser($userId)
    {
        return Auth::check() && $userId === Auth::user()->id;
    }

    public function toggleLike()
    {
        if ($this->likedByUser()) {
            $this->post->likedBy()->detach(Auth::id());
        } else {
            $this->post->likedBy()->attach(Auth::id());
            $this->post->user->notify(new NewLikeNotification($this->post));
        }
    }
        

    public function likedByUser()
    {
        return $this->post->likedBy()->where('user_id', Auth::id())->exists();
    }

    public function toggleCommentsVisibility()
    {
        $this->showComments = !$this->showComments;
    }

    public function addComment()
    {
        // Validate
        $this->validate([
            'newComment' => 'required|max:255',
        ]);

        // Create new comment
        $comment = new Comment();
        $comment->content = $this->newComment;
        $comment->user_id = Auth::id();
        $comment->post_id = $this->post->id;
        $comment->save();

        // Upload images
        foreach ($this->commentImages as $commentImage) {
            $comment->images()->create([
                'path' => $commentImage->store('postImages', 'public'),
            ]);
        }

        $this->post->user->notify(new NewCommentNotification($comment, $this->post));

        // Clear
        $this->reset(['newComment', 'commentImages']);
        $this->newComment = '';

    }

    public function togglePostDropdown()
    {
        $this->postDropdownOpen = !$this->postDropdownOpen;
    }

    public function delete()
    {
        $this->postDropdownOpen = false;

        foreach ($this->post->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        foreach ($this->post->comments as $comment) {
            foreach ($comment->images as $image) {
                Storage::disk('public')->delete($image->path);
            }
        }

        $this->post->delete();
        
        $this->dispatch('postsRefreshed');
    }

    public function edit()
    {
        $this->showEditModal = true;
        $this->postDropdownOpen = false;
    }

    protected $listeners = ['closePostEditModal', 'commentDeleted' => 'removeDeletedComment'];
    
    public function closePostEditModal()
    {
        $this->showEditModal = false;
    }

    public function removeDeletedComment($deletedCommentId)
    {
        $this->post->comments = $this->post->comments->filter(function ($comment) use ($deletedCommentId) {
            return $comment->id !== $deletedCommentId;
        });
    }


}
