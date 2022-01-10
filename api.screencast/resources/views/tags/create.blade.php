<x-app-layout>
    @slot('title')
        {{ $title }}
    @endslot
    @slot('header')
        {{ $title }}
    @endslot

    <form action="{{ route('tags.create') }}" method="post">
    @include('tags._form-control', [
        'submit' => 'Create'
    ])
    </form>
</x-app-layout>