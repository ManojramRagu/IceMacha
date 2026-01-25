<div class="min-h-screen bg-blush py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-cocoa">Checkout</h2>
            <p class="mt-2 text-cocoa/60">Complete your secure payment</p>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 sm:p-8 form-card">
            <!-- Payment Form -->
            <form id="payment-form">
                <div id="payment-element">
                    <!-- Stripe Elements will be mounted here -->
                </div>
                
                {{-- Error Message --}}
                <div id="payment-message" class="hidden mt-4 text-center text-red-500 bg-red-50 p-3 rounded-lg text-sm"></div>

                <button id="submit" class="w-full mt-8 bg-brand text-white font-semibold py-4 rounded-xl shadow-sm hover:bg-brand/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand transition-all duration-200 text-lg btn-brand disabled:opacity-50 disabled:cursor-not-allowed">
                    <span id="button-text">Pay Rs. {{ number_format($total, 2) }}</span>
                    <span id="spinner" class="hidden">Processing...</span>
                </button>
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
        document.addEventListener('livewire:initialized', () => {
             const stripe = Stripe("{{ env('STRIPE_KEY') }}");
             const clientSecret = "{{ $clientSecret }}";

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

            const elements = stripe.elements({ clientSecret, appearance });
            const paymentElement = elements.create("payment");
            paymentElement.mount("#payment-element");

            const form = document.getElementById('payment-form');
            const submitBtn = document.getElementById('submit');
            const spinner = document.getElementById('spinner');
            const buttonText = document.getElementById('button-text');
            const messageContainer = document.getElementById('payment-message');

            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                setLoading(true);

                const { error } = await stripe.confirmPayment({
                    elements,
                    confirmParams: {
                        return_url: "{{ route('dashboard') }}", // Or success page
                    },
                });

                if (error) {
                    showMessage(error.message);
                    setLoading(false);
                } else {
                    // unexpected state
                    setLoading(false);
                }
            });

            function showMessage(messageText) {
                messageContainer.classList.remove('hidden');
                messageContainer.textContent = messageText;
                setTimeout(function () {
                    messageContainer.classList.add('hidden');
                    messageContainer.textContent = "";
                }, 4000);
            }

            function setLoading(isLoading) {
                if (isLoading) {
                    submitBtn.disabled = true;
                    spinner.classList.remove('hidden');
                    buttonText.classList.add('hidden');
                } else {
                    submitBtn.disabled = false;
                    spinner.classList.add('hidden');
                    buttonText.classList.remove('hidden');
                }
            }
        });
    </script>
</div>
