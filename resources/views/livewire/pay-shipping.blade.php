<div>
    @if($showButton)
        <button wire:click="openModal" class="inline-flex items-center px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold rounded transition">
            Pay Shipping Fee
        </button>
    @endif

    <!-- Pay Shipping Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md relative">
                <h2 class="text-lg font-bold mb-4 text-[#7a4025]">Upload Shipping Fee Receipt</h2>
                <form wire:submit.prevent="uploadReceipt" class="flex flex-col gap-4">
                    <input type="file" wire:model="shippingReceipt" accept="image/*" class="border rounded p-2" />
                    @error('shippingReceipt')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" wire:click="showModal=false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Success Modal -->
    @if($successModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm text-center">
                <h2 class="text-lg font-bold mb-2 text-green-700">Receipt Uploaded!</h2>
                <p class="mb-4 text-gray-700">Your shipping fee receipt has been submitted. Please wait for order confirmation.</p>
                <button wire:click="closeSuccessModal" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">OK</button>
            </div>
        </div>
    @endif
</div>
