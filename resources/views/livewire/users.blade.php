<div class="py-20 px-20">

    <div class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-6">
        Manage Users
    </div>

    @foreach($users as $user)
        <livewire:manage-user :user="$user" :key="$user->id"/>
    @endforeach

    <!-- Pagination -->
    <div class="mt-4">
        {{ $users->links() }}
    </div>

</div>
