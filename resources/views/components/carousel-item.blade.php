@props(['title', 'description', 'image', 'link'])

<a href="{{ $link }}"
    class="w-[20rem] h-full snap-center rounded-2xl overflow-hidden relative group cursor-pointer hover:scale-105 transition-transform duration-300 flex-shrink-0 block">
    <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-t from-[#7B1929]/80  to-[#FF4848]/0 via-65% "></div>
    <div class="absolute inset-0 bg-gradient-to-b from-[#BD4D60]/10 to-[#BD4D60]/10 "></div>
    <div class="absolute bottom-0 left-0 right-0 p-4">
        <h3 class="text-h3 text-white mb-1 line-clamp-2">{{ $title }}</h3>
        <p class="text-white text-body line-clamp-2">{{ $description }}</p>
    </div>
</a>