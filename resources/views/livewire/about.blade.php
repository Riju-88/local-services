<section class="bg-white dark:bg-gray-900 py-16">
  <div class="max-w-7xl mx-auto px-6 md:px-12">
    <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-8">About {{ config('app.name') }}</h1>
    
    <!-- Description -->
    <p class="text-lg text-gray-700 dark:text-gray-300 mb-10">
      {{ config('app.name') }} is a one-stop digital directory that brings together every local service provider in the Belgharia area.
    </p>

    <!-- Features Grid -->
    <div class="grid md:grid-cols-2 gap-8 mb-12">
      <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-lg shadow-md transition-transform hover:scale-105">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Discover Services</h3>
        <p class="text-gray-700 dark:text-gray-400">Find plumbers, tutors, mechanics, and more in just a few clicks.</p>
      </div>
      <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-lg shadow-md transition-transform hover:scale-105">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Add Your Business</h3>
        <p class="text-gray-700 dark:text-gray-400">List your service for free and start getting new customers today.</p>
      </div>
    </div>

    <!-- Call to Action -->
    <div class="bg-blue-600 dark:bg-blue-700 text-white p-8 rounded-lg shadow-lg mb-12">
      <h2 class="text-2xl font-bold mb-4">Join the Community</h2>
      <p class="mb-6">Help make Belgharia more connected by sharing your service or discovering someone else's.</p>
      <a href="{{ route('home') }}" class="inline-block bg-white text-blue-700 font-semibold px-6 py-3 rounded-full hover:bg-blue-50 transition" wire:navigate>
        Explore Services
      </a>
    </div>

    <!-- Team / Creator -->
    <div class="mb-12">
      <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Built By</h2>
      <p class="text-gray-700 dark:text-gray-300">A solo developer passionate about empowering local communities through technology.</p>
    </div>

    <!-- Contact Section -->
    <div>
      <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Get In Touch</h2>
      <ul class="space-y-2 text-gray-700 dark:text-gray-300">
        <li>Email: <a href="mailto:rijumistri4@gmail.com" class="text-blue-600 dark:text-blue-400 underline">rijumistri4@gmail.com</a></li>
        <li>Location: Belgharia, Kolkata</li>
        <li>Socials: 
          <a href="https://www.facebook.com/rij88" class="text-blue-600 dark:text-blue-400 underline mr-2" target="_blank">Facebook</a> | 
          <a href="#" class="text-blue-600 dark:text-blue-400 underline mr-2">Instagram</a> | 
          <a href="#" class="text-blue-600 dark:text-blue-400 underline">Twitter</a>
        </li>
      </ul>
    </div>
  </div>
</section>