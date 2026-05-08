<div>
    @if($showButton)
        <button wire:click="openModal" class="inline-flex items-center px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold rounded transition">
            Pay Shipping Fee
        </button>
    @endif

    <!-- Pay Shipping Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-7xl relative">
                <div class="mb-6 ">
                    <h2 class="text-xl font-bold text-[#7a4025] mb-2">Payment & Shipping Instructions</h2>
                    <div class="bg-[#f8f8f8] border rounded p-4 text-[#7a4025] grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col items-center justify-center md:border-r md:pr-6">
                            <h3 class="text-lg font-semibold mb-4 text-[#7a4025]">Shipping Fee</h3>
                            @if(isset($order) && $order->order_shippingFee !== null)
                                <div class="text-2xl font-bold text-white bg-[#7a4025] rounded px-6 py-2 mb-2 shadow">
                                    ₱{{ number_format($order->order_shippingFee, 2) }}
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-col items-center justify-center">
                            <p>Please transfer your payment to one of the following accounts and upload your payment receipt below:</p>
                            <ul class="list-disc ml-6 mt-2 max-w-96">
                                @foreach($paymentDetails as $payment)
                                    <li>
                                        <span class="font-semibold">{{ $payment->payment_bankName }}:</span>
                                        <span>{{ $payment->payment_accountNumber }}</span>
                                        @if($payment->payment_accountName)
                                            ({{ $payment->payment_accountName }})
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                            <p>
                                After uploading the shipping fee payment receipt, our team will verify your payment and confirm your order.
                            </p>
                        </div>
                    </div>
                </div>
                <div>
                    <h2 class="text-lg font-bold mb-4 text-[#7a4025]">Upload Shipping Fee Receipt</h2>
                    <form wire:submit.prevent="uploadReceipt" class="flex flex-col gap-4">
                        <div
                            x-data="{
                                file: null,
                                fileName: '',
                                fileSize: '',
                                previewUrl: '',
                                isImage: false,
                                updateFile(event) {
                                    const input = event.target;
                                    if (input.files && input.files[0]) {
                                        this.file = input.files[0];
                                        this.fileName = this.file.name;
                                        this.fileSize = this.formatFileSize(this.file.size);
                                        this.isImage = this.file.type.startsWith('image/');
                                        if (this.isImage) {
                                            const reader = new FileReader();
                                            reader.onload = e => { this.previewUrl = e.target.result; };
                                            reader.readAsDataURL(this.file);
                                        } else {
                                            this.previewUrl = '';
                                        }
                                    } else {
                                        this.file = null;
                                        this.fileName = '';
                                        this.fileSize = '';
                                        this.previewUrl = '';
                                        this.isImage = false;
                                    }
                                },
                                formatFileSize(size) {
                                    if (size < 1024) return size + ' bytes';
                                    if (size < 1024 * 1024) return (size / 1024).toFixed(1) + ' KB';
                                    return (size / (1024 * 1024)).toFixed(2) + ' MB';
                                },
                                removeFile() {
                                    this.file = null;
                                    this.fileName = '';
                                    this.fileSize = '';
                                    this.previewUrl = '';
                                    this.isImage = false;
                                    $refs.input.value = '';
                                    $wire.set('shippingReceipt', null);
                                }
                            }"
                            class="flex flex-col gap-2"
                        >
                            <label for="shippingReceipt" class="block text-sm font-medium text-[#7a4025]">Select Image</label>
                            <div class="relative flex flex-col items-center justify-center border-2 border-dashed rounded-lg p-6 bg-[#f8f8f8] transition hover:border-[#7a4025] hover:bg-[#f3ece6] min-h-[180px] w-full cursor-pointer"
                                :class="{ 'border-[#7a4025]': file, 'border-gray-300': !file }"
                                @click="$refs.input.click()"
                                @dragover.prevent
                                @drop.prevent="updateFile($event)"
                            >
                                <input type="file" x-ref="input" wire:model="shippingReceipt" accept="image/*" class="hidden" @change="updateFile($event)" />
                                <template x-if="!file">
                                    <span class="text-gray-400">Click or drag an image here to upload</span>
                                </template>
                                <template x-if="file">
                                    <div class="flex flex-col items-center gap-2 w-full">
                                        <template x-if="isImage && previewUrl">
                                            <img :src="previewUrl" alt="Preview" class="max-h-40 rounded shadow mb-2" />
                                        </template>
                                        <div class="flex flex-col items-center gap-1">
                                            <span class="text-sm font-semibold text-[#7a4025]" x-text="fileName"></span>
                                            <span class="text-xs text-gray-500" x-text="fileSize"></span>
                                        </div>
                                        <button type="button" @click.stop="removeFile()" class="mt-2 px-3 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600">Remove</button>
                                    </div>
                                </template>
                            </div>
                        </div>
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
