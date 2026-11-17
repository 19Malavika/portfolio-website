<template>
  <section id="resume" class="py-20 relative border-t border-slate-800/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Section Header -->
      <div class="text-center max-w-3xl mx-auto mb-14 space-y-3">
        <span class="px-3 py-1 rounded-full text-xs font-mono font-semibold tracking-wider text-rose-400 bg-rose-950/60 border border-rose-800/40 uppercase">
          Curriculum Vitae
        </span>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
          Professional <span class="gradient-text">Resume Overview</span>
        </h2>
        <p class="text-slate-400 text-base leading-relaxed">
          Structured overview of qualifications, core stack competencies, and engineering project delivery.
        </p>

        <!-- Download & Print CTA Button -->
        <div class="pt-4 flex items-center justify-center gap-4 flex-wrap">
          <a
            :href="resumeDownloadUrl"
            target="_blank"
            download="Malavika_MM_Resume.pdf"
            class="px-6 py-3 rounded-xl font-semibold text-white bg-gradient-to-r from-sky-500 to-indigo-600 hover:from-sky-400 hover:to-indigo-500 shadow-lg shadow-sky-500/25 transition-all hover:scale-105 flex items-center gap-2"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
            <span>Download Official Resume PDF</span>
          </a>

          <router-link
            to="/resume"
            class="px-5 py-3 rounded-xl font-semibold text-slate-300 bg-slate-900 border border-slate-700 hover:bg-slate-800 hover:text-white transition-colors flex items-center gap-2"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
            <span>View Fullscreen Resume Page</span>
          </router-link>
        </div>
      </div>

      <!-- Formatted Paper/Document Preview Card -->
      <div class="max-w-4xl mx-auto glass-card rounded-3xl p-6 sm:p-12 border border-slate-700/80 shadow-2xl relative overflow-hidden">
        
        <!-- Decorative Header Bar -->
        <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-sky-400 via-indigo-500 to-emerald-400"></div>

        <!-- Document Header -->
        <div class="border-b border-slate-800 pb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
          <div>
            <h3 class="text-3xl font-extrabold text-white tracking-tight">
              {{ profile?.name || 'MALAVIKA M M' }}
            </h3>
            <p class="text-base font-semibold text-sky-400 font-mono mt-1">
              FULL STACK DEVELOPER | FLUTTER | LARAVEL | PHP
            </p>
            <div class="flex items-center gap-3 text-xs text-slate-400 mt-2 flex-wrap font-mono">
              <span>{{ profile?.location || 'Thrissur, Kerala, India' }}</span>
              <span>•</span>
              <a :href="`tel:${profile?.phone || '7736192047'}`" class="hover:text-sky-300">{{ profile?.phone || '+91 7736192047' }}</a>
              <span>•</span>
              <a :href="`mailto:${profile?.email || 'malavikamm177@gmail.com'}`" class="hover:text-sky-300">{{ profile?.email || 'malavikamm177@gmail.com' }}</a>
            </div>
          </div>

          <!-- Quick Links -->
          <div class="flex flex-col gap-1.5 text-xs font-mono sm:text-right flex-shrink-0">
            <a href="https://github.com/19Malavika" target="_blank" class="text-sky-400 hover:underline">github.com/19Malavika ↗</a>
            <a href="https://www.linkedin.com/in/malavika-m-m-b722142a0/" target="_blank" class="text-indigo-400 hover:underline">linkedin.com/in/malavika-m-m ↗</a>
          </div>
        </div>

        <!-- Resume Content Sections -->
        <div class="py-8 space-y-8 text-sm">
          
          <!-- Summary -->
          <div class="space-y-2">
            <h4 class="text-xs font-mono font-bold text-sky-400 uppercase tracking-widest border-b border-slate-800/80 pb-1">
              Professional Summary
            </h4>
            <p class="text-slate-300 text-xs sm:text-sm leading-relaxed">
              {{ profile?.bio || profile?.short_intro }}
            </p>
          </div>

          <!-- Core Competencies / Technical Skills -->
          <div class="space-y-3">
            <h4 class="text-xs font-mono font-bold text-emerald-400 uppercase tracking-widest border-b border-slate-800/80 pb-1">
              Technical Skills Matrix
            </h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
              <div class="p-3 rounded-xl bg-slate-900/60 border border-slate-800">
                <span class="font-bold text-white block mb-1">Languages:</span>
                <span class="text-slate-300">Dart, PHP, JavaScript, Python, HTML5, CSS3</span>
              </div>
              <div class="p-3 rounded-xl bg-slate-900/60 border border-slate-800">
                <span class="font-bold text-white block mb-1">Mobile & Frontend:</span>
                <span class="text-slate-300">Flutter, Vue.js, React.js, Material 3, Riverpod 3.x, Responsive UI</span>
              </div>
              <div class="p-3 rounded-xl bg-slate-900/60 border border-slate-800">
                <span class="font-bold text-white block mb-1">Backend & Architecture:</span>
                <span class="text-slate-300">Laravel, PHP, REST APIs, Clean Architecture, MVC, RBAC</span>
              </div>
              <div class="p-3 rounded-xl bg-slate-900/60 border border-slate-800">
                <span class="font-bold text-white block mb-1">Databases & Tools:</span>
                <span class="text-slate-300">MySQL, SQLite, Firebase, Git, GitHub, VS Code, Axios</span>
              </div>
            </div>
          </div>

          <!-- Featured Projects Snapshot -->
          <div class="space-y-3">
            <h4 class="text-xs font-mono font-bold text-indigo-400 uppercase tracking-widest border-b border-slate-800/80 pb-1">
              Key Projects Snapshot
            </h4>
            <div class="space-y-3">
              <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-800 space-y-1">
                <div class="flex items-center justify-between">
                  <span class="font-bold text-white text-sm">Smart Resource Booking & Allocation System</span>
                  <span class="text-[11px] font-mono text-sky-400">Laravel • MySQL</span>
                </div>
                <p class="text-xs text-slate-400">
                  Role-based resource management with automated conflict prevention, transactional booking logic, and maintenance tracking.
                </p>
              </div>

              <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-800 space-y-1">
                <div class="flex items-center justify-between">
                  <span class="font-bold text-white text-sm">Riverpod Flutter Shopping App</span>
                  <span class="text-[11px] font-mono text-emerald-400">Flutter • Riverpod 3.x</span>
                </div>
                <p class="text-xs text-slate-400">
                  Clean Architecture mobile e-commerce platform with reactive StateNotifier providers and optimized GridView rendering.
                </p>
              </div>

              <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-800 space-y-1">
                <div class="flex items-center justify-between">
                  <span class="font-bold text-white text-sm">Employee Leave Management System</span>
                  <span class="text-[11px] font-mono text-rose-400">Laravel • Eloquent</span>
                </div>
                <p class="text-xs text-slate-400">
                  Multi-tier leave application and approval workflow with automated balance accounting and role-based permissions.
                </p>
              </div>
            </div>
          </div>

          <!-- Education Section -->
          <div class="space-y-2">
            <h4 class="text-xs font-mono font-bold text-rose-400 uppercase tracking-widest border-b border-slate-800/80 pb-1">
              Education
            </h4>
            <div class="flex flex-col sm:flex-row sm:items-center justify-between text-xs gap-1">
              <div>
                <span class="font-bold text-white text-sm block">B.Tech in Computer Science and Engineering</span>
                <span class="text-slate-400">Government Engineering College, Wayanad (KTU)</span>
              </div>
              <span class="font-mono text-sky-400">2020 – 2024 • 8.2 CGPA</span>
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
