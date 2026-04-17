<div class="w-full h-auto p-16 flex items-center justify-center relative {{ empty($aboutUs->aboutUs_background) ? 'bg-[#FAF5F0]' : '' }}" @if(!empty($aboutUs->aboutUs_background)) style="background-image: url('{{ asset($aboutUs->aboutUs_background) }}'); background-size: cover; background-position: center;" @endif>
    @if(!empty($aboutUs->aboutUs_background))
        <div class="absolute inset-0 w-full h-full z-0" style="background: rgba(255,255,255,0.7) url('https://www.transparenttextures.com/patterns/grunge-wall.png') repeat;"></div>
    @endif
    <div class="w-full md:w-2/3 h-auto bg-white grid grid-cols-1 md:grid-cols-2 gap-8 rounded-lg shadow-md p-8 relative z-10">
        <div class="w-full h-auto flex flex-col gap-4">
            <h2 class="text-3xl font-bold text-[#7a4025]">{{ $aboutUs->aboutUs_title }}</h2>
            <p class="text-gray-700 mt-8 whitespace-pre-line">{{ $aboutUs->aboutUs_content }}</p>
        </div>
        <div class="w-full h-auto">
            <img src="{{ asset($aboutUs->aboutUs_image) }}" alt="About Us Image" class="w-full h-auto object-cover">
        </div>
    </div>
</div>
