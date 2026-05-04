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
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-[#7a4025] mb-2">Payment & Shipping Instructions</h2>
                    <div class="bg-[#f8f8f8] border rounded p-4 text-[#7a4025] flex flex-col gap-4">
                        <p>Please transfer your payment to one of the following accounts and upload your payment receipt below:</p>
                        <ul class="list-disc ml-6 mt-2">
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
                            After placing your order, our team will verify your payment and process your order.
                        </p>
                        <br/>
                        <p class="text-justify">
                            If you have chosen a <strong>Delivery Option</strong>,
                            <br>
                            Please verify that your shipping details are accurate before finalizing your request. Once your order is processed, you will receive an <strong>email notification</strong> detailing the total shipping costs.
                            <br>
                            To complete your transaction, please navigate to your <strong>My Orders</strong> page, select the pending order, and click <strong>Pay Shipping</strong>. From there, you can securely settle the balance and upload your payment receipt. Alternatively, you may use the direct link provided in the email to finalize your order.
                        </p>
                        {{-- <p>
                            If you have any questions or need assistance, please contact our customer support at <a href="mailto:support@example.com"><strong>support@example.com</strong></a>.
                        </p> --}}
                    </div>
                </div>
                <div>
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
