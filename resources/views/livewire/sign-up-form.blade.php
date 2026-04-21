<form wire:submit.prevent="register" class="w-full max-w-md mx-auto flex flex-col gap-4 mt-8">
    <div class="flex flex-row justify-between">
        <div>
            <label for="fname" class="block text-sm font-medium text-gray-700">First Name</label>
            <input type="text" id="fname" wire:model.defer="fname" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-[#7a4025] focus:ring-[#7a4025]" required>
            @error('fname') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div>
            <label for="lname" class="block text-sm font-medium text-gray-700">Last Name</label>
            <input type="text" id="lname" wire:model.defer="lname" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-[#7a4025] focus:ring-[#7a4025]" required>
            @error('lname') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
    </div>
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" id="email" wire:model.defer="email" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-[#7a4025] focus:ring-[#7a4025]" required>
        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
    </div>
    <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input type="password" id="password" wire:model.defer="password" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-[#7a4025] focus:ring-[#7a4025]" required>
        @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
    </div>
    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
        <input type="password" id="password_confirmation" wire:model.defer="password_confirmation" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-[#7a4025] focus:ring-[#7a4025]" required>
    </div>
    <button type="submit" class="bg-[#7a4025] text-white py-2 rounded hover:bg-[#63321c] font-semibold flex items-center justify-center gap-2" @if($isLoading) disabled @endif>
        <span wire:loading wire:target="register">
            <svg class="animate-spin h-5 w-5 mr-2 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
            </svg>
        </span>
        <span>Sign Up</span>
    </button>
    <div class="flex items-center justify-center mt-4">
        <span class="text-gray-500 text-sm">or</span>
    </div>
    <div class="flex items-center justify-center">
        <a href="{{ route('socialite.redirect', ['provider' => 'google']) }}" class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded hover:bg-gray-50">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="w-5 h-5"><g><path fill="#4285F4" d="M24 9.5c3.54 0 6.73 1.22 9.24 3.23l6.92-6.92C36.68 2.36 30.77 0 24 0 14.61 0 6.4 5.82 2.47 14.09l8.06 6.26C12.36 14.09 17.68 9.5 24 9.5z"/><path fill="#34A853" d="M46.1 24.5c0-1.64-.15-3.22-.42-4.74H24v9.04h12.4c-.54 2.92-2.18 5.39-4.65 7.06l7.18 5.59C43.6 37.36 46.1 31.39 46.1 24.5z"/><path fill="#FBBC05" d="M10.53 28.35c-1.01-2.99-1.01-6.21 0-9.2l-8.06-6.26C.82 17.36 0 20.57 0 24c0 3.43.82 6.64 2.47 9.11l8.06-6.26z"/><path fill="#EA4335" d="M24 48c6.77 0 12.47-2.24 16.62-6.09l-7.18-5.59c-2.01 1.35-4.59 2.16-7.44 2.16-6.32 0-11.64-4.59-13.47-10.77l-8.06 6.26C6.4 42.18 14.61 48 24 48z"/><path fill="none" d="M0 0h48v48H0z"/></g></svg>
            <span>Sign up with Google</span>
        </a>
    </div>
</form>
@if($showWelcomeModal)
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-lg shadow-lg p-8 max-w-sm w-full text-center">
            <h2 class="text-2xl font-bold mb-4 text-[#7a4025]">Welcome to LadyG Arts & Crafts</h2>
            <p class="mb-6 text-gray-700">Your account has been created successfully!</p>
            <button wire:click="redirectToHome" class="bg-[#7a4025] text-white px-6 py-2 rounded hover:bg-[#63321c] font-semibold w-full">Go to Home</button>
        </div>
    </div>
@endif
