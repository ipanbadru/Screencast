@csrf
<div class="mb-6">
    <input type="file" name="thumbnail" id="thumbnail" class="block">
    @error('thumbnail')
        <span class="text-red-500 mt-2">{{ $message }}</span>
    @enderror
</div>
<div class="mb-6">
    <x-label for="name" :value="__('Name')" />
    <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name') ?? $playlist->name" required autofocus />
    @error('name')
        <span class="text-red-500 mt-2">{{ $message }}</span>
    @enderror
</div>
<div class="mb-6">
    <x-label for="price" :value="__('Price')" />
    <x-input id="price" class="block mt-1 w-full" type="text" name="price" :value="old('price') ?? $playlist->price" />
    @error('price')
        <span class="text-red-500 mt-2">{{ $message }}</span>
    @enderror
</div>
<div class="mb-6">
    <x-label for="description" :value="__('Description')" />
    <x-textarea id="description" name="description">{{ old('description') ?? $playlist->description }}</x-textarea>
    @error('description')
        <span class="text-red-500 mt-2">{{ $message }}</span>
    @enderror
</div>
<div class="mb-6">
    <x-label for="tags" value="Tags" />
    <select multiple name="tags[]" id="tags" class="rounded-md w-full mt-2 shadow-sm border-gray-300 focus:border-blue-700 focus:ring focus:ring-blue-200">
        @foreach ($tags as $tag)
            <option {{ $playlist->tags()->find($tag->id) ? 'selected' : '' }} value="{{ $tag->id }}">{{ $tag->name }}</option>
        @endforeach
    </select>
</div>
<x-button>{{ $submit }}</x-button>