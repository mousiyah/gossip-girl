<form wire:submit.prevent="submit" class="mb-6" enctype="multipart/form-data">
    @csrf
    <div class="mb-4">
        <label for="content" class="block text-xl font-medium text-gray-700 dark:text-gray-300 ml-1 mb-3">Spill the tea ☕️ here</label>
        <textarea wire:model="content" id="{{ rand() }}" name="content" rows="5" placeholder="hey girlies, ..." class="mt-4 mb-1 focus:ring-primary focus:border-primary block w-full shadow-sm sm:text-sm border-white dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 rounded-md"></textarea>
        @error('content') <span class="text-red-500">{{ $message }}</span> @enderror
    </div>
    <div class="mb-4">
        <label for="images" class="mt-1 inline-flex items-center px-4 py-2 border border-primary text-primary rounded-md font-semibold text-xs bg-white tracking-widest hover:bg-primary hover:text-white transition">
            <input wire:model="newImages" type="file" id="images" name="images[]" multiple style="display:none;">
            add some pics
        </label><br>
        @error('newImages.*') <span class="text-red-500">{{ $message }}</span> @enderror
    </div>
    <div class="mb-4 flex">
        @if ($images)
            @foreach ($images as $index => $image)
                <div class="mr-2 mb-2 relative">
                    <div class="absolute top-0 right-0 bg-red-500 text-white m-1 px-2 rounded-full" wire:click="removeImage({{ $index }})">x</div>
                    <img src="{{ $image->temporaryUrl() }}" alt="Selected image" class="h-24">
                </div>
            @endforeach
        @endif
    </div>
    <div class="flex justify-end">
        <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-dark focus:outline-none transition">Post</button>
    </div>
</form>
