@csrf

<div class="mb-6">
    <x-label for="title" :value="__('Title')" />
    <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title') ?? $video->title" autofocus />
    @error('title')
        <span class="text-red-500 mt-2">{{ $message }}</span>
    @enderror
</div>

<div class="mb-6">
    <x-label for="unique_video_id" :value="__('Unique Code')" />
    <x-input id="unique_video_id" class="block mt-1 w-full" type="text" name="unique_video_id" :value="old('unique_video_id') ?? $video->unique_video_id" />
    @error('unique_video_id')
        <span class="text-red-500 mt-2">{{ $message }}</span>
    @enderror
</div>

<div class="flex lg:-mx-2">
    <div class="lg:px-2 w-full lg:w-1/2 mb-6">
        <x-label for="episode" :value="__('Episode')" />
        <x-input id="episode" class="block mt-1 w-full" type="text" name="episode" :value="old('episode') ?? $video->episode" />
        @error('episode')
            <span class="text-red-500 mt-2">{{ $message }}</span>
        @enderror
    </div>
    <div class="lg:px-2 w-full lg:w-1/2 mb-6">
        <x-label for="runtime" :value="__('Runtime')" />
        <x-input id="runtime" class="block mt-1 w-full" type="text" name="runtime" :value="old('runtime') ?? $video->runtime" />
        @error('runtime')
            <span class="text-red-500 mt-2">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="mb-6">
    <label for="intro" class="flex items-center">
        <input type="checkbox" name="intro" id="intro" {{ $video->intro ? 'checked' : '' }} class="mr-2 focus:outline-none focus:ring focus:ring-transparent text-blue-500 rounded border-gray-300">
        <span class="select-none font-medium uppercase text-sm">Intro</span>
    </label>
</div>

<x-button>{{ $submit }}</x-button>