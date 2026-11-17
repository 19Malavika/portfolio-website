<template>
  <section id="home" class="relative pt-32 pb-20 md:pt-40 md:pb-28 overflow-hidden">
    <!-- Ambient background glow effects -->
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-gradient-to-tr from-sky-500/10 via-indigo-500/15 to-rose-500/10 rounded-full blur-3xl pointer-events-none -z-10"></div>
    <div class="absolute top-20 right-10 w-72 h-72 bg-sky-500/10 rounded-full blur-2xl pointer-events-none -z-10"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
        
        <!-- Left Column: Copy & CTAs -->
        <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
          
          <!-- Availability Badge -->
          <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-slate-900/80 border border-slate-700/60 text-xs font-medium text-slate-300 shadow-inner">
            <span class="relative flex h-2 w-2">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
              <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
            </span>
            <span>Available for Full Stack & Mobile Roles</span>
          </div>

          <!-- Main Title & Name -->
          <div class="space-y-2">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white leading-tight">
              Hi, I'm <span class="gradient-text">{{ profile?.name || 'Malavika M M' }}</span>
            </h1>
            <p class="text-xl sm:text-2xl font-semibold text-slate-300 tracking-normal flex items-center justify-center lg:justify-start gap-2 flex-wrap">
              <span class="text-sky-400">Full Stack Developer</span>
              <span class="text-slate-600">•</span>
              <span class="text-indigo-400">Flutter Mobile</span>
              <span class="text-slate-600">•</span>
              <span class="text-emerald-400">Laravel / PHP</span>
            </p>
          </div>

          <!-- Short Introduction -->
          <p class="text-slate-400 text-base sm:text-lg leading-relaxed max-w-2xl mx-auto lg:mx-0">
            {{ profile?.short_intro || 'Specializing in Flutter for mobile frontend and Laravel/PHP for backend architecture. Hands-on experience building responsive mobile and web applications with Riverpod, Clean Architecture, REST APIs, and database-driven workflows.' }}
          </p>

          <!-- Core Specialization Badges -->
          <div class="flex items-center justify-center lg:justify-start gap-2 flex-wrap pt-1">
            <span class="px-3 py-1 rounded-md text-xs font-mono font-medium bg-sky-950/60 text-sky-400 border border-sky-800/40">
              #Flutter & Riverpod
            </span>
            <span class="px-3 py-1 rounded-md text-xs font-mono font-medium bg-rose-950/60 text-rose-400 border border-rose-800/40">
              #Laravel & MVC
            </span>
            <span class="px-3 py-1 rounded-md text-xs font-mono font-medium bg-emerald-950/60 text-emerald-400 border border-emerald-800/40">
              #MySQL & Relational DBs
            </span>
            <span class="px-3 py-1 rounded-md text-xs font-mono font-medium bg-indigo-950/60 text-indigo-400 border border-indigo-800/40">
              #React & Vue.js
            </span>
          </div>

          <!-- Primary Actions -->
          <div class="pt-4 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
            <!-- View Projects -->
            <a
              href="#projects"
              class="w-full sm:w-auto px-7 py-3.5 rounded-xl font-semibold text-white bg-gradient-to-r from-sky-500 to-indigo-600 hover:from-sky-400 hover:to-indigo-500 shadow-lg shadow-sky-500/25 transition-all hover:scale-105 flex items-center justify-center gap-2"
            >
              <span>View My Projects</span>
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </a>

            <!-- Download Resume -->
            <a
              :href="resumeDownloadUrl"
              target="_blank"
              download="Malavika_MM_Resume.pdf"
              class="w-full sm:w-auto px-7 py-3.5 rounded-xl font-semibold text-slate-200 bg-slate-900/80 hover:bg-slate-800/90 border border-slate-700/80 shadow-md transition-all hover:scale-105 flex items-center justify-center gap-2 group"
            >
              <svg class="w-5 h-5 text-sky-400 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
              </svg>
              <span>Download Resume</span>
            </a>
          </div>

          <!-- Social Buttons: Prominent GitHub & LinkedIn -->
          <div class="pt-2 flex items-center justify-center lg:justify-start gap-4">
            <!-- GitHub Button -->
            <a
              href="https://github.com/19Malavika"
              target="_blank"
              rel="noopener noreferrer"
              class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium bg-slate-900 border border-slate-800 text-slate-300 hover:text-white hover:border-slate-700 hover:bg-slate-800/80 transition-all"
            >
              <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" />
              </svg>
              <span>GitHub / 19Malavika</span>
            </a>

            <!-- LinkedIn Button -->
            <a
              href="https://www.linkedin.com/in/malavika-m-m-b722142a0/"
              target="_blank"
              rel="noopener noreferrer"
              class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium bg-slate-900 border border-slate-800 text-slate-300 hover:text-sky-400 hover:border-slate-700 hover:bg-slate-800/80 transition-all"
            >
              <svg class="w-5 h-5 fill-current text-sky-400" viewBox="0 0 24 24">
                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
              </svg>
              <span>LinkedIn Connect</span>
            </a>
          </div>

        </div>

        <!-- Right Column: Interactive Profile Card with floating tags -->
        <div class="lg:col-span-5 flex justify-center relative">
          <div class="relative w-72 sm:w-80 md:w-96 aspect-square">
            
            <!-- Rotating subtle ring -->
            <div class="absolute inset-0 rounded-3xl bg-gradient-to-tr from-sky-500/20 via-indigo-500/20 to-rose-500/20 blur-xl opacity-70 animate-pulse-slow"></div>

            <!-- Card Container -->
            <div class="relative w-full h-full rounded-3xl overflow-hidden glass-card p-4 border border-slate-700/60 shadow-2xl flex flex-col items-center justify-center text-center">
              
              <!-- Avatar -->
              <div class="relative w-44 h-44 sm:w-52 sm:h-52 rounded-2xl overflow-hidden border-2 border-sky-400/40 shadow-xl mb-4 group">
                <img
                  :src="profile?.avatar_url || '/images/avatar.jpg'"
                  alt="Malavika M M"
                  class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                />
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent"></div>
              </div>

              <!-- Name & Location -->
              <h3 class="text-xl font-bold text-white">{{ profile?.name || 'Malavika M M' }}</h3>
              <p class="text-xs text-sky-400 font-mono mt-0.5">{{ profile?.location || 'Thrissur, Kerala, India' }}</p>

              <!-- Quick Meta pills -->
              <div class="mt-4 flex items-center justify-center gap-2">
                <span class="px-2.5 py-1 rounded-lg text-[11px] font-medium bg-slate-800/80 text-slate-300 border border-slate-700">
                  📱 Mobile & Web
                </span>
                <span class="px-2.5 py-1 rounded-lg text-[11px] font-medium bg-slate-800/80 text-emerald-400 border border-slate-700">
                  ⚡ 10+ Projects
                </span>
              </div>
            </div>

            <!-- Floating Tech Tag 1: Flutter -->
            <div class="absolute -top-4 -left-4 px-3 py-2 rounded-xl bg-slate-900/90 border border-sky-500/40 shadow-lg text-xs font-mono text-sky-300 flex items-center gap-2 backdrop-blur-md">
              <span class="w-2 h-2 rounded-full bg-sky-400"></span>
              <span>Flutter 3.x</span>
            </div>

            <!-- Floating Tech Tag 2: Laravel -->
            <div class="absolute -bottom-4 -right-4 px-3 py-2 rounded-xl bg-slate-900/90 border border-rose-500/40 shadow-lg text-xs font-mono text-rose-300 flex items-center gap-2 backdrop-blur-md">
              <span class="w-2 h-2 rounded-full bg-rose-400"></span>
              <span>Laravel 11</span>
            </div>

            <!-- Floating Tech Tag 3: Riverpod -->
            <div class="absolute top-1/2 -right-6 px-3 py-1.5 rounded-xl bg-slate-900/90 border border-indigo-500/40 shadow-lg text-xs font-mono text-indigo-300 flex items-center gap-1.5 backdrop-blur-md hidden sm:flex">
              <span class="w-2 h-2 rounded-full bg-indigo-400"></span>
              <span>Riverpod State</span>
            </div>

          </div>
        </div>

      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  profile: {
    type: Object,
    default: () => ({})
  }
});

const resumeDownloadUrl = computed(() => {
  return props.profile?.resume_path || '/api/resume/download';
});
</script>
