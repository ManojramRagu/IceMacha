<div class="min-h-screen bg-gray-50 font-display">
    {{-- HERO SECTION SKELETON --}}
    <div class="relative h-[400px] bg-gray-200 animate-pulse">
        <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4 max-w-4xl mx-auto">
            <div class="w-16 h-1 bg-gray-300 mb-6"></div>
            <div class="h-12 w-64 bg-gray-300 mb-4 rounded-lg"></div>
            <div class="h-6 w-96 bg-gray-300 mb-8 rounded-lg"></div>
            <div class="w-16 h-1 bg-gray-300"></div>
        </div>
    </div>

    {{-- Main Container --}}
    <div class="max-w-7xl mx-auto px-4 py-8 -mt-20 relative z-10">
        {{-- STICKY CATEGORY FILTER SKELETON --}}
        <div class="flex justify-center mb-12">
            <div class="bg-white/80 backdrop-blur-md px-4 py-3 rounded-full shadow-lg border border-white/40 flex gap-2">
                @foreach(range(1, 5) as $i)
                    <div class="h-10 w-24 bg-gray-200 rounded-full animate-pulse"></div>
                @endforeach
            </div>
        </div>

        {{-- PRODUCT GRID SKELETON --}}
        <div>
            <div class="flex items-end gap-6 mb-8">
                <div class="h-8 w-48 bg-gray-200 rounded animate-pulse"></div>
                <div class="h-px flex-grow bg-gray-200 mb-1.5"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach(range(1, 8) as $i)
                    <div class="bg-white rounded-[2rem] shadow-sm overflow-hidden flex flex-col items-center p-6 space-y-4">
                        {{-- Image Area Skeleton --}}
                        <div class="w-full aspect-[4/5] bg-gray-100 rounded-2xl animate-pulse"></div>
                        
                        {{-- Content Skeleton --}}
                        <div class="h-6 w-3/4 bg-gray-100 rounded animate-pulse"></div>
                        <div class="h-4 w-1/2 bg-gray-50 rounded animate-pulse"></div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
