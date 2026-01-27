@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-blush flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden max-w-6xl w-full flex flex-col md:flex-row">
        <!-- Contact Information Section (Left/Brand) -->
        <div class="bg-brand text-white p-10 md:w-5/12 flex flex-col justify-between relative overflow-hidden">
            <!-- Decorative circles -->
            <div class="absolute -top-10 -left-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute bottom-10 right-10 w-60 h-60 bg-white/10 rounded-full blur-3xl"></div>

            <div class="relative z-10">
                <h2 class="text-3xl md:text-4xl font-display font-bold mb-4">Contact Information</h2>
                <p class="text-white/80 text-lg mb-8">Say something to start a live chat!</p>
                
                <div class="space-y-6">
                    <div class="flex items-center space-x-4">
                        <svg class="w-6 h-6 text-sand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <span class="text-lg">+1012 3456 789</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <svg class="w-6 h-6 text-sand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span class="text-lg">demo@gmail.com</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <svg class="w-6 h-6 text-sand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span class="text-lg">123 Dartmouth Street, Boston, Massachusetts 02156 United States</span>
                    </div>
                </div>
            </div>

            <!-- Social Media -->
            <div class="flex space-x-6 mt-12 relative z-10">
                <a href="#" class="w-10 h-10 bg-white/20 hover:bg-white/40 rounded-full flex items-center justify-center transition-all duration-300">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                </a>
                <a href="#" class="w-10 h-10 bg-white/20 hover:bg-white/40 rounded-full flex items-center justify-center transition-all duration-300">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.072 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                </a>
            </div>
            
        </div>

        <!-- Form Section (Right) -->
        <div class="px-10 py-12 md:w-7/12">
            <h2 class="text-3xl font-display font-bold text-brand mb-8 text-center md:text-left">Send us a Message</h2>
            
            <form action="https://formspree.io/f/YOUR_FORMSPREE_ID_HERE" method="POST" class="space-y-6">
                <!-- Redirect After Submission -->
                <input type="hidden" name="_next" value="{{ route('home') }}">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="relative">
                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1 pl-1">First Name</label>
                        <input type="text" name="first_name" id="first_name" class="w-full rounded-2xl border-gray-300 shadow-sm focus:border-brand focus:ring-brand py-3 bg-white" required placeholder="John">
                    </div>
                    <div class="relative">
                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1 pl-1">Last Name</label>
                        <input type="text" name="last_name" id="last_name" class="w-full rounded-2xl border-gray-300 shadow-sm focus:border-brand focus:ring-brand py-3 bg-white" required placeholder="Doe">
                    </div>
                </div>

                <div class="relative">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1 pl-1">Email</label>
                    <input type="email" name="email" id="email" class="w-full rounded-2xl border-gray-300 shadow-sm focus:border-brand focus:ring-brand py-3 bg-white" required placeholder="john@example.com">
                </div>

                <div class="relative">
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-1 pl-1">Subject</label>
                    <input type="text" name="subject" id="subject" class="w-full rounded-2xl border-gray-300 shadow-sm focus:border-brand focus:ring-brand py-3 bg-white" required placeholder="Inquiry about...">
                </div>

                <div class="relative">
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1 pl-1">Message</label>
                    <textarea name="message" id="message" rows="4" class="w-full rounded-2xl border-gray-300 shadow-sm focus:border-brand focus:ring-brand py-3 bg-white" required placeholder="Write your message here..."></textarea>
                </div>

                <div class="flex justify-end pt-4 space-x-4">
                    <button type="reset" class="px-8 py-3 rounded-2xl bg-gray-200 text-gray-700 font-bold hover:bg-gray-300 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-8 py-3 rounded-2xl bg-brand text-white font-bold shadow-lg hover:shadow-xl hover:bg-opacity-90 transition-all transform hover:-translate-y-1">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
