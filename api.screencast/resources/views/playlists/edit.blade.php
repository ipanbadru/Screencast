<x-app-layout>
    @slot('title')
        Edit Playlist : {{ $playlist->name }}
    @endslot

    @slot('header')
        Edit Playlist : {{ $playlist->name }}
    @endslot

    <div class="w-full lg:w-1/2">
        <img class="rounded-lg w-full mb-6" src="{{ $playlist->picture }}" alt="{{ $playlist->name }}">
    </div>

    <form action="{{ route('playlists.edit', $playlist->slug) }}" method="POST" enctype="multipart/form-data">
        @method('put')
        @include('playlists._form-control',[
            'submit' => 'Update'
        ])
    </form>
</x-app-layout>