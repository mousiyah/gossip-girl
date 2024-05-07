<div class="py-20 px-20">

    @auth
    <!-- Create Post -->
    <div class="mb-8">
        <livewire:create-post-form>
    </div>
    @endauth

    <!-- Latest Posts -->
    @foreach($posts as $post)
        <livewire:post-component :post="$post" :key="$post->id"/>
    @endforeach

    <!-- Pagination -->
    <div class="mt-4">
        {{ $posts->links() }}
    </div>
</div>

