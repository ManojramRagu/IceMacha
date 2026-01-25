<div class="min-h-screen bg-blush py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-cocoa">Checkout</h2>
            <p class="mt-2 text-cocoa/60">Complete your secure payment</p>
        </div>

        <div 
            class="bg-white rounded-xl shadow-lg p-6 sm:p-8 form-card"
            x-data="checkout()"
        >
            
            {{-- Payment Method Toggle --}}
            <div class="flex gap-4 mb-6">
                <label class="flex-1 cursor-pointer">
                    <input type="radio" value="card" wire:model.live="paymentMethod" class="peer sr-only">
                    <div class="text-center p-3 rounded-lg border-2 border-slate peer-checked:border-brand peer-checked:bg-brand/10 transition-all">
                        <span class="text-cocoa font-medium">Card</span>
                    </div>
                </label>
                <label class="flex-1 cursor-pointer">
                    <input type="radio" value="cash" wire:model.live="paymentMethod" class="peer sr-only">
                    <div class="text-center p-3 rounded-lg border-2 border-slate peer-checked:border-brand peer-checked:bg-brand/10 transition-all">
                        <span class="text-cocoa font-medium">Cash on Delivery</span>
                    </div>
                </label>
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
                        <p class="text-cocoa font-medium">You will pay for your order in cash upon delivery.</p>
                        <p class="text-cocoa/70 text-sm mt-1">Please ensure you have the exact amount ready.</p>
                    </div>
                @endif

                {{-- Error Message --}}
                <div id="payment-message" class="hidden mt-4 text-center text-red-500 bg-red-50 p-3 rounded-lg text-sm" x-ref="messageContainer"></div>

                <div class="mt-8">
                     <button 
                        id="submit" 
                        type="submit" 
                        class="w-full bg-brand text-white font-semibold py-4 rounded-xl shadow-sm hover:bg-brand/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand transition-all duration-200 text-lg btn-brand disabled:opacity-50 disabled:cursor-not-allowed"
                        :disabled="isLoading"
                    >
                        <span x-show="!isLoading">
                            @if($paymentMethod === 'card')
                                Pay Rs. {{ number_format($total, 2) }}
                            @else
                                Place Order (Cash)
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
            
            <div class="mt-6 text-center">
                <a href="{{ route('cart') }}" class="text-cocoa/60 hover:text-brand text-sm font-medium transition-colors">
                    &larr; Back to Cart
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
                            return_url: "{{ route('dashboard') }}",
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
</div>
