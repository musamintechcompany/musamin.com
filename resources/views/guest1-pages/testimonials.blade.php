<x-guest1-layout>
    <x-slot name="title">{{ config('app.name') }} | Testimonials</x-slot>

    <!-- Testimonials Section -->
    <section class="min-h-screen py-16 bg-gray-50">
        <div class="container px-4 mx-auto max-w-7xl">
            <h2 class="mb-4 text-3xl font-bold text-center text-gray-800 md:text-4xl">What Our Clients Say</h2>
            <p class="mb-12 text-lg text-center text-gray-600">Hear from entrepreneurs who found success with our platform</p>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach([
                    [
                        'name' => 'Sarah Johnson',
                        'role' => 'Ecommerce Entrepreneur',
                        'quote' => '"Bought an e-commerce site through WebMarket and tripled revenue within 6 months. The seamless transfer process saved me months of development time!"',
                        'stars' => 5,
                        'img' => 'https://randomuser.me/api/portraits/women/43.jpg'
                    ],
                    [
                        'name' => 'Michael Chen',
                        'role' => 'Digital Agency Owner',
                        'quote' => '"Renting a portfolio website allowed me to showcase my work professionally without the upfront cost. The quality exceeded my expectations."',
                        'stars' => 4,
                        'img' => 'https://randomuser.me/api/portraits/men/32.jpg'
                    ],
                    [
                        'name' => 'David Rodriguez',
                        'role' => 'Blogger',
                        'quote' => '"The established traffic from the blog I purchased gave me a huge head start. Support team was helpful throughout the entire process."',
                        'stars' => 5,
                        'img' => 'https://randomuser.me/api/portraits/men/75.jpg'
                    ],
                    [
                        'name' => 'Emily Wilson',
                        'role' => 'Small Business Owner',
                        'quote' => '"The rent-to-own option was perfect for my budget. After 12 months, I now own my website outright and couldn\'t be happier."',
                        'stars' => 5,
                        'img' => 'https://randomuser.me/api/portraits/women/65.jpg'
                    ],
                    [
                        'name' => 'James Thompson',
                        'role' => 'Freelance Developer',
                        'quote' => '"I\'ve purchased 3 sites through WebMarket to resell to my clients. The verification process gives me confidence in the metrics."',
                        'stars' => 4,
                        'img' => 'https://randomuser.me/api/portraits/men/22.jpg'
                    ],
                    [
                        'name' => 'Lisa Park',
                        'role' => 'Marketing Consultant',
                        'quote' => '"The support team helped me migrate my existing content to the new site seamlessly. Worth every penny for the time it saved me."',
                        'stars' => 5,
                        'img' => 'https://randomuser.me/api/portraits/women/33.jpg'
                    ]
                ] as $testimonial)
                <div class="flex flex-col p-6 transition-shadow duration-300 bg-white rounded-lg shadow-md hover:shadow-lg">
                    <div class="flex items-center mb-4">
                        <img src="{{ $testimonial['img'] }}" class="w-12 h-12 mr-4 rounded-full" alt="{{ $testimonial['name'] }}">
                        <div>
                            <h5 class="font-bold text-gray-800">{{ $testimonial['name'] }}</h5>
                            <p class="text-sm text-gray-600">{{ $testimonial['role'] }}</p>
                        </div>
                    </div>
                    <p class="mb-4 text-gray-700">{{ $testimonial['quote'] }}</p>
                    <div class="mt-auto text-yellow-400">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $testimonial['stars'])
                                <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            @endif
                        @endfor
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Success Stories Section -->
    <section class="py-16 bg-white">
        <div class="container px-4 mx-auto max-w-7xl">
            <h2 class="mb-4 text-3xl font-bold text-center text-gray-800 md:text-4xl">Success Stories</h2>
            <p class="mb-12 text-lg text-center text-gray-600">See how our clients transformed their businesses</p>

            <!-- First Success Story -->
            <div class="flex flex-col items-center mb-16 lg:flex-row lg:space-x-12">
                <div class="w-full mb-8 lg:w-1/2 lg:mb-0">
                    <div class="relative pb-[56.25%] h-0 overflow-hidden rounded-lg shadow-lg">
                        <iframe class="absolute top-0 left-0 w-full h-full" src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="Success Story" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="w-full lg:w-1/2">
                    <h3 class="mb-4 text-2xl font-bold text-gray-800 md:text-3xl">From $0 to $10k/month in 6 Months</h3>
                    <p class="mb-6 text-gray-700">"When I purchased my e-commerce site through WebMarket, it was making about $500/month. With their guidance and the solid foundation of the site, I was able to scale it to over $10,000/month in revenue within just 6 months."</p>
                    <div class="flex items-center">
                        <img src="https://randomuser.me/api/portraits/women/68.jpg" class="w-12 h-12 mr-4 rounded-full" alt="Jessica">
                        <div>
                            <h5 class="font-bold text-gray-800">Jessica Martinez</h5>
                            <p class="text-sm text-gray-600">Founder, EcoGoods</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Second Success Story -->
            <div class="flex flex-col items-center lg:flex-row lg:space-x-12">
                <div class="w-full mb-8 lg:w-1/2 lg:order-2 lg:mb-0">
                    <div class="relative pb-[56.25%] h-0 overflow-hidden rounded-lg shadow-lg">
                        <iframe class="absolute top-0 left-0 w-full h-full" src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="Success Story" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="w-full lg:w-1/2 lg:order-1">
                    <h3 class="mb-4 text-2xl font-bold text-gray-800 md:text-3xl">Blog to Full-Time Income</h3>
                    <p class="mb-6 text-gray-700">"I started by renting a blog about personal finance. After proving the concept worked, I used the rent-to-own option. Now it's my full-time income source with over 100,000 monthly readers and multiple revenue streams."</p>
                    <div class="flex items-center">
                        <img src="https://randomuser.me/api/portraits/men/45.jpg" class="w-12 h-12 mr-4 rounded-full" alt="Robert">
                        <div>
                            <h5 class="font-bold text-gray-800">Robert Kim</h5>
                            <p class="text-sm text-gray-600">Creator, FinanceForward</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-guest1-layout>