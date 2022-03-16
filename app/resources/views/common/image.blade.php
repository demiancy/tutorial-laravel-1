<img 
    @if ($image && Storage::disk($storage)->exists($image))
        src="{{ Storage::disk($storage)->url($image) }}" 
    @else
        src="/theme/img/default.jpg" 
    @endif
    alt="Imagen de {{ $alt }}" 
    height="70" 
    width="80" 
    class="rounded"
>