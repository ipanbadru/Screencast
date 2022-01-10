<x-app-layout>
    @slot('title')
        {{ $title }}
    @endslot
    @slot('header')
        {{ $title }}
    @endslot

    <form action="{{ route('tags.edit', $tag->slug) }}" method="post">
        @method('put')
        @include('tags._form-control', [
            'submit' => 'Update'
        ])
    </form>
</x-app-layout>