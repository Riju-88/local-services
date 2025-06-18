<div class="space-y-4">

 <div class="font-sans antialiased text-gray-900">
        <!-- Modal Trigger -->
        <section class="py-20 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-center">
            <h2 class="text-3xl font-bold mb-6 animate-on-scroll fade-in" style="opacity: 0;">Ready to Build Something Amazing?</h2>
            <p class="mb-8 max-w-xl mx-auto animate-on-scroll fade-in" style="opacity: 0;">
                Join thousands of developers who trust our templates to build fast, beautiful websites.
            </p>
            <button @click="showModal = true" class="px-6 py-3 bg-white text-indigo-700 rounded-full shadow hover:bg-gray-100 transition animate-on-scroll zoom-in" style="opacity: 0;">
                Get Started Now
            </button>
        </section>

        <!-- Modal -->
        <template x-if="showModal">
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4">
                <div @click.away="showModal = false" class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative animate-on-scroll zoom-in" style="opacity: 0;">
                    <button @click="showModal = false" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <h3 class="text-xl font-bold mb-4">Start Your Free Trial</h3>
                    <form class="space-y-4">
                        <input type="text" placeholder="Your Name" class="w-full px-4 py-2 border rounded-md">
                        <input type="email" placeholder="Your Email" class="w-full px-4 py-2 border rounded-md">
                        <button type="submit" class="w-full py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">Submit</button>
                    </form>
                </div>
            </div>
        </template>

    </div>

    <!-- Inline Script for Animations -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const animateOnScroll = () => {
                document.querySelectorAll('.animate-on-scroll').forEach(el => {
                    const rect = el.getBoundingClientRect();
                    const windowHeight = window.innerHeight || document.documentElement.clientHeight;

                    if (rect.top < windowHeight * 0.8 && !el.classList.contains('active')) {
                        el.style.opacity = '1';
                        if (el.classList.contains('slide-up')) el.style.transform = 'translateY(0)';
                        if (el.classList.contains('slide-left')) el.style.transform = 'translateX(0)';
                        if (el.classList.contains('slide-right')) el.style.transform = 'translateX(0)';
                        if (el.classList.contains('zoom-in')) el.style.transform = 'scale(1)';
                        el.classList.add('active');
                    }
                });
            };

            window.addEventListener('scroll', animateOnScroll);
            animateOnScroll(); // Initial check
        });
    </script>

</div>
