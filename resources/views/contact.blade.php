@extends('layouts.app')

@section('content')
    {{-- Hero Section --}}
    <div class="relative h-[250px] md:h-[400px] overflow-hidden">
        {{-- Background Image --}}
        <img src="{{ asset('img/contact/hero.webp') }}" class="absolute inset-0 w-full h-full object-cover" alt="Contact Us">
        
        {{-- Gradient Overlay --}}
        <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/40 to-gray-50"></div>
        
        {{-- Decorative Top Border --}}
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-brand to-transparent"></div>
        
        {{-- Content --}}
        <div class="relative h-full flex flex-col items-center justify-center text-center px-4 max-w-4xl mx-auto">
            {{-- Decorative Line --}}
            <div class="w-16 h-px bg-brand mb-6"></div>
            
            {{-- Badge --}}
            <span class="text-brand font-bold uppercase tracking-widest text-sm mb-4 bg-white/20 px-4 py-2 rounded-full backdrop-blur-sm border border-white/30">Get in Touch</span>
            
            {{-- Main Title --}}
            <h1 class="text-3xl md:text-6xl font-bold text-white mb-6 tracking-tight leading-tight font-display">
                We'd Love to Hear From You
            </h1>
            
            {{-- Subtitle --}}
            <p class="text-base md:text-xl text-white/90 font-light max-w-2xl leading-relaxed">
                Have a question or just want to say hi? We're all ears.
            </p>
            
            {{-- Decorative Line --}}
            <div class="w-16 h-px bg-brand mt-6"></div>
        </div>
        
        {{-- Scroll Indicator --}}
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce hidden md:block">
            <svg class="w-6 h-6 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </div>

    <div class="min-h-screen bg-gray-50 flex py-8 md:py-16 px-4">
        <div class="max-w-7xl w-full mx-auto grid grid-cols-1 md:grid-cols-12 gap-8 shadow-2xl rounded-[2.5rem] overflow-hidden bg-white">
            
            <!-- 2. Contact Info & Map (Left - 4 cols) -->
            <div class="md:col-span-5 bg-cocoa text-white relative flex flex-col justify-between p-6 md:p-14">
                 <!-- Decorative Shape -->
                 <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-10 pointer-events-none">
                    <div class="absolute -top-24 -left-24 w-64 h-64 rounded-full bg-brand blur-3xl"></div>
                    <div class="absolute bottom-0 right-0 w-80 h-80 rounded-full bg-sand blur-3xl"></div>
                 </div>

                <div class="relative z-10 space-y-6 md:space-y-10">
                    <div>
                        <h3 class="text-2xl font-bold font-display mb-2">Contact Information</h3>
                        <p class="text-white/70">Fill up the form and our team will get back to you within 24 hours.</p>
                    </div>

                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center shrink-0 text-brand">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                             <div>
                                <h4 class="font-bold">Phone</h4>
                                <p class="text-white/80">+94 11 234 5678</p>
                            </div>
                        </div>

                         <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center shrink-0 text-brand">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                             <div>
                                <h4 class="font-bold">Email</h4>
                                <p class="text-white/80">hello@icemacha.com</p>
                            </div>
                        </div>

                         <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center shrink-0 text-brand">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                             <div>
                                <h4 class="font-bold">Address</h4>
                                <p class="text-white/80">123 Union Place,<br>Colombo 02, Sri Lanka</p>
                            </div>
                        </div>
                    </div>

                    <!-- Embedded Map -->
                     <div class="w-full h-48 rounded-2xl overflow-hidden shadow-lg border-2 border-white/10 mt-6">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15843.194291883344!2d79.85040529999999!3d6.9146775!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae25963120b1509%3A0x2db2c18a5b81ae1e!2sUnion%20Pl%2C%20Colombo!5e0!3m2!1sen!2slk!4v1706606612345!5m2!1sen!2slk" 
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade"
                            class="grayscale hover:grayscale-0 transition-all duration-500">
                        </iframe>
                    </div>
                </div>
            </div>

            <!-- 3. Contact Form (Right - 7 cols) -->
            <div class="md:col-span-7 bg-white p-6 md:p-14 relative z-20">
                 <h2 class="text-3xl font-display font-bold text-brand mb-8 text-center md:text-left">Send us a Message</h2>
                
                <form id="contact-form" action="https://formspree.io/f/mojdpjne" method="POST" class="space-y-6">
                    <input type="hidden" name="_next" value="{{ route('home') }}">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group">
                            <label class="block text-sm font-bold text-gray-500 mb-2 pl-1 group-focus-within:text-brand transition-colors">First Name</label>
                            <input type="text" name="first_name" class="w-full rounded-2xl border-gray-200 bg-gray-50 px-4 py-3 focus:border-brand focus:ring-brand focus:bg-white transition-all" required placeholder="John">
                        </div>
                        <div class="group">
                            <label class="block text-sm font-bold text-gray-500 mb-2 pl-1 group-focus-within:text-brand transition-colors">Last Name</label>
                            <input type="text" name="last_name" class="w-full rounded-2xl border-gray-200 bg-gray-50 px-4 py-3 focus:border-brand focus:ring-brand focus:bg-white transition-all" required placeholder="Doe">
                        </div>
                    </div>

                    <div class="group">
                        <label class="block text-sm font-bold text-gray-500 mb-2 pl-1 group-focus-within:text-brand transition-colors">Email Address</label>
                        <input type="email" name="email" class="w-full rounded-2xl border-gray-200 bg-gray-50 px-4 py-3 focus:border-brand focus:ring-brand focus:bg-white transition-all" required placeholder="john@example.com">
                    </div>

                    <div class="group">
                        <label class="block text-sm font-bold text-gray-500 mb-2 pl-1 group-focus-within:text-brand transition-colors">Subject</label>
                        <input type="text" name="subject" class="w-full rounded-2xl border-gray-200 bg-gray-50 px-4 py-3 focus:border-brand focus:ring-brand focus:bg-white transition-all" required placeholder="Inquiry about...">
                    </div>

                    <div class="group">
                        <label class="block text-sm font-bold text-gray-500 mb-2 pl-1 group-focus-within:text-brand transition-colors">Message</label>
                        <textarea name="message" rows="5" class="w-full rounded-2xl border-gray-200 bg-gray-50 px-4 py-3 focus:border-brand focus:ring-brand focus:bg-white transition-all" required placeholder="How can we help you?"></textarea>
                    </div>

                    <div class="flex justify-end gap-4 pt-4">
                        <button type="submit" id="submit-btn" class="w-full md:w-auto px-10 py-4 rounded-xl bg-brand text-white font-bold shadow-lg hover:shadow-xl hover:bg-opacity-90 transition-all transform hover:-translate-y-1">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="success-modal" class="fixed inset-0 bg-black/40 backdrop-blur-md hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-3xl p-12 max-w-md w-full mx-4 flex flex-col items-center text-center shadow-2xl relative" style="padding: 3.5rem;">
            <div class="w-20 h-20 bg-brand/10 rounded-full flex items-center justify-center mb-6">
                <svg class="w-10 h-10 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-3xl font-display font-bold text-brand mb-2">Message Sent!</h3>
            <p class="text-cocoa/80 text-lg mb-8">We will get back to you shortly.</p>
            <button onclick="document.getElementById('success-modal').classList.add('hidden')" class="w-full py-4 rounded-full bg-brand text-white font-bold text-lg hover:bg-opacity-90 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                Close
            </button>
        </div>
    </div>

<script>
    document.getElementById('contact-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const submitBtn = document.getElementById('submit-btn');
        const modal = document.getElementById('success-modal');
        const originalBtnText = submitBtn.textContent;
        
        // Loading State
        submitBtn.disabled = true;
        submitBtn.textContent = 'Sending...';
        
        const formData = new FormData(form);
        
        // 1. Save to Database
        fetch('{{ route('contact.store') }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    throw new Error(data.message || 'Error saving message');
                });
            }
            return response.json();
        })
        .then(() => {
            // 2. Send to Formspree
            return fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            });
        })
        .then(response => {
            if (response.ok) {
                // Success State
                form.reset();
                modal.classList.remove('hidden');
            } else {
                throw new Error('Formspree submission failed');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Dispatch Toast Event instead of blocking Alert
            window.dispatchEvent(new CustomEvent('toast', { 
                detail: { 
                    type: 'error', 
                    message: 'Submitting failed. ' + error.message 
                },
                bubbles: true,
                composed: true
            }));
        })
        .finally(() => {
            submitBtn.textContent = originalBtnText;
            submitBtn.disabled = false;
        });
    });
</script>
@endsection
