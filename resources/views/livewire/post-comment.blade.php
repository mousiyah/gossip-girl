<div class="mt-2">
    <div class="flex">
        <a href="{{ url($comment->user->name) }}" class="font-bold text-gray-700 hover:text-primary">
        {{ $comment->user->name }}</a> 
        <div class="ml-1"> {{ $comment->content }} </div>
    </div>

    @if(!$comment->images->isEmpty())
    <div class="w-24">
        <div class="flex whitespace-nowrap my-2">
            @foreach($comment->images as $image)
                <img  src="{{ asset('storage/' . $image->path) }}" alt="Comment image" class="inline-block w-96 mr-2">
            @endforeach
        </div>
    </div>
    @endif

    <div class="flex">
        <div>{{ $comment->created_at->diffForHumans() }}</div>

        @if($this->isCurrentUser($comment->user->id))
        <div class="relative">
            <button wire:click="toggleCommentDropdown" class="hover:text-primary ml-4">
                <i class="fa-solid fa-ellipsis fa-lg"></i>
            </button>
            
            @if($commentDropdownOpen)
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

    @if($showEditModal)
        <div class="fixed z-50 inset-0 overflow-y-auto">
            <livewire:edit-comment-modal :comment="$comment" :key="$comment['id']" />
        </div>
    @endif
</div>