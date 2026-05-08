
<div class="max-w-5xl mx-auto py-12 font-poppins">
    @if (session()->has('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg shadow-sm flex items-center gap-2 animate-fade-in">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    <div class="flex flex-col gap-10">
        <div class="flex flex-col md:flex-row gap-8">
            <div class="flex-1 bg-white shadow-xl rounded-3xl p-8 border border-[#f3e7d9]">
                <form wire:submit.prevent="updateProfile" autocomplete="off">
                    <h2 class="text-2xl font-bold mb-8 text-[#7a4025] tracking-tight">Profile Information</h2>
                    <div class="flex flex-col items-center mb-8">
                        <div class="relative group">
                            @if ($avatar || $new_avatar)
                                <img src="{{ $new_avatar ? $new_avatar->temporaryUrl() : asset('storage/' . ltrim($avatar, '/')) }}" class="w-28 h-28 rounded-full object-cover border-4 border-[#d19658] shadow-lg transition-transform duration-300 group-hover:scale-105" alt="Avatar">
                            @else
                                <div class="w-28 h-28 rounded-full bg-[#e6d9cb] flex items-center justify-center border-4 border-[#d19658] shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#7a4025" class="w-14 h-14">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 19.125a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21c-2.676 0-5.216-.584-7.499-1.875z" />
                                    </svg>
                                </div>
                            @endif
                            <label class="absolute bottom-2 right-2 bg-[#d19658] text-white rounded-full p-2 cursor-pointer shadow-lg border-2 border-white hover:bg-[#ba4b18] transition group-hover:scale-110">
                                <input type="file" wire:model="new_avatar" class="hidden" accept="image/*">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487a2.25 2.25 0 113.182 3.182L7.5 20.182 3 21l.818-4.5L16.862 4.487z" />
                                </svg>
                            </label>
                        </div>
                        @error('new_avatar') <span class="text-red-600 text-sm mt-2">{{ $message }}</span> @enderror
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="relative">
                            <input type="text" wire:model.defer="firstname" id="firstname" class="peer w-full border-2 border-[#e6d9cb] rounded-lg px-4 pt-6 pb-2 focus:outline-none focus:border-[#d19658] bg-transparent placeholder-transparent transition" placeholder="First Name" />
                            <label for="firstname" class="absolute left-4 top-2 text-[#7a4025] text-sm transition-all peer-placeholder-shown:top-6 peer-placeholder-shown:text-base peer-focus:top-2 peer-focus:text-sm">First Name</label>
                            @error('firstname') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="relative">
                            <input type="text" wire:model.defer="lastname" id="lastname" class="peer w-full border-2 border-[#e6d9cb] rounded-lg px-4 pt-6 pb-2 focus:outline-none focus:border-[#d19658] bg-transparent placeholder-transparent transition" placeholder="Last Name" />
                            <label for="lastname" class="absolute left-4 top-2 text-[#7a4025] text-sm transition-all peer-placeholder-shown:top-6 peer-placeholder-shown:text-base peer-focus:top-2 peer-focus:text-sm">Last Name</label>
                            @error('lastname') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="mb-8 relative">
                        <input type="email" wire:model.defer="email" id="email" class="peer w-full border-2 border-[#e6d9cb] rounded-lg px-4 pt-6 pb-2 focus:outline-none focus:border-[#d19658] bg-transparent placeholder-transparent transition" placeholder="Email" />
                        <label for="email" class="absolute left-4 top-2 text-[#7a4025] text-sm transition-all peer-placeholder-shown:top-6 peer-placeholder-shown:text-base peer-focus:top-2 peer-focus:text-sm">Email</label>
                        @error('email') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-[#d19658] to-[#ba4b18] text-white font-semibold py-3 rounded-xl shadow-md hover:from-[#ba4b18] hover:to-[#d19658] transition text-lg tracking-wide">Save Changes</button>
                </form>
            </div>
            <div class="flex-1 bg-white shadow-xl rounded-3xl p-8 border border-[#f3e7d9]">
                <form wire:submit.prevent="updatePassword" autocomplete="off" class="flex flex-col">
                    <h2 class="text-2xl font-bold mb-8 text-[#7a4025] tracking-tight">Change Password</h2>
                    <div class="grid grid-cols-1 gap-6 mb-8">
                        <div class="relative md:col-span-1">
                            <input type="password" wire:model.defer="current_password" id="current_password" class="peer w-full border-2 border-[#e6d9cb] rounded-lg px-4 pt-6 pb-2 focus:outline-none focus:border-[#d19658] bg-transparent placeholder-transparent transition" placeholder="Current Password" />
                            <label for="current_password" class="absolute left-4 top-2 text-[#7a4025] text-sm transition-all peer-placeholder-shown:top-6 peer-placeholder-shown:text-base peer-focus:top-2 peer-focus:text-sm">Current Password</label>
                            @error('current_password') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="relative md:col-span-1">
                            <input type="password" wire:model.defer="new_password" id="new_password" class="peer w-full border-2 border-[#e6d9cb] rounded-lg px-4 pt-6 pb-2 focus:outline-none focus:border-[#d19658] bg-transparent placeholder-transparent transition" placeholder="New Password" />
                            <label for="new_password" class="absolute left-4 top-2 text-[#7a4025] text-sm transition-all peer-placeholder-shown:top-6 peer-placeholder-shown:text-base peer-focus:top-2 peer-focus:text-sm">New Password</label>
                            @error('new_password') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="relative md:col-span-1">
                            <input type="password" wire:model.defer="new_password_confirmation" id="new_password_confirmation" class="peer w-full border-2 border-[#e6d9cb] rounded-lg px-4 pt-6 pb-2 focus:outline-none focus:border-[#d19658] bg-transparent placeholder-transparent transition" placeholder="Confirm New Password" />
                            <label for="new_password_confirmation" class="absolute left-4 top-2 text-[#7a4025] text-sm transition-all peer-placeholder-shown:top-6 peer-placeholder-shown:text-base peer-focus:top-2 peer-focus:text-sm">Confirm New Password</label>
                        </div>
                    </div>
                    <button type="submit" class="w-full bottom-0 self-end bg-gradient-to-r from-[#d19658] to-[#ba4b18] text-white font-semibold py-3 rounded-xl shadow-md hover:from-[#ba4b18] hover:to-[#d19658] transition text-lg tracking-wide">Update Password</button>
                </form>
            </div>
        </div>
        <!-- Saved Addresses Section -->
        <div class="bg-white shadow rounded-3xl p-8 border border-[#f3e7d9] mt-8">
            <h2 class="text-2xl font-bold mb-6 text-[#7a4025] tracking-tight flex items-center gap-2">
                <svg class="w-7 h-7 text-[#d19658]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 9.4a5 5 0 11-9 0C7.5 5.36 12 3 12 3s4.5 2.36 4.5 6.4z" /><circle cx="12" cy="9.4" r="2" fill="#d19658"/></svg>
                Saved Addresses
            </h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-[#f3e7d9]">
                    <thead>
                        <tr class="bg-[#f8f8f8]">
                            <th class="px-4 py-2 text-left text-[#7a4025] font-semibold">Recipient</th>
                            <th class="px-4 py-2 text-left text-[#7a4025] font-semibold">Address</th>
                            <th class="px-4 py-2 text-left text-[#7a4025] font-semibold">Contact</th>
                            <th class="px-4 py-2 text-left text-[#7a4025] font-semibold"> </th>
                            <th class="px-4 py-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($addresses as $address)
                        <tr class="hover:bg-[#f8f8f8] transition">
                            <td class="px-4 py-2">{{ $address->shipping_recipient }}</td>
                            <td class="px-4 py-2">{{ $address->shipping_address }}</td>
                            <td class="px-4 py-2">{{ $address->shipping_contactNo }}</td>
                            <td class="px-4 py-2">
                                @if($address->shipping_isDefault)
                                    <span class="inline-block px-2 py-1 text-xs bg-[#d19658] text-white rounded">Default</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 flex gap-2">
                                {{-- <button wire:click="editAddress({{ $address->id }})" class="p-2 rounded bg-[#e6d9cb] hover:bg-[#d19658] text-[#7a4025] hover:text-white transition" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13h3l8-8a2.828 2.828 0 10-4-4l-8 8v3z" /></svg>
                                </button> --}}
                                <button wire:click="deleteAddress({{ $address->id }})" class="p-2 rounded bg-red-100 hover:bg-red-400 text-red-700 hover:text-white transition" title="Delete">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-[#7a4025] py-6">No saved addresses yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
