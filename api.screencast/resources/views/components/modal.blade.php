<div {{ $attributes->merge(["class" => "absolute inset-0 w-full h-full bg-black flex justify-center items-center bg-opacity-20"]) }}>
    <div class="bg-white w-1/2 md:max-w-xl rounded-lg shadow-lg overflow-hidden" @click.away="{{ $state }} = false">
        <div class="bg-gray-50 px-5 py-4 border-b flex items-center justify-between">
            <div>{{ $title }}</div>

            <button @click="{{ $state }} = false">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="p-6">
            {{ $slot }}
        </div>
    </div>
</div>