<x-guest1-layout>
    <x-slot name="title">{{ config('app.name') }} | Contact Us</x-slot>
    <!-- Contact Section -->
    <section id="contact-section" class="py-20 bg-gradient-to-br from-purple-50 to-blue-50">
        <div class="container px-4 mx-auto max-w-6xl">
            <!-- Header -->
            <div class="text-center mb-16">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Get In Touch</h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">We're here to help! Reach out to us through any of the channels below and we'll get back to you as soon as possible.</p>
            </div>

            <!-- Contact Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <!-- Email Card -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
                    <div class="flex items-center justify-center w-16 h-16 bg-purple-100 rounded-full mb-6 mx-auto">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3 text-center">Email Support</h3>
                    <p class="text-gray-600 text-center mb-4">Send us a detailed message and we'll respond within 24 hours</p>
                    <div class="text-center">
                        <a href="mailto:support@musamin.com" class="text-lg font-semibold text-purple-600 hover:text-purple-700 transition-colors">
                            support@musamin.com
                        </a>
                        <p class="text-sm text-gray-500 mt-2">Response time: 24 hours</p>
                    </div>
                </div>

                <!-- WhatsApp Card -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 relative">
                    <div class="absolute -top-3 -right-3 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                        FASTEST
                    </div>
                    <div class="flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-6 mx-auto">
                        <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3 text-center">WhatsApp</h3>
                    <p class="text-gray-600 text-center mb-4">Get instant support through WhatsApp messaging</p>
                    <div class="text-center">
                        <a href="https://wa.me/447397824997" target="_blank" class="text-lg font-semibold text-green-600 hover:text-green-700 transition-colors">
                            +44 7397 824997
                        </a>
                        <p class="text-sm text-gray-500 mt-2">Available 24/7 • Instant response</p>
                    </div>
                </div>

                <!-- Live Chat Card -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
                    <div class="flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-6 mx-auto">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3 text-center">Live Chat</h3>
                    <p class="text-gray-600 text-center mb-4">Chat with our support team in real-time</p>
                    <div class="text-center">
                        <span class="text-lg font-semibold text-blue-600">Coming Soon</span>
                        <p class="text-sm text-gray-500 mt-2">Use WhatsApp for instant support</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="text-center">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Quick Actions</h3>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="https://wa.me/447397824997" target="_blank" class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                        </svg>
                        Start WhatsApp Chat
                    </a>
                    <a href="mailto:support@musamin.com" class="inline-flex items-center px-6 py-3 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Send Email
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq-section" class="py-16 bg-gray-100">
        <div class="container px-4 mx-auto max-w-7xl">
            <h2 class="mb-4 text-3xl font-bold text-center text-gray-800 md:text-4xl">Frequently Asked Questions</h2>
            <p class="mb-12 text-lg text-center text-gray-600">Find answers to common questions about our platform</p>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div x-data="{ openFaq: null }" class="space-y-4">
                    <div class="overflow-hidden bg-white rounded-lg shadow">
                        <button @click="openFaq = (openFaq === 1 ? null : 1)" class="flex items-center justify-between w-full px-6 py-4 text-left focus:outline-none">
                            <span class="text-xl font-semibold text-gray-800">How do I create an account?</span>
                            <svg :class="{'rotate-180': openFaq === 1}" class="w-5 h-5 text-purple-500 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="openFaq === 1" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" class="px-6 pb-4">
                            <p class="text-gray-700">Click the "Register" button and fill out the required information including your email, password, and personal details.</p>
                        </div>
                    </div>

                    <div class="overflow-hidden bg-white rounded-lg shadow">
                        <button @click="openFaq = (openFaq === 2 ? null : 2)" class="flex items-center justify-between w-full px-6 py-4 text-left focus:outline-none">
                            <span class="text-xl font-semibold text-gray-800">How do I buy coins?</span>
                            <svg :class="{'rotate-180': openFaq === 2}" class="w-5 h-5 text-purple-500 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="openFaq === 2" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" class="px-6 pb-4">
                            <p class="text-gray-700">Go to your Wallet section, select a coin package, choose your payment method, and complete the transaction.</p>
                        </div>
                    </div>

                    <div class="overflow-hidden bg-white rounded-lg shadow">
                        <button @click="openFaq = (openFaq === 3 ? null : 3)" class="flex items-center justify-between w-full px-6 py-4 text-left focus:outline-none">
                            <span class="text-xl font-semibold text-gray-800">What payment methods do you accept?</span>
                            <svg :class="{'rotate-180': openFaq === 3}" class="w-5 h-5 text-purple-500 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="openFaq === 3" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" class="px-6 pb-4">
                            <p class="text-gray-700">We accept credit cards, PayPal, bank transfers, and various cryptocurrency payments.</p>
                        </div>
                    </div>
                </div>

                <div x-data="{ openFaq: null }" class="space-y-4">
                    <div class="overflow-hidden bg-white rounded-lg shadow">
                        <button @click="openFaq = (openFaq === 4 ? null : 4)" class="flex items-center justify-between w-full px-6 py-4 text-left focus:outline-none">
                            <span class="text-xl font-semibold text-gray-800">How long does KYC verification take?</span>
                            <svg :class="{'rotate-180': openFaq === 4}" class="w-5 h-5 text-purple-500 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="openFaq === 4" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" class="px-6 pb-4">
                            <p class="text-gray-700">KYC verification typically takes 1-3 business days. You'll receive an email notification once your verification is complete.</p>
                        </div>
                    </div>

                    <div class="overflow-hidden bg-white rounded-lg shadow">
                        <button @click="openFaq = (openFaq === 5 ? null : 5)" class="flex items-center justify-between w-full px-6 py-4 text-left focus:outline-none">
                            <span class="text-xl font-semibold text-gray-800">Can I withdraw my funds anytime?</span>
                            <svg :class="{'rotate-180': openFaq === 5}" class="w-5 h-5 text-purple-500 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="openFaq === 5" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" class="px-6 pb-4">
                            <p class="text-gray-700">Yes, you can request withdrawals anytime. Processing times vary by payment method, typically 1-5 business days.</p>
                        </div>
                    </div>

                    <div class="overflow-hidden bg-white rounded-lg shadow">
                        <button @click="openFaq = (openFaq === 6 ? null : 6)" class="flex items-center justify-between w-full px-6 py-4 text-left focus:outline-none">
                            <span class="text-xl font-semibold text-gray-800">Is my personal information secure?</span>
                            <svg :class="{'rotate-180': openFaq === 6}" class="w-5 h-5 text-purple-500 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="openFaq === 6" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" class="px-6 pb-4">
                            <p class="text-gray-700">Yes, we use industry-standard encryption and security measures to protect all user data and transactions.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center">
                <a href="#contact-section" class="inline-block px-8 py-4 text-lg font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700 focus:ring-4 focus:ring-purple-300">Still Have Questions? Contact Us</a>
            </div>
        </div>
    </section>


</x-guest1-layout>
