<x-app-layout>
    @slot('title')
        {{ $title }}
    @endslot
    @slot('header')
        {{ $title }}
    @endslot

    <form action="{{ route('videos.create', $playlist->slug) }}" method="post">
        @include('videos._form-control', [
            'submit' => 'Create'
        ])
    </form>
</x-app-layout>