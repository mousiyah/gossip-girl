<div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg mb-3">
    <div class="p-6 flex">

        <div class="text-xl font-semibold text-gray-800 dark:text-gray-200">{{ $user->name }}</div>

        <div class="flex w-full justify-end content-center">
            <div class="text-md font-semibold content-center text-gray-400 dark:text-gray-200 mr-6">
                Created at: {{ $user->created_at }}
            </div>
            <x-primary-button wire:click="delete">Delete</x-primary-button>
        </div>        

    </div>
</div>