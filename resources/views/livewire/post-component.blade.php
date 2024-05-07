<div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg mb-8">
    <div class="p-6">
        
    <div class="flex justify-between">
            <a href="{{ url($post->user->name) }}" class="font-semibold text-lg mb-2 hover:text-primary">
                {{ $post->user->name }}</a>

            @if($this->isCurrentUser($post->user->id))
            <div class="relative">
                <button wire:click="togglePostDropdown" class="hover:text-primary">
                    <i class="fa-solid fa-ellipsis fa-lg"></i>
                </button>
                
                @if($postDropdownOpen)
                <div class="absolute left-0 mt-2 w-36 bg-white dark:bg-gray-800 rounded-md shadow-lg z-10">
                    <div class="py-1">
                        <button wire:click="edit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">Edit</a>
                        <button wire:click="delete" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">Delete</a>
                    </div>
                </div>
                @endif
            </div>
            @endif

        </div>

        <div class="text-gray-700 dark:text-gray-300">
            {{ $post->content }}
            <div class="overflow-x-auto">
                <div class="flex whitespace-nowrap mt-4">
                    @foreach($post->images as $image)
                        <img  src="{{ asset('storage/' . $image->path) }}" alt="Post image" class="inline-block w-96 mr-4">
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
            <div class="flex justify-between items-center mb-2">
                <div class="flex">
                    @auth
                    <button wire:click="toggleLike"
                            class="text-gray-500 {{ $this->likedByUser() ? 'text-primary' : 'hover:text-primary ' }} mr-2">
                        <i class="fas fa-heart fa-xl"></i>
                    </button>
                    @endauth
                    <span>{{ $post->likedBy()->count() }} likes</span>
                </div>
                <div>{{ $post->created_at->diffForHumans() }}</div>
            </div>

            @auth
            <form wire:submit.prevent="addComment" class="mt-4 mb-4">
                <div class="flex mb-1">
                    <input wire:model="newComment" type="text" id="{{ rand() }}" name="comment" 
                        placeholder="What do you think?" 
                        class="mr-2 w-full border-gray-300 dark:border-gray-600 rounded-md px-4 py-1 focus:outline-none focus:ring-primary focus:border-primary dark:focus:primary">

                    <label for="commentImages_{{$post->id}}" class="text-primary ml-2 font-semibold rounded-md content-center">
                        <input wire:model="newCommentImages" type="file" id="commentImages_{{$post->id}}" name="commentImages[]" multiple style="display:none;">
                            <i class="fa-solid fa-images"></i>
                     </label>

                    <button type="submit" class="text-primary ml-4 font-semibold rounded-md">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>

                </div>

                @if ($commentImages)
                <div class="mt-4 flex">
                    @foreach ($commentImages as $index => $commentImage)
                        <div class="mr-2 mb-2 relative">
                            <div class="absolute top-0 right-0 bg-red-500 text-white m-1 px-2 rounded-full" wire:click="removeCommentImage({{ $index }})">x</div>
                            <img src="{{ $commentImage->temporaryUrl() }}" alt="Comment selected image" class="h-24">
                        </div>
                    @endforeach 
                </div>
                @endif
                @error('newComment') <span class="text-red-500">{{ $message }}</span> @enderror
            </form>
            @endauth

            <div class="flex">
                <div>{{ $post->comments()->count() }} comments</div>
                @if(!$post->comments->isEmpty())
                <button wire:click="toggleCommentsVisibility" 
                class="ml-4 underline underline-offset-2 hover:text-primary">
                {{ $showComments ? 'Hide comments' : 'View comments' }}</button>
                @endif
            </div>

            @if($showComments)
            <div>
                @foreach($post->comments->sortByDesc('created_at') as $comment)
                    <livewire:post-comment :comment="$comment" :key="$comment['id']" />
                @endforeach
            </div>
            @endif


        </div>
    </div>
    @if($showEditModal)
        <div class="fixed z-50 inset-0 overflow-y-auto">
            <livewire:edit-post-modal :post="$post" :key="$post['id']" />
        </div>
    @endif
    
</div>

