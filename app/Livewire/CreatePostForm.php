<?php

namespace App\Livewire;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreatePostForm extends Component
{
    use WithFileUploads;

    public $content;
    public $images = [];
    public $newImages = [];

    public function render()
    {
        return view('livewire.create-post-form');
    }

    public function updatedNewImages()
    {
        $this->validate([
            'newImages.*' => 'image|max:2048', // max 2MB
        ]);

        $this->images = array_merge($this->images, $this->newImages);
        $this->newImages = [];
    }

    public function removeImage($index)
    {
        unset($this->images[$index]);
        $this->images = array_values($this->images);
    }

    public function submit()
    {
        $validatedData = $this->validate([
            'content' => 'required|string|max:255',
        ]);

        $post = new Post();
        $post->content = $validatedData['content'];
        $post->user_id = Auth::id();
        $post->save();

        // Upload images
        foreach ($this->images as $image) {
            $post->images()->create([
                'path' => $image->store('postImages', 'public'),
            ]);
        }

        // Clear input fields
        $this->reset(['content', 'images']);

        $this->dispatch('postsRefreshed');
    }
}
