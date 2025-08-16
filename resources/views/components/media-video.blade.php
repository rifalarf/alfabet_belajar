@props(['path', 'class' => ''])

@php
    use Illuminate\Support\Str;
    $url = $path;
    $ytId = null;
    if ($url && preg_match('#(?:youtube\.com/(?:watch\?v=|embed/|shorts/)|youtu\.be/)([A-Za-z0-9_\-]{6,})#i', $url, $m)) {
        $ytId = $m[1];
    }
@endphp

<div class="flex flex-col h-full">
    <div class="relative w-full rounded-lg overflow-hidden aspect-[9/16] {{ $class }}">
        @if($ytId)
            <iframe
                src="https://www.youtube-nocookie.com/embed/{{ $ytId }}?controls=1&showinfo=0&rel=0&iv_load_policy=3&loop=1&playlist={{ $ytId }}"
                title="YouTube video"
                loading="lazy"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen
                class="w-full h-full border-0"></iframe>
        @elseif($url)
            <video src="{{ Str::startsWith($url, ['http://','https://']) ? $url : asset($url) }}" controls class="w-full rounded-lg aspect-video"></video>
        @else
            <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-500 text-sm">
                Tidak ada video
            </div>
        @endif
    </div>

    {{-- Slot untuk tombol atau konten tambahan --}}
    @if(isset($slot) && !$slot->isEmpty())
        <div class="mt-2">
            {{ $slot }}
        </div>
    @endif
</div>