<div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

    <div class="fixed inset-0 bg-base bg-opacity-75 transition-opacity" aria-hidden="true"></div>

    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true"></span>
    <div
        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
        role="dialog"
        aria-modal="true"
        aria-labelledby="modal-headline">
        
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <label for="content" class="block text-xl font-medium text-gray-700 dark:text-gray-300 ml-1 mb-3">Edit your comment</label>
            <textarea wire:model="editedContent"
            id="{{ rand() }}" name="editedContent" rows="5" 
            placeholder="hey girlies, ..." 
            class="mt-4 focus:ring-primary focus:border-primary block w-full shadow-sm sm:text-sm border-gray-400 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 rounded-md">{{$editedContent}}</textarea>


            <div class="flex flex-wrap mt-4">
                @foreach ($editedImages as $index => $image)
                    <div class="mr-2 mb-2 relative">
                        <button class="absolute top-0 right-0 bg-red-500 text-white m-1 px-2 rounded-full" wire:click="removeImage({{ $index }})">x</button>
                        @if (is_array($image))
                            <img src="{{ asset('storage/' . $image['path']) }}" alt="Selected image" class="h-24">
                        @else
                            <img src="{{ $image->temporaryUrl() }}" alt="Uploaded image" class="h-24">
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="mb-4">
                <label for="editedImages" class="mt-1 inline-flex items-center px-4 py-2 border border-primary text-primary rounded-md font-semibold text-xs bg-white hover:bg-primary hover:text-white transition">
                    <input wire:model="newEditedImages" type="file" id="editedImages" name="editedImages[]" multiple style="display:none;">
                    Add more pics
                </label>
                @error('newImages.*') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            
        </div>

        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <button wire:click="save" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:bg-primary-dark sm:ml-3 sm:w-auto sm:text-sm">
                Save
            </button>
            <button wire:click="cancel" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                Cancel
            </button>
        </div>

    </div>
</div>