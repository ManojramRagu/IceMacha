<div class="min-h-screen bg-blush flex flex-col">
    <!-- Main Content -->
    <div class="flex-grow flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <!-- Logo -->
            <div class="text-center mb-8">
                <img src="{{ asset('img/logo.webp') }}" alt="IceMacha Logo" class="h-16 w-auto mx-auto rounded-lg">
            </div>

            <!-- Card -->
            <div class="bg-white rounded-3xl shadow-md p-6 md:p-8">
                {{ $slot }}
            </div>
        </div>
    </div>

    <!-- Footer -->
    <x-footer />
</div>
