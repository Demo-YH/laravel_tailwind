<x-user-app>
    <x-slot:sidebar_user>
        <x-sidebar_user />
    </x-slot:sidebar_user>

    <section>
        <div class="px-8 py-8 mx-auto bg-white">
            <div class="flex items-center justify-between">
                <span class="text-sm font-light text-gray-600">{{ $showPostData->updated_at }}</span>
            </div>

            <div class="mt-2">
                <p class="text-2xl font-bold text-gray-800">{{ $showPostData->title }}</p>
                <p class="mt-8 text-gray-600">{{ $showPostData->body }}</p>
            </div>
        </div>
    </section>
</x-user-app>