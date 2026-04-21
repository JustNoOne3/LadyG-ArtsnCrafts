<form method="POST" action="{{ route('login') }}" class="w-full max-w-md mx-auto flex flex-col gap-4 mt-8">
    @csrf
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" id="email" name="email" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-[#7a4025] focus:ring-[#7a4025]" required autofocus>
        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
    </div>
    <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input type="password" id="password" name="password" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-[#7a4025] focus:ring-[#7a4025]" required>
        @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
    </div>
    <button type="submit" class="bg-[#7a4025] text-white py-2 rounded hover:bg-[#63321c] font-semibold">Log In</button>
    <div class="flex items-center justify-center mt-4">
        <span class="text-gray-500 text-sm">or</span>
    </div>
    <div class="flex items-center justify-center">
        <a href="{{ route('socialite.redirect', ['provider' => 'google']) }}" class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded hover:bg-gray-50">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="w-5 h-5"><g><path fill="#4285F4" d="M24 9.5c3.54 0 6.73 1.22 9.24 3.23l6.92-6.92C36.68 2.36 30.77 0 24 0 14.61 0 6.4 5.82 2.47 14.09l8.06 6.26C12.36 14.09 17.68 9.5 24 9.5z"/><path fill="#34A853" d="M46.1 24.5c0-1.64-.15-3.22-.42-4.74H24v9.04h12.4c-.54 2.92-2.18 5.39-4.65 7.06l7.18 5.59C43.6 37.36 46.1 31.39 46.1 24.5z"/><path fill="#FBBC05" d="M10.53 28.35c-1.01-2.99-1.01-6.21 0-9.2l-8.06-6.26C.82 17.36 0 20.57 0 24c0 3.43.82 6.64 2.47 9.11l8.06-6.26z"/><path fill="#EA4335" d="M24 48c6.77 0 12.47-2.24 16.62-6.09l-7.18-5.59c-2.01 1.35-4.59 2.16-7.44 2.16-6.32 0-11.64-4.59-13.47-10.77l-8.06 6.26C6.4 42.18 14.61 48 24 48z"/><path fill="none" d="M0 0h48v48H0z"/></g></svg>
            <span>Log in with Google</span>
        </a>
    </div>
</form>
