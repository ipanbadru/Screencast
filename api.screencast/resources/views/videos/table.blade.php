<x-app-layout>
    @slot('title')
        {{ $title }}
    @endslot

    @slot('header')
        {{ $title }}
    @endslot

    <x-table>
        <tr>
            <x-th>#</x-th>
            <x-th>Name</x-th>
            <x-th>Intro</x-th>
            <x-th>Action</x-th>
        </tr>

        @foreach ($videos as $video)
            <tr>
                <x-td>{{ $videos->count() * ($videos->currentPage() - 1) + $loop->iteration }}</x-td>
                <x-td>{{ $video->title }}</x-td>
                <x-td>
                    <span class="text-xs font-semibold">{{ $video->intro ? 'Yes' : 'No' }}</span>
                </x-td>
                <x-td>
                    <div class="flex items-center">
                        <a class="mr-2 text-blue-500 hover:text-blue-600 font-medium underline uppercase text-xs" href="{{ route('videos.edit', [$playlist, $video->unique_video_id]) }}">Edit</a>
                        <div x-data="{ modalIsOpen : false }">
                            <x-modal state="modalIsOpen" x-show="modalIsOpen" title="Are You Sure ?">
                                <div class="mb-4">
                                    <h4 class="text-lg capitalize">{{ $video->title }}</h4>
                                    <span class="text-sm text-gray-500">Episode {{ $video->episode }}
                                    -
                                    Runtime {{ $video->runtime }}</span>
                                </div>
                                <div class="inline-flex items-center">
                                    <form class="mr-2" action="{{ route('videos.delete',[$playlist->slug, $video->unique_video_id]) }}" method="post">
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

    {{ $videos->links() }}
</x-app-layout>