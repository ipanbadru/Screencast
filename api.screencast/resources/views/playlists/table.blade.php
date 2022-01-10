<x-app-layout>
    @slot('title')
        Your Playlists
    @endslot

    @slot('header')
        Your Playlists
    @endslot

    <x-table>
        <tr>
            <x-th>#</x-th>
            <x-th>Name</x-th>
            <x-th>Published</x-th>
            <x-th>Action</x-th>
        </tr>

        @foreach ($playlists as $playlist)
            <tr>
                <x-td>{{ $playlists->count() * ($playlists->currentPage() - 1) + $loop->iteration }}</x-td>
                <x-td>
                    <div>
                        <div>
                            <a class="block text-blue-500 hover:text-blue-600 hover:underline text-sm" href="{{ route('videos.table', $playlist->slug) }}">
                                {{ $playlist->name }}
                            </a>
                        </div>
                        @foreach ($playlist->tags as $tag)
                            <span class="mr-1 text-xs">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                </x-td>
                <x-td>{{ $playlist->created_at->format('d F, Y') }}</x-td>
                <x-td>
                    <div class="inline-flex items-center">
                        <a
                        class="text-blue-500 hover:text-blue-600 font-medium underline text-sm"
                        href="{{ route('videos.create', $playlist->slug) }}">Add</a>
                        <a
                        class="mx-2 text-blue-500 hover:text-blue-600 font-medium underline text-sm"
                        href="{{ route('playlists.edit', $playlist->slug) }}">Edit</a>
                        <div x-data="{ modalIsOpen : false }">
                            <x-modal state="modalIsOpen" x-show="modalIsOpen" title="Are You Sure ?">
                                <div class="inline-flex items-center">
                                    <form class="mr-2" action="{{ route('playlists.delete', $playlist->slug) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <x-button type="submit">
                                            Yes
                                        </x-button>
                                    </form>
                                    <x-button type="button" @click="modalIsOpen = false">
                                        Nope
                                    </x-button>
                                </div>
                            </x-modal>
                            <button @click="modalIsOpen = true" class="focus:outline-none text-red-500 hover:text-red-600 font-medium underline text-sm" type="button">
                                Delete
                            </button>
                        </div>
                    </div>
                </x-td>
            </tr>
        @endforeach
    </x-table>

    {{ $playlists->links() }}
</x-app-layout>