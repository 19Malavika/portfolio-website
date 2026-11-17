<template>
  <header
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 backdrop-blur-md"
    :class="[
      isScrolled
        ? 'bg-[#090d16]/90 border-b border-slate-800/80 shadow-lg shadow-black/20 py-3'
        : 'bg-transparent py-5'
    ]"
  >
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between">
        <!-- Logo -->
        <router-link to="/" class="flex items-center gap-2 group">
          <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-sky-400 to-indigo-600 flex items-center justify-center font-mono font-bold text-white shadow-lg shadow-sky-500/20 group-hover:scale-105 transition-transform">
            M
          </div>
          <div>
            <span class="font-bold text-lg tracking-tight text-white group-hover:text-sky-400 transition-colors">
              Malavika<span class="text-sky-400">.dev</span>
            </span>
            <span class="block text-[10px] text-slate-400 uppercase tracking-widest -mt-1 font-mono">
              Full Stack Dev
            </span>
          </div>
        </router-link>

        <!-- Desktop Navigation Links -->
        <nav class="hidden md:flex items-center gap-1 lg:gap-2">
          <a
            v-for="link in navLinks"
            :key="link.name"
            :href="link.href"
            class="px-3 py-1.5 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/60 transition-colors"
          >
            {{ link.name }}
          </a>

          <router-link
            to="/resume"
            class="px-3 py-1.5 rounded-lg text-sm font-medium text-sky-300 hover:text-white hover:bg-sky-500/10 transition-colors flex items-center gap-1.5"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Resume
          </router-link>
        </nav>

        <!-- Right Side: GitHub, LinkedIn & Resume CTA -->
        <div class="hidden md:flex items-center gap-3">
          <!-- GitHub -->
          <a
            href="https://github.com/19Malavika"
            target="_blank"
            rel="noopener noreferrer"
            class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/80 transition-colors"
            title="GitHub Profile"
          >
            <svg class="w-5 h-5 fill-currentColor" viewBox="0 0 24 24">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" />
            </svg>
          </a>

          <!-- LinkedIn -->
          <a
            href="https://www.linkedin.com/in/malavika-m-m-b722142a0/"
            target="_blank"
            rel="noopener noreferrer"
            class="p-2 rounded-lg text-slate-400 hover:text-sky-400 hover:bg-slate-800/80 transition-colors"
            title="LinkedIn Profile"
          >
            <svg class="w-5 h-5 fill-currentColor" viewBox="0 0 24 24">
              <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
            </svg>
          </a>

          <!-- Contact Me CTA -->
          <a
            href="#contact"
            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-semibold bg-gradient-to-r from-sky-500 to-indigo-600 text-white hover:from-sky-400 hover:to-indigo-500 shadow-md shadow-sky-500/25 transition-all hover:scale-105"
          >
            <span>Let's Talk</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
          </a>
        </div>

        <!-- Mobile Menu Toggle Button -->
        <button
          @click="mobileMenuOpen = !mobileMenuOpen"
          class="md:hidden p-2 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800 transition-colors"
          aria-label="Toggle navigation menu"
        >
          <svg v-if="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
          <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Mobile Dropdown Navigation -->
      <transition
        enter-active-class="transition duration-200 ease-out"
        enter-from-class="transform -translate-y-4 opacity-0"
        enter-to-class="transform translate-y-0 opacity-100"
        leave-active-class="transition duration-150 ease-in"
        leave-from-class="transform translate-y-0 opacity-100"
        leave-to-class="transform -translate-y-4 opacity-0"
      >
        <div
          v-if="mobileMenuOpen"
          class="md:hidden mt-3 pt-3 pb-4 border-t border-slate-800 bg-[#0d1322] rounded-2xl p-4 shadow-xl space-y-2"
        >
          <a
            v-for="link in navLinks"
            :key="link.name"
            :href="link.href"
            @click="mobileMenuOpen = false"
            class="block px-3 py-2 rounded-lg text-base font-medium text-slate-300 hover:text-white hover:bg-slate-800"
          >
            {{ link.name }}
          </a>

          <router-link
            to="/resume"
            @click="mobileMenuOpen = false"
            class="block px-3 py-2 rounded-lg text-base font-medium text-sky-400 hover:bg-sky-500/10"
          >
            📄 Full Resume Page
          </router-link>

          <div class="pt-4 border-t border-slate-800 flex items-center justify-between">
            <div class="flex items-center gap-3">
              <a
                href="https://github.com/19Malavika"
                target="_blank"
                class="p-2 bg-slate-800 rounded-lg text-slate-300 hover:text-white"
              >
                GitHub
              </a>
              <a
                href="https://www.linkedin.com/in/malavika-m-m-b722142a0/"
                target="_blank"
                class="p-2 bg-slate-800 rounded-lg text-sky-400 hover:text-sky-300"
              >
                LinkedIn
              </a>
            </div>
            <a
              href="#contact"
              @click="mobileMenuOpen = false"
              class="px-4 py-2 rounded-xl text-sm font-semibold bg-sky-500 text-white"
            >
              Contact Me
            </a>
          </div>
        </div>
      </transition>
    </div>
  </header>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const isScrolled = ref(false);
const mobileMenuOpen = ref(false);

const navLinks = [
  { name: 'Home', href: '#home' },
  { name: 'About', href: '#about' },
  { name: 'Skills', href: '#skills' },
  { name: 'Experience', href: '#experience' },
  { name: 'Education', href: '#education' },
  { name: 'Projects', href: '#projects' },
  { name: 'Contact', href: '#contact' },
];

const handleScroll = () => {
  isScrolled.value = window.scrollY > 20;
};

onMounted(() => {
  window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll);
});
</script>
