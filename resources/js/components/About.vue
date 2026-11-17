<template>
  <section id="about" class="py-20 relative border-t border-slate-800/60 bg-[#090d16]/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Section Header -->
      <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
        <span class="px-3 py-1 rounded-full text-xs font-mono font-semibold tracking-wider text-sky-400 bg-sky-950/60 border border-sky-800/40 uppercase">
          About Me
        </span>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
          Architecting Clean Software from <span class="gradient-text">Pixel to Database</span>
        </h2>
        <p class="text-slate-400 text-base leading-relaxed">
          Bridging fluid cross-platform user interfaces with scalable relational backends.
        </p>
      </div>

      <!-- Main Grid -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left: Bio & Career Objective -->
        <div class="lg:col-span-7 space-y-6">
          <div class="glass-card rounded-2xl p-6 sm:p-8 space-y-5">
            <h3 class="text-xl font-bold text-white flex items-center gap-2.5">
              <span class="w-8 h-8 rounded-lg bg-sky-500/10 border border-sky-500/20 text-sky-400 flex items-center justify-center text-sm font-mono">
                01
              </span>
              <span>Professional Introduction</span>
            </h3>
            <p class="text-slate-300 leading-relaxed text-base">
              {{ profile?.bio || 'I am a Full Stack Developer with strong foundations in Flutter, Dart, Laravel, PHP, React, and MySQL. With experience architecting enterprise resource management systems, fintech UI applications, and reactive mobile applications, I bridge the gap between polished user experiences and solid backend architectures.' }}
            </p>
            <p class="text-slate-400 leading-relaxed text-sm">
              I emphasize <strong class="text-slate-200">Clean Architecture</strong>, maintainable state management (Riverpod), and database-driven workflows with robust validation, relational integrity, and role-based permissions.
            </p>
          </div>

          <!-- Career Objective -->
          <div class="glass-card rounded-2xl p-6 sm:p-8 space-y-4 border-l-4 border-l-sky-500">
            <h4 class="text-lg font-bold text-white flex items-center gap-2">
              <svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
              </svg>
              <span>Career Objective</span>
            </h4>
            <p class="text-slate-300 text-sm leading-relaxed">
              {{ profile?.career_objective || 'Passionate and results-driven software engineer aiming to build scalable, high-performance web and mobile solutions. Dedicated to applying clean architecture, reactive state management (Riverpod), and robust backend engineering with Laravel and RESTful APIs to solve real-world problems.' }}
            </p>
          </div>

          <!-- Quick Stats Row -->
          <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div
              v-for="(stat, idx) in stats"
              :key="idx"
              class="glass-card rounded-xl p-4 text-center border border-slate-800"
            >
              <div class="text-2xl font-extrabold text-white gradient-text">{{ stat.value }}</div>
              <div class="text-xs text-slate-400 font-medium mt-1">{{ stat.label }}</div>
            </div>
          </div>
        </div>

        <!-- Right: Core Strengths & Developer Interests -->
        <div class="lg:col-span-5 space-y-6">
          
          <!-- Personal Strengths -->
          <div class="glass-card rounded-2xl p-6 sm:p-8 space-y-4">
            <h4 class="text-base font-bold text-white uppercase tracking-wider text-xs font-mono text-sky-400">
              Core Strengths
            </h4>
            <ul class="space-y-3">
              <li
                v-for="(strength, sIdx) in strengths"
                :key="sIdx"
                class="flex items-start gap-3 text-sm text-slate-300"
              >
                <div class="w-5 h-5 rounded-md bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <span>{{ strength }}</span>
              </li>
            </ul>
          </div>

          <!-- Developer Interests -->
          <div class="glass-card rounded-2xl p-6 sm:p-8 space-y-4">
            <h4 class="text-base font-bold text-white uppercase tracking-wider text-xs font-mono text-indigo-400">
              Developer Interests & Focus
            </h4>
            <div class="flex flex-wrap gap-2">
              <span
                v-for="(interest, iIdx) in interests"
                :key="iIdx"
                class="px-3 py-1.5 rounded-lg text-xs font-medium bg-slate-800/80 text-slate-300 border border-slate-700/60 hover:border-indigo-500/40 transition-colors"
              >
                {{ interest }}
              </span>
            </div>
          </div>

          <!-- Contact Quick Card -->
          <div class="p-6 rounded-2xl bg-gradient-to-br from-sky-950/40 via-indigo-950/30 to-slate-900 border border-sky-500/20 text-slate-300 text-sm space-y-3">
            <div class="font-semibold text-white flex items-center gap-2">
              <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
              <span>Based in Thrissur, Kerala, India</span>
            </div>
            <p class="text-xs text-slate-400">
              Available for relocation, hybrid, and remote opportunities across India & worldwide.
            </p>
            <div class="pt-2">
              <a
                href="mailto:malavikamm177@gmail.com"
                class="text-xs font-mono text-sky-400 hover:underline flex items-center gap-1.5"
              >
                <span>malavikamm177@gmail.com</span>
                <span>→</span>
              </a>
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

const defaultStrengths = [
  'Clean Architecture & Riverpod 3.x State Management',
  'Full-Stack API Design & Laravel MVC Architecture',
  'Role-Based Access Control & Database Relationships',
  'Custom Widget & Canvas Rendering with CustomPainter',
  'Cross-Platform Responsive Mobile & Web UI/UX',
  'Transactional Database Integrity & Conflict Prevention'
];

const defaultInterests = [
  'Mobile Architecture (Flutter & Riverpod)',
  'Backend API Engineering (Laravel & PHP)',
  'Modern Frontend (Vue.js & React)',
  'Cloud & Realtime Databases (Firebase & MySQL)',
  'Open Source Software & Developer Tooling'
];

const defaultStats = [
  { label: 'Projects Completed', value: '10+' },
  { label: 'Core Stacks', value: 'Flutter & Laravel' },
  { label: 'Clean Code Focus', value: '100%' },
  { label: 'Location', value: 'Kerala, India' }
];

const strengths = computed(() => {
  return props.profile?.strengths?.length ? props.profile.strengths : defaultStrengths;
});

const interests = computed(() => {
  return props.profile?.interests?.length ? props.profile.interests : defaultInterests;
});

const stats = computed(() => {
  return props.profile?.stats?.length ? props.profile.stats : defaultStats;
});
</script>
