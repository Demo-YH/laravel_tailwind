<x-app>
    <x-slot:header>
        <x-header />
    </x-slot:header>

    <x-slot:sidebar>
        <x-sidebar :categories="$categories" />
    </x-slot:sidebar>

    <section>
    <div class="px-8 py-8 mx-auto bg-white">
        <div class="flex items-center justify-between">
            <span class="text-sm font-light text-gray-600">最終更新日時:{{ $post->updated_at }}</span>
        </div>

        <div class="mt-2">
            <p class="text-2xl font-bold text-gray-800">{{ $post->title }}</p>
            <p class="mt-8 text-gray-600">{{ $post->body }}</p>
        </div>
    </div>
    </section>

    <x-slot:footer>
        <x-footer />
    </x-slot:footer>
</x-app>