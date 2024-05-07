<div class="py-20 px-20">

    <!-- User Info -->
    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg mb-8">
    <div class="p-6">

        <div class="text-3xl font-semibold text-gray-800 dark:text-gray-200">{{ $username }}</div>

        <div class="text-md font-semibold text-gray-500 dark:text-gray-200 mt-4">{{ $userPosts->count() }} posts</div>
        </div>
    </div>

    <div class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-6">
        @auth
            @if(auth()->user()->name == $username)
                My posts
            @else
                {{ $username }}'s posts
            @endif
        @else
            {{ $username }}'s posts
        @endauth
    </div>

    <!-- User's Posts -->
    @foreach($userPosts as $post)
        <livewire:post-component :post="$post" :key="$post->id"/>
    @endforeach

    <!-- Pagination -->
    <div class="mt-4">
        {{ $userPosts->links() }}
    </div>
</div>
