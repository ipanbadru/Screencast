<x-app-layout>
    @slot('title')
        {{ $title }}
    @endslot
    @slot('header')
        {{ $title }}
    @endslot

    <form action="{{ route('videos.edit', [$playlist->slug, $video->unique_video_id]) }}" method="post">
        @method('put')
        @include('videos._form-control', [
            'submit' => 'Update'
        ])
    </form>
</x-app-layout>