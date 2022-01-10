@csrf

<div class="mb-6 w-full lg:w-/2">
    <x-label for="name">Name</x-label>
    <x-input type="text" name="name" id="name" value="{{ old('name') ?? $tag->name }}" class="mt-2 w-full" placeholder="Laravel"/>
    @error('name')
        <span class="text-red-500 mt-2">{{ $message }}</span>
    @enderror
</div>

<x-button>{{ $submit }}</x-button>