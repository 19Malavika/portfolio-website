<template>
  <footer class="border-t border-slate-800/80 bg-[#070a12] py-12 text-slate-400 text-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <div class="grid grid-cols-1 md:grid-cols-12 gap-8 pb-10 border-b border-slate-800/80">
        
        <!-- Left: Brand & Title -->
        <div class="md:col-span-6 space-y-3">
          <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-sky-400 to-indigo-600 flex items-center justify-center font-mono font-bold text-white text-sm">
              M
            </div>
            <span class="font-bold text-base text-white">Malavika M M</span>
          </div>
          <p class="text-slate-400 max-w-md leading-relaxed">
            Full Stack Developer specializing in Flutter for mobile frontend and Laravel/PHP for backend architecture. Dedicated to building clean, scalable software.
          </p>
          <div class="text-[11px] font-mono text-slate-500">
            Based in Thrissur, Kerala, India • Open for Opportunities
          </div>
        </div>

        <!-- Middle: Quick Navigation -->
        <div class="md:col-span-3 space-y-2">
          <div class="font-semibold text-slate-200 uppercase tracking-wider text-[11px] font-mono">
            Navigation
          </div>
          <ul class="space-y-1.5">
            <li><a href="#home" class="hover:text-sky-400 transition-colors">Home</a></li>
            <li><a href="#about" class="hover:text-sky-400 transition-colors">About</a></li>
            <li><a href="#skills" class="hover:text-sky-400 transition-colors">Skills</a></li>
            <li><a href="#experience" class="hover:text-sky-400 transition-colors">Experience</a></li>
            <li><a href="#education" class="hover:text-sky-400 transition-colors">Education</a></li>
            <li><a href="#projects" class="hover:text-sky-400 transition-colors">Projects</a></li>
            <li><router-link to="/resume" class="text-sky-400 hover:underline">Full Resume</router-link></li>
          </ul>
        </div>

        <!-- Right: Social Links & Tech Stack Info -->
        <div class="md:col-span-3 space-y-3">
          <div class="font-semibold text-slate-200 uppercase tracking-wider text-[11px] font-mono">
            Connect
          </div>
          <div class="flex items-center gap-3">
            <a
              href="https://github.com/19Malavika"
              target="_blank"
              rel="noopener noreferrer"
              class="p-2.5 rounded-xl bg-slate-900 border border-slate-800 text-slate-300 hover:text-white hover:border-slate-700 transition-colors"
              title="GitHub"
            >
              <svg class="w-4 h-4 fill-currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" />
              </svg>
            </a>

            <a
              href="https://www.linkedin.com/in/malavika-m-m-b722142a0/"
              target="_blank"
              rel="noopener noreferrer"
              class="p-2.5 rounded-xl bg-slate-900 border border-slate-800 text-sky-400 hover:text-sky-300 hover:border-slate-700 transition-colors"
              title="LinkedIn"
            >
              <svg class="w-4 h-4 fill-currentColor" viewBox="0 0 24 24">
                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
              </svg>
            </a>

            <a
              href="mailto:malavikamm177@gmail.com"
              class="p-2.5 rounded-xl bg-slate-900 border border-slate-800 text-slate-300 hover:text-white hover:border-slate-700 transition-colors"
              title="Email"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
              </svg>
            </a>
          </div>

          <!-- Stack pill -->
          <div class="pt-2 text-[10px] font-mono text-slate-500">
            Powered by Laravel 11 • Vue 3 • MySQL
          </div>
        </div>

      </div>

      <!-- Bottom Bar -->
      <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div>
          &copy; {{ new Date().getFullYear() }} Malavika M M. All rights reserved.
        </div>

        <div class="flex items-center gap-4 text-[11px]">
          <router-link
            to="/login"
            class="text-slate-500 hover:text-slate-300 flex items-center gap-1 font-mono transition-colors"
          >
            <span>🔒 Admin Portal</span>
          </router-link>
        </div>
      </div>

    </div>
  </footer>
</template>

<script setup>
</script>
