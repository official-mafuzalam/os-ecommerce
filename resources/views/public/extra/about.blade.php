<x-app-layout>
    @section('title', 'About Us - ' . setting('site_title', 'OS E-commerce'))
    <x-slot name="main">
        <!-- Fashion About Hero -->
        <div class="relative overflow-hidden">
            <!-- Background Image with Overlay -->
            <div class="absolute inset-0">
                <img class="w-full h-full object-cover"
                    src="https://cdn.octosyncsoftware.com//storage/files/2/Other-Site/public/360_F_860540980_ipoJAjRJBSeRBNXi4x34IcoP41hSqz3x.jpg"
                    alt="About Us Hero Background">
                <div class="absolute inset-0 bg-black/40"></div>
            </div>

            <!-- Hero Content -->
            <div class="relative py-24 md:py-32">
                <div class="container mx-auto px-4">
                    <div class="max-w-3xl">
                        <div class="mb-8">
                            <span
                                class="inline-block bg-white/20 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm font-medium">
                                Since {{ setting('business_start_year', date('Y') - 3) }}
                            </span>
                        </div>
                        <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 elegant-heading leading-tight">
                            {{ setting('about_hero_title', 'The Story Behind Our Business') }}
                        </h1>
                        <p class="text-xl text-white/90 mb-8 max-w-2xl">
                            {{ setting('about_hero_subtitle', 'A journey of passion, craftsmanship, and style that redefines luxury fashion experiences') }}
                        </p>
                        <a href="{{ route('public.products') }}"
                            class="fashion-btn inline-flex items-center justify-center gap-3 px-8 py-3 text-lg">
                            <i class="fas fa-store"></i>
                            Explore Our Collection
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Our Journey -->
        <section class="py-16 md:py-24">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                    <!-- Content -->
                    <div>
                        <div class="mb-8">
                            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mt-2 mb-4">
                                {{ setting('journey_title', 'Our Journey') }}
                            </h2>
                        </div>

                        <div class="space-y-6">
                            <p class="text-lg text-gray-600 leading-relaxed">
                                {{ setting('journey_description_1', 'Founded in ' . (date('Y') - 3) . ', we began as a small boutique with a big vision: to bring exceptional fashion to discerning customers worldwide. What started with curated collections from local artisans has evolved into a premier destination for luxury fashion.') }}
                            </p>
                            <p class="text-lg text-gray-600 leading-relaxed">
                                {{ setting('journey_description_2', 'Our commitment extends beyond just selling clothes; we\'re dedicated to creating memorable experiences. Each piece in our collection is selected for its quality, craftsmanship, and ability to inspire confidence and style.') }}
                            </p>
                        </div>

                        <!-- Stats -->
                        <div class="grid grid-cols-2 gap-6 mt-10">
                            <div class="text-center">
                                <div class="text-3xl md:text-4xl font-bold text-gray-900 mb-1">
                                    {{ setting('stat_customers', '50K+') }}
                                </div>
                                <div class="text-sm text-gray-600">Stylish Customers</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl md:text-4xl font-bold text-gray-900 mb-1">
                                    {{ setting('stat_products', '5K+') }}
                                </div>
                                <div class="text-sm text-gray-600">Premium Products</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl md:text-4xl font-bold text-gray-900 mb-1">
                                    {{ setting('stat_brands', '120+') }}
                                </div>
                                <div class="text-sm text-gray-600">Designer Brands</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl md:text-4xl font-bold text-gray-900 mb-1">
                                    {{ setting('stat_countries', '15+') }}
                                </div>
                                <div class="text-sm text-gray-600">Countries Served</div>
                            </div>
                        </div>
                    </div>

                    <!-- Image -->
                    <div class="relative">
                        <div class="aspect-[4/5] rounded-2xl overflow-hidden">
                            @if (setting('journey_image'))
                                <img class="w-full h-full object-cover hover:scale-105 transition-transform duration-700"
                                    src="{{ setting('journey_image') }}"
                                    alt="Fashion Studio Interior">
                            @else
                                <img class="w-full h-full object-cover hover:scale-105 transition-transform duration-700"
                                    src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1000&q=80"
                                    alt="Fashion Studio Interior">
                            @endif
                        </div>
                        <div
                            class="absolute -bottom-6 -right-6 w-48 h-48 bg-gradient-to-br from-gray-900 to-black 
                                    rounded-2xl flex items-center justify-center text-white p-6 shadow-xl">
                            <div class="text-center">
                                <div class="text-2xl font-bold">{{ setting('business_start_year', date('Y') - 3) }}
                                </div>
                                <div class="text-sm mt-1">Year Founded</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Our Values -->
        <section class="py-16 md:py-24 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <span class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Our Values</span>
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mt-2 mb-4">
                        {{ setting('values_title', 'The Principles That Define Us') }}
                    </h2>
                    <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                        {{ setting('values_subtitle', 'These core values guide every decision we make and every experience we create') }}
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Quality Craftsmanship -->
                    <div
                        class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 text-center 
                                hover:shadow-lg hover:border-gray-200 transition-all duration-300">
                        <div
                            class="w-20 h-20 rounded-full bg-gradient-to-br from-gray-900 to-black 
                                    text-white flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-gem text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">
                            {{ setting('value_1_title', 'Quality Craftsmanship') }}
                        </h3>
                        <p class="text-gray-600">
                            {{ setting('value_1_description', 'Every product is meticulously crafted with attention to detail and premium materials') }}
                        </p>
                    </div>

                    <!-- Sustainable Fashion -->
                    <div
                        class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 text-center 
                                hover:shadow-lg hover:border-gray-200 transition-all duration-300">
                        <div
                            class="w-20 h-20 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 
                                    text-white flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-leaf text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">
                            {{ setting('value_2_title', 'Sustainable Fashion') }}
                        </h3>
                        <p class="text-gray-600">
                            {{ setting('value_2_description', 'Committed to ethical sourcing and environmentally conscious practices') }}
                        </p>
                    </div>

                    <!-- Personal Style -->
                    <div
                        class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 text-center 
                                hover:shadow-lg hover:border-gray-200 transition-all duration-300">
                        <div
                            class="w-20 h-20 rounded-full bg-gradient-to-br from-purple-500 to-pink-600 
                                    text-white flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-user-tie text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">
                            {{ setting('value_3_title', 'Personal Style') }}
                        </h3>
                        <p class="text-gray-600">
                            {{ setting('value_3_description', 'Helping you discover and express your unique personal style with confidence') }}
                        </p>
                    </div>

                    <!-- Exceptional Service -->
                    <div
                        class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 text-center 
                                hover:shadow-lg hover:border-gray-200 transition-all duration-300">
                        <div
                            class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-500 to-cyan-600 
                                    text-white flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-headset text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">
                            {{ setting('value_4_title', 'Exceptional Service') }}
                        </h3>
                        <p class="text-gray-600">
                            {{ setting('value_4_description', 'Dedicated to providing personalized, attentive service at every touchpoint') }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Our Process -->
        <section class="py-16 md:py-24">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <span class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Our Process</span>
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mt-2 mb-4">
                        {{ setting('process_title', 'From Concept to Collection') }}
                    </h2>
                </div>

                <div class="relative">
                    <!-- Timeline Line -->
                    <div
                        class="absolute left-0 md:left-1/2 top-0 bottom-0 w-0.5 bg-gray-200 transform md:-translate-x-1/2">
                    </div>

                    <!-- Process Steps -->
                    <div class="space-y-12">
                        <!-- Step 1 -->
                        <div class="relative flex flex-col md:flex-row items-center">
                            <div class="md:w-1/2 md:pr-12 md:text-right mb-6 md:mb-0">
                                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                                    <div class="flex items-center justify-end gap-4 mb-4">
                                        <div>
                                            <span class="text-sm font-semibold text-gray-500">Step 01</span>
                                            <h3 class="text-xl font-bold text-gray-900">
                                                {{ setting('process_step_1_title', 'Curated Selection') }}
                                            </h3>
                                        </div>
                                        <div
                                            class="w-12 h-12 rounded-full bg-gray-900 text-white 
                                                    flex items-center justify-center flex-shrink-0">
                                            <span class="font-bold">1</span>
                                        </div>
                                    </div>
                                    <p class="text-gray-600">
                                        {{ setting('process_step_1_description', 'Our fashion experts travel globally to discover emerging designers and established brands that align with our quality standards and aesthetic vision.') }}
                                    </p>
                                </div>
                            </div>
                            <div
                                class="absolute left-1/2 transform -translate-x-1/2 md:left-1/2 md:translate-x-1/2 
                                        w-6 h-6 rounded-full bg-gray-900 border-4 border-white z-10">
                            </div>
                            <div class="md:w-1/2 md:pl-12">
                                <!-- Empty space for alignment -->
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="relative flex flex-col md:flex-row items-center">
                            <div class="md:w-1/2 md:pr-12">
                                <!-- Empty space for alignment -->
                            </div>
                            <div
                                class="absolute left-1/2 transform -translate-x-1/2 md:left-1/2 md:translate-x-1/2 
                                        w-6 h-6 rounded-full bg-gray-900 border-4 border-white z-10">
                            </div>
                            <div class="md:w-1/2 md:pl-12 mt-6 md:mt-0">
                                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                                    <div class="flex items-center gap-4 mb-4">
                                        <div
                                            class="w-12 h-12 rounded-full bg-gray-900 text-white 
                                                    flex items-center justify-center flex-shrink-0">
                                            <span class="font-bold">2</span>
                                        </div>
                                        <div>
                                            <span class="text-sm font-semibold text-gray-500">Step 02</span>
                                            <h3 class="text-xl font-bold text-gray-900">
                                                {{ setting('process_step_2_title', 'Quality Assurance') }}
                                            </h3>
                                        </div>
                                    </div>
                                    <p class="text-gray-600">
                                        {{ setting('process_step_2_description', 'Each product undergoes rigorous quality checks, from material inspection to craftsmanship evaluation, ensuring only the finest items reach our customers.') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="relative flex flex-col md:flex-row items-center">
                            <div class="md:w-1/2 md:pr-12 md:text-right mb-6 md:mb-0">
                                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                                    <div class="flex items-center justify-end gap-4 mb-4">
                                        <div>
                                            <span class="text-sm font-semibold text-gray-500">Step 03</span>
                                            <h3 class="text-xl font-bold text-gray-900">
                                                {{ setting('process_step_3_title', 'Styling Expertise') }}
                                            </h3>
                                        </div>
                                        <div
                                            class="w-12 h-12 rounded-full bg-gray-900 text-white 
                                                    flex items-center justify-center flex-shrink-0">
                                            <span class="font-bold">3</span>
                                        </div>
                                    </div>
                                    <p class="text-gray-600">
                                        {{ setting('process_step_3_description', 'Our styling team creates curated looks and provides fashion advice to help customers build cohesive wardrobes that reflect their personal style.') }}
                                    </p>
                                </div>
                            </div>
                            <div
                                class="absolute left-1/2 transform -translate-x-1/2 md:left-1/2 md:translate-x-1/2 
                                        w-6 h-6 rounded-full bg-gray-900 border-4 border-white z-10">
                            </div>
                            <div class="md:w-1/2 md:pl-12">
                                <!-- Empty space for alignment -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Fashion Leaders -->
        <section class="py-16 md:py-24 bg-gray-900 text-white">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <span class="text-sm font-semibold text-white/70 uppercase tracking-wider">Our Visionaries</span>
                    <h2 class="text-4xl md:text-5xl font-bold mt-2 mb-4">
                        {{ setting('team_title', 'Meet Our Fashion Leaders') }}
                    </h2>
                    <p class="text-lg text-white/80 max-w-3xl mx-auto">
                        {{ setting('team_subtitle', 'The creative minds shaping the future of fashion retail') }}
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Leader 1 -->
                    <div class="group">
                        <div class="relative overflow-hidden rounded-2xl mb-6">
                            @if (setting('team_member_1_image'))
                                <img class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-700"
                                    src="{{ Storage::url(setting('team_member_1_image')) }}"
                                    alt="{{ setting('team_member_1_name', 'Isabella Rossi') }}">
                            @else
                                <img class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-700"
                                    src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800&q=80"
                                    alt="{{ setting('team_member_1_name', 'Isabella Rossi') }}">
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        </div>
                        <h3 class="text-xl font-bold mb-1">
                            {{ setting('team_member_1_name', 'Isabella Rossi') }}
                        </h3>
                        <p class="text-white/60 text-sm mb-3">
                            {{ setting('team_member_1_position', 'Creative Director & Founder') }}
                        </p>
                        <p class="text-white/80">
                            {{ setting('team_member_1_description', 'With 15 years in luxury fashion, Isabella\'s vision shapes our aesthetic direction and brand identity.') }}
                        </p>
                    </div>

                    <!-- Leader 2 -->
                    <div class="group">
                        <div class="relative overflow-hidden rounded-2xl mb-6">
                            @if (setting('team_member_2_image'))
                                <img class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-700"
                                    src="{{ Storage::url(setting('team_member_2_image')) }}"
                                    alt="{{ setting('team_member_2_name', 'Alexander Chen') }}">
                            @else
                                <img class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-700"
                                    src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800&q=80"
                                    alt="{{ setting('team_member_2_name', 'Alexander Chen') }}">
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        </div>
                        <h3 class="text-xl font-bold mb-1">
                            {{ setting('team_member_2_name', 'Alexander Chen') }}
                        </h3>
                        <p class="text-white/60 text-sm mb-3">
                            {{ setting('team_member_2_position', 'Head of Design & Merchandising') }}
                        </p>
                        <p class="text-white/80">
                            {{ setting('team_member_2_description', 'Alexander\'s expertise in global fashion trends ensures our collections remain contemporary and relevant.') }}
                        </p>
                    </div>

                    <!-- Leader 3 -->
                    <div class="group">
                        <div class="relative overflow-hidden rounded-2xl mb-6">
                            @if (setting('team_member_3_image'))
                                <img class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-700"
                                    src="{{ Storage::url(setting('team_member_3_image')) }}"
                                    alt="{{ setting('team_member_3_name', 'Sophia Williams') }}">
                            @else
                                <img class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-700"
                                    src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800&q=80"
                                    alt="{{ setting('team_member_3_name', 'Sophia Williams') }}">
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        </div>
                        <h3 class="text-xl font-bold mb-1">
                            {{ setting('team_member_3_name', 'Sophia Williams') }}
                        </h3>
                        <p class="text-white/60 text-sm mb-3">
                            {{ setting('team_member_3_position', 'Customer Experience Director') }}
                        </p>
                        <p class="text-white/80">
                            {{ setting('team_member_3_description', 'Sophia leads our commitment to exceptional service, ensuring every customer feels valued and understood.') }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-16 md:py-24">
            <div class="container mx-auto px-4">
                <div class="bg-gradient-to-r from-gray-900 to-black rounded-3xl p-12 md:p-16 text-center">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                        {{ setting('cta_title', 'Ready to Experience Premium Fashion?') }}
                    </h2>
                    <p class="text-lg text-white/80 mb-8 max-w-2xl mx-auto">
                        {{ setting('cta_description', 'Join thousands of satisfied customers who trust us for their style journey') }}
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('public.products') }}"
                            class="bg-white text-gray-900 font-semibold px-8 py-3 rounded-lg hover:bg-gray-100 
                                  transition-colors inline-flex items-center justify-center gap-3">
                            <i class="fas fa-shopping-bag"></i>
                            Shop Our Collection
                        </a>
                        <a href="{{ route('public.contact') }}"
                            class="bg-transparent border-2 border-white text-white font-semibold px-8 py-3 rounded-lg 
                                  hover:bg-white/10 transition-colors inline-flex items-center justify-center gap-3">
                            <i class="fas fa-envelope"></i>
                            Get in Touch
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <style>
            /* Timeline styling */
            @media (min-width: 768px) {
                .timeline-item:nth-child(odd) .timeline-content {
                    text-align: right;
                }

                .timeline-item:nth-child(even) .timeline-content {
                    text-align: left;
                }
            }

            /* Hover effects */
            .group:hover .group-hover\:scale-110 {
                transform: scale(1.1);
            }

            /* Smooth scroll behavior */
            html {
                scroll-behavior: smooth;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Add animation to value cards on scroll
                const valueCards = document.querySelectorAll('.bg-white.rounded-2xl');

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                        }
                    });
                }, {
                    threshold: 0.1
                });

                valueCards.forEach(card => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    card.style.transition = 'all 0.6s ease-out';
                    observer.observe(card);
                });

                // Timeline animation
                const timelineDots = document.querySelectorAll('.absolute.w-6.h-6');
                timelineDots.forEach((dot, index) => {
                    setTimeout(() => {
                        dot.style.boxShadow = '0 0 0 10px rgba(17, 24, 39, 0.1)';
                        setTimeout(() => {
                            dot.style.boxShadow = 'none';
                        }, 600);
                    }, index * 300);
                });

                // Team member hover effect
                const teamMembers = document.querySelectorAll('.group');
                teamMembers.forEach(member => {
                    member.addEventListener('mouseenter', () => {
                        member.style.transform = 'translateY(-8px)';
                        member.style.transition = 'transform 0.3s ease';
                    });
                    member.addEventListener('mouseleave', () => {
                        member.style.transform = 'translateY(0)';
                    });
                });
            });
        </script>
    </x-slot>
</x-app-layout>
