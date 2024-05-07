<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\Component;

class EditCommentModal extends Component
{
    use WithFileUploads;

    public $comment;
    public $editedContent = "";

    public $editedImages = [];
    public $newEditedImages = [];

    public function save()
    {
        $this->comment->content = $this->editedContent;

        $editedImagePaths = array_column($this->editedImages, 'path');

        // Delete deleted images
        foreach ($this->comment->images as $image) {
            if (!in_array($image->path, $editedImagePaths)) {
                $image->delete();
                Storage::disk('public')->delete($image->path);
            }
        }
        
        // store uploaded images
        foreach ($this->editedImages as $image) {
            if ($image instanceof \Illuminate\Http\UploadedFile) {
                $this->comment->images()->create([
                    'path' => $image->store('postImages', 'public'),
                ]);
            }
        }

        $this->comment->save();

        $this->dispatch('closeCommentEditModal');
    }

    public function cancel()
    {
        $this->dispatch('closeCommentEditModal');
    }

    public function mount($comment)
    {
        $this->comment = $comment;
        $this->editedContent = $this->comment->content;
        $this->editedImages = $comment->images->toArray();
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

    public function render()
    {
        return view('livewire.edit-comment-modal');
    }
}
