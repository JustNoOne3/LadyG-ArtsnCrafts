<x-filament::modal id="logout-modal" class="light z-50">
    <style>
        .fi-modal-window {
            /* background-color: rgb(254 243 199 / var(--tw-bg-opacity, 1)); */
            background-color: #ffffff;
            max-width: 90vw ;
            width: 700px ;
        }
        
        :root {
            color-scheme: light;
        }
    </style>
    <x-slot name="trigger">
        <a class="text-[#8c370f] hover:text-[#BA4B18] transition">Log out</a>
    </x-slot>

    <div class="p-8 w-full text-center">
        <h2 class="text-2xl font-bold mb-4 text-[#7a4025]">Confirm Logout</h2>
        <p class="mb-6 text-gray-700">Are you sure you want to log out?</p>
        <div class="flex gap-4 justify-center">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-[#7a4025] text-white px-6 py-2 rounded hover:bg-[#63321c] font-semibold">Yes, Log out</button>
            </form>
            <button wire:click="closeModal" class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400 font-semibold">Cancel</button>
        </div>
    </div>
</x-filament::modal>