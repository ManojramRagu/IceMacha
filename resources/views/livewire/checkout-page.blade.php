<div class="min-h-screen bg-blush py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-cocoa">Checkout</h2>
            <p class="mt-2 text-cocoa/60">Complete your secure payment</p>
        </div>

        <div 
            class="bg-white rounded-3xl shadow-md p-6 sm:p-8 form-card"
            x-data="checkout()"
        >
            
            {{-- Payment Method Selection --}}
            <div class="flex flex-row gap-4 mb-8">
                <!-- Card Option -->
                <div 
                    wire:click="$set('paymentMethod', 'card')"
                    class="relative flex-1 cursor-pointer group p-4 rounded-2xl border-2 transition-all duration-200 flex flex-col items-center justify-center gap-3 hover:border-brand/50
                    {{ $paymentMethod === 'card' ? 'border-[#3d6b5a] bg-[#f7d8bd]/30' : 'border-slate bg-white' }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-cocoa {{ $paymentMethod === 'card' ? 'text-brand' : '' }}">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                    </svg>
                    <span class="text-sm font-semibold text-cocoa">Card Payment</span>
                    
                    @if($paymentMethod === 'card')
                        <div class="absolute top-2 right-2 text-brand">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Cash Option -->
                <div 
                    wire:click="$set('paymentMethod', 'cash')"
                    class="relative flex-1 cursor-pointer group p-4 rounded-2xl border-2 transition-all duration-200 flex flex-col items-center justify-center gap-3 hover:border-brand/50
                    {{ $paymentMethod === 'cash' ? 'border-[#3d6b5a] bg-[#f7d8bd]/30' : 'border-slate bg-white' }}"
                >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-cocoa {{ $paymentMethod === 'cash' ? 'text-brand' : '' }}">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                    </svg>
                    <span class="text-sm font-semibold text-cocoa">Cash on Delivery</span>

                    @if($paymentMethod === 'cash')
                        <div class="absolute top-2 right-2 text-brand">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Payment Form -->
            <form id="payment-form" @submit.prevent="handleSubmit">
                
                @if($paymentMethod === 'card')
                    <div id="stripe-container" wire:ignore>
                         <div id="payment-element" x-init="initStripe">
                            <!-- Stripe Elements will be mounted here -->
                        </div>
                    </div>
                @else
                    <div class="bg-sand/40 rounded-xl p-6 mb-6 text-center">
                        <p class="text-cocoa font-medium text-lg">You will pay for your order in cash upon delivery.</p>
                        <p class="text-cocoa/70 text-sm mt-1 mb-3">Please ensure you have the exact amount ready.</p>
                         <div class="border-t border-brand/10 pt-3 mt-3">
                            <p class="text-cocoa font-bold text-lg">Total to pay on delivery: Rs. {{ number_format($total, 2) }}</p>
                        </div>
                    </div>
                @endif

                {{-- Error Message --}}
                <div id="payment-message" class="hidden mt-4 text-center text-red-500 bg-red-50 p-3 rounded-lg text-sm" x-ref="messageContainer"></div>

                <div class="mt-8">
                     <button 
                        id="submit" 
                        type="submit" 
                        class="w-full bg-brand text-white font-semibold py-4 rounded-2xl shadow-md hover:bg-brand/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand transition-all duration-200 text-lg btn-brand disabled:opacity-50 disabled:cursor-not-allowed"
                        :disabled="isLoading"
                    >
                        <span x-show="!isLoading">
                            @if($paymentMethod === 'card')
                                Pay Rs. {{ number_format($total, 2) }}
                            @else
                                Confirm Order (Rs. {{ number_format($total, 2) }})
                            @endif
                        </span>
                        <span x-show="isLoading" class="flex items-center justify-center gap-2">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processing...
                        </span>
                    </button>
                </div>
            </form>
            
            <div class="mt-8 text-center">
                <a href="{{ route('cart') }}" class="text-cocoa/60 hover:text-brand font-medium transition-colors inline-flex items-center gap-1 group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 transition-transform group-hover:-translate-x-1">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    Back to Cart
                </a>
            </div>
        </div>
        
        <div class="mt-8 text-center">
             <div class="flex items-center justify-center gap-2 text-cocoa/40 text-xs">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                </svg>
                <span>Encrypted and Secure Payment</span>
            </div>
        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        function checkout() {
            return {
                stripe: null,
                elements: null,
                isLoading: false,
                clientSecret: "{{ $clientSecret }}",
                
                initStripe() {
                    if (!this.stripe) {
                        this.stripe = Stripe("{{ env('STRIPE_KEY') }}");
                    }
                    
                    const appearance = {
                        theme: 'flat',
                        variables: {
                            colorPrimary: '#3d6b5a',
                            colorBackground: '#ffffff',
                            colorText: '#6b4f4a', 
                            colorDanger: '#df1b41',
                            fontFamily: 'Poppins, ui-sans-serif, system-ui, sans-serif',
                            spacingUnit: '4px',
                            borderRadius: '12px',
                            fontSizeBase: '16px',
                        },
                        rules: {
                            '.Input': {
                                border: '1px solid rgba(107, 79, 74, 0.2)', 
                                boxShadow: '0 1px 2px 0 rgba(0,0,0,0.05)', 
                            },
                            '.Input:focus': {
                                border: '1px solid #3d6b5a', 
                                boxShadow: '0 0 0 2px rgba(61, 107, 90, 0.3)', 
                            },
                            '.Label': {
                                color: '#6b4f4a', 
                                fontWeight: '500',
                            }
                        }
                    };

                    this.elements = this.stripe.elements({ clientSecret: this.clientSecret, appearance });
                    const paymentElement = this.elements.create("payment");
                    paymentElement.mount("#payment-element");
                },

                async handleSubmit() {
                    this.isLoading = true;
                    this.$refs.messageContainer.classList.add('hidden');
                    
                    const method = await this.$wire.get('paymentMethod');

                    if (method === 'cash') {
                         await this.$wire.placeOrder();
                         return;
                    }

                    if (!this.stripe || !this.elements) {
                        this.isLoading = false;
                        return;
                    }

                    const { error } = await this.stripe.confirmPayment({
                        elements: this.elements,
                        confirmParams: {
                            return_url: "{{ route('payment.success') }}",
                        },
                    });

                    if (error) {
                        this.showMessage(error.message);
                        this.isLoading = false;
                    }
                },

                showMessage(messageText) {
                    const msgDiv = this.$refs.messageContainer;
                    msgDiv.classList.remove('hidden');
                    msgDiv.textContent = messageText;
                    setTimeout(() => {
                        msgDiv.classList.add('hidden');
                        msgDiv.textContent = "";
                    }, 4000);
                }
            }
        }
    </script>

    {{-- Toast Notification --}}
    <div x-data="{ show: @entangle('showToast'), type: @entangle('toastType') }" 
         x-effect="if(show) setTimeout(() => $wire.set('showToast', false), 4000)"
         x-show="show" 
         x-transition:enter="transform ease-out duration-300 transition"
         x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
         x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed bottom-6 right-6 z-50">
        <div :class="{
                'bg-brand text-white': type === 'success',
                'bg-white text-orange-600 border-2 border-orange-200': type === 'warning',
                'bg-white text-red-600 border-2 border-red-200': type === 'error'
             }" 
             class="rounded-2xl shadow-2xl px-6 py-4 flex items-center gap-4">
             
             {{-- Icon --}}
             <div :class="{
                      'bg-white/20': type === 'success',
                      'bg-orange-100': type === 'warning',
                      'bg-red-100': type === 'error'
                   }" 
                  class="w-8 h-8 rounded-full flex items-center justify-center shrink-0">
                  
                  {{-- Success Icon --}}
                  <svg x-show="type === 'success'" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  
                  {{-- Warning Icon --}}
                  <svg x-show="type === 'warning'" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                  </svg>
                  
                  {{-- Error Icon --}}
                  <svg x-show="type === 'error'" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
             </div>
             
             {{-- Message --}}
             <div>
                 <p class="font-bold text-sm" x-text="type === 'success' ? 'Success' : (type === 'warning' ? 'Warning' : 'Error')"></p>
                 <p :class="{
                        'text-white/80': type === 'success',
                        'text-orange-500': type === 'warning',
                        'text-red-500': type === 'error'
                     }" 
                    class="text-xs">{{ $toastMessage }}</p>
             </div>
        </div>
    </div>
</div>
