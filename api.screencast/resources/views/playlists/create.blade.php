<x-app-layout>
    @slot('title')
        Create new playlists
    @endslot

    @slot('header')
        Create New Playlists
    @endslot

    <form action="{{ route('playlists.create') }}" method="POST" enctype="multipart/form-data" novalidate>
        @include('playlists._form-control',[
            'submit' => 'Create'
        ])
    </form>
</x-app-layout>