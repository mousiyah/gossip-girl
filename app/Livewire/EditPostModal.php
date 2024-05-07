<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\Component;

class EditPostModal extends Component
{
    use WithFileUploads;

    public $post;
    public $editedContent = "";

    public $editedImages = [];
    public $newEditedImages = [];

    public function mount($post)
    {
        $this->editedImages = $post->images->toArray();
        $this->editedContent = $this->post->content;
    }

    public function removeImage($index)
    {
        unset($this->editedImages[$index]);
        $this->editedImages = array_values($this->editedImages);
    }

    public function updatedNewEditedImages()
    {
        $this->validate([
            'newEditedImages.*' => 'image|max:2048', // max 2MB
        ]);

        $this->editedImages = array_merge($this->editedImages, $this->newEditedImages);
        $this->newEditedImages = [];
    }

    public function save()
    {
        $this->post->content = $this->editedContent;

        $editedImagePaths = array_column($this->editedImages, 'path');

        // Delete deleted images
        foreach ($this->post->images as $image) {
            if (!in_array($image->path, $editedImagePaths)) {
                $image->delete();
                Storage::disk('public')->delete($image->path);
            }
        }
        
        // store uploaded images
        foreach ($this->editedImages as $image) {
            if ($image instanceof \Illuminate\Http\UploadedFile) {
                $this->post->images()->create([
                    'path' => $image->store('postImages', 'public'),
                ]);
            }
        }
    

        $this->post->save();
    
        $this->dispatch('postsRefreshed');
        $this->dispatch('closePostEditModal');
    }

    public function cancel()
    {
        $this->dispatch('closePostEditModal');
    }

    public function render()
    {
        return view('livewire.edit-post-modal');
    }
}
