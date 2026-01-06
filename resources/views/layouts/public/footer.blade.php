 <!-- Footer -->
 <footer class="bg-gray-800 text-white pt-12 pb-8">
     <div class="container mx-auto px-4">
         <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
             <div>
                 <h3 class="text-xl font-bold mb-4">{{ setting('site_name', 'Octosync Software Ltd') }}</h3>
                 <p class="text-gray-400 mb-4">Your one-stop shop for the latest gadgets and electronics.</p>
                 <div class="flex space-x-4">
                     <a href="{{ setting('facebook_url', '#') }}" class="text-gray-400 hover:text-white"><i
                             class="fab fa-facebook-f"></i></a>
                     <a href="{{ setting('twitter_url', '#') }}" class="text-gray-400 hover:text-white"><i
                             class="fab fa-twitter"></i></a>
                     <a href="{{ setting('instagram_url', '#') }}" class="text-gray-400 hover:text-white"><i
                             class="fab fa-instagram"></i></a>
                     <a href="{{ setting('linkedin_url', '#') }}" class="text-gray-400 hover:text-white"><i
                             class="fab fa-linkedin-in"></i></a>
                 </div>
             </div>

             <div>
                 <h3 class="text-lg font-semibold mb-4">Company</h3>
                 <ul class="space-y-2">
                     <li><a href="{{ route('public.about') }}" class="text-gray-400 hover:text-white">About Us</a>
                     </li>
                     <li><a href="{{ route('public.contact') }}" class="text-gray-400 hover:text-white">Contact Us</a>
                     </li>
                 </ul>
             </div>

             <div>
                 <h3 class="text-lg font-semibold mb-4">Contact</h3>
                 <ul class="space-y-2">
                     <li class="text-gray-400">
                         <i class="fas fa-map-marker-alt mr-2"></i>
                         {{ setting('site_address', 'Dhaka, Bangladesh') }}
                     </li>
                     <li class="text-gray-400"><i class="fas fa-phone-alt mr-2"></i>
                         {{ setting('site_phone', '+8801621833839') }}</li>
                     <li class="text-gray-400"><i class="fas fa-envelope mr-2"></i>
                         {{ setting('site_email', 'support@octosyncsoftware.com') }}</li>
                 </ul>
             </div>
             <div>
                 <h3 class="text-lg font-semibold mb-4">Newsletter</h3>
                 <p class="text-gray-400 mb-4">Subscribe to our newsletter for the latest updates and offers.</p>
                 <form action="{{ route('public.subscribe') }}" method="POST" class="flex">
                     @csrf
                     <input type="email" name="email" placeholder="Your email address"
                         class="w-full px-4 py-2 rounded-l bg-gray-700 text-white focus:outline-none" required>
                     <button type="submit"
                         class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-r">Subscribe</button>
                 </form>
             </div>

         </div>

         <div class="border-t border-gray-700 pt-8 flex flex-col md:flex-row justify-between items-center">
             <a href="{{ route('public.welcome') }}" class="text-gray-400 text-sm mb-4 md:mb-0">© {{ date('Y') }}
                 {{ config('app.name', 'OS Gadgets') }}.
                 All rights reserved.</a>

             <div class="flex space-x-6">
                 <a href="http://octosyncsoftware.com" target="_blank"
                     class="text-gray-400 hover:text-white text-sm">Developed by
                     <span class="text-gray-200 hover:text-green-500 font-semibold font-sans text-lg">OctoSync Software
                         Ltd</span>
                 </a>
             </div>

             <div class="flex space-x-6">
                 <a href="{{ route('public.privacy-policy') }}" class="text-gray-400 hover:text-white text-sm">Privacy
                     Policy</a>
                 <a href="{{ route('public.terms-of-service') }}" class="text-gray-400 hover:text-white text-sm">Terms
                     of Service</a>
                 <a href="{{ route('public.return-policy') }}" class="text-gray-400 hover:text-white text-sm">Return
                     Policy</a>
             </div>
         </div>
     </div>
 </footer>

 @if (setting('whatsapp_enabled', true))
     <!-- Animated Floating WhatsApp Button -->
     <div class="fixed bottom-6 left-6 z-50">
         <div class="relative">
             <!-- Pulsing ring effect -->
             <div class="absolute inset-0 animate-ping bg-green-400 rounded-full opacity-75"
                 style="animation-duration: 3s;"></div>

             <!-- WhatsApp Button -->
             <a href="https://wa.me/{{ setting('whatsapp_number', '+8801621833839') }}?text={{ urlencode(setting('whatsapp_message', 'Hello! I have a question about your products.')) }}"
                 target="_blank" rel="noopener noreferrer"
                 class="relative flex items-center justify-center w-14 h-14 bg-green-500 text-white rounded-full shadow-lg hover:bg-green-600 transition-all duration-300 transform hover:scale-110">
                 <i class="fab fa-whatsapp text-xl"></i>
                 <span class="sr-only">Chat on WhatsApp</span>
             </a>
         </div>
     </div>
 @endif

 <!-- Shopping Cart Modal (Hidden by default) -->
 <div class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden" id="cartModal">
     <div class="absolute right-0 top-0 h-full w-full md:w-96 bg-white shadow-lg">
         <!-- Cart content would go here -->
     </div>
 </div>

 {{-- <script>
     // Simple JavaScript for interactive elements
     document.addEventListener('DOMContentLoaded', function() {
         // Product card hover effect
         const productCards = document.querySelectorAll('.product-card');
         productCards.forEach(card => {
             card.addEventListener('mouseenter', function() {
                 this.style.transform = 'translateY(-8px)';
                 this.style.boxShadow =
                     '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)';
             });

             card.addEventListener('mouseleave', function() {
                 this.style.transform = 'translateY(0)';
                 this.style.boxShadow = '';
             });
         });

         // Category card hover effect
         const categoryCards = document.querySelectorAll('.category-card');
         categoryCards.forEach(card => {
             card.addEventListener('mouseenter', function() {
                 this.style.transform = 'translateY(-5px)';
                 this.style.boxShadow = '0 10px 25px -5px rgba(0, 0, 0, 0.1)';
             });

             card.addEventListener('mouseleave', function() {
                 this.style.transform = 'translateY(0)';
                 this.style.boxShadow = '';
             });
         });
     });
 </script> --}}
 <script>
     document.addEventListener('DOMContentLoaded', function() {
         const notifications = document.querySelectorAll('#notification-success, #notification-error');
         notifications.forEach(notification => {
             setTimeout(() => {
                 notification.remove();
             }, 5000); // 5 seconds
         });
     });
 </script>
 @stack('scripts')
 </body>

 </html>
