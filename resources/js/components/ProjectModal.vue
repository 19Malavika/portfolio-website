<template>
  <transition
    enter-active-class="transition duration-300 ease-out"
    enter-from-class="opacity-0"
    enter-to-class="opacity-100"
    leave-active-class="transition duration-200 ease-in"
    leave-from-class="opacity-100"
    leave-to-class="opacity-0"
  >
    <div
      v-if="isOpen && project"
      class="fixed inset-0 z-50 overflow-y-auto bg-black/80 backdrop-blur-md flex items-center justify-center p-4 sm:p-6"
      @click.self="close"
    >
      <div
        class="relative w-full max-w-4xl bg-[#0f172a] border border-slate-700/80 rounded-3xl shadow-2xl overflow-hidden my-8 animate-in fade-in zoom-in-95 duration-200"
      >
        <!-- Modal Close Button -->
        <button
          @click="close"
          class="absolute top-4 right-4 z-20 p-2.5 rounded-full bg-slate-900/80 border border-slate-700 text-slate-300 hover:text-white hover:bg-slate-800 transition-colors shadow-lg"
          aria-label="Close modal"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>

        <!-- Large Image Header Banner -->
        <div class="relative w-full aspect-video sm:aspect-[21/9] bg-slate-950 overflow-hidden">
          <img
            :src="project.image_url || '/images/projects/smart-resource-booking.svg'"
            :alt="project.title"
            class="w-full h-full object-cover"
          />
          <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a] via-[#0f172a]/40 to-transparent"></div>
          
          <!-- Category & Status Badge -->
          <div class="absolute bottom-6 left-6 right-6 flex items-center justify-between flex-wrap gap-2">
            <span class="px-3.5 py-1.5 rounded-xl text-xs font-mono font-bold bg-sky-950/90 text-sky-300 border border-sky-600/50 shadow-lg">
              {{ project.category }}
            </span>
            <span v-if="project.is_featured" class="px-3 py-1 rounded-xl text-xs font-semibold bg-amber-500 text-slate-950 font-mono shadow-md">
              ★ Featured System
            </span>
          </div>
        </div>

        <!-- Modal Body Content -->
        <div class="p-6 sm:p-8 space-y-6 max-h-[60vh] overflow-y-auto">
          <!-- Title & External Action Links -->
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-800 pb-5">
            <div>
              <h2 class="text-2xl sm:text-3xl font-extrabold text-white">
                {{ project.title }}
              </h2>
              <p class="text-sm text-slate-400 mt-1">
                {{ project.short_description }}
              </p>
            </div>

            <!-- GitHub & Live Buttons -->
            <div class="flex items-center gap-3 flex-shrink-0">
              <a
                v-if="project.github_url"
                :href="project.github_url"
                target="_blank"
                rel="noopener noreferrer"
                class="px-4 py-2 rounded-xl text-sm font-semibold bg-slate-800 hover:bg-slate-700 text-white border border-slate-700 flex items-center gap-2 transition-all hover:scale-105"
              >
                <svg class="w-4 h-4 fill-currentColor" viewBox="0 0 24 24">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" />
                </svg>
                <span>GitHub Repo</span>
              </a>

              <a
                v-if="project.live_url"
                :href="project.live_url"
                target="_blank"
                rel="noopener noreferrer"
                class="px-4 py-2 rounded-xl text-sm font-semibold bg-emerald-500 hover:bg-emerald-400 text-slate-950 flex items-center gap-2 transition-all hover:scale-105"
              >
                <span>Live Demo</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
              </a>
            </div>
          </div>

          <!-- Problem Statement Box -->
          <div v-if="project.problem_statement" class="p-5 rounded-2xl bg-amber-950/20 border border-amber-800/40 space-y-2">
            <h4 class="text-xs font-mono font-bold text-amber-400 uppercase tracking-wider flex items-center gap-1.5">
              <span>⚠️</span>
              <span>The Problem Statement</span>
            </h4>
            <p class="text-slate-300 text-sm leading-relaxed">
              {{ project.problem_statement }}
            </p>
          </div>

          <!-- Architectural & Full Description -->
          <div class="space-y-3">
            <h4 class="text-xs font-mono font-bold text-sky-400 uppercase tracking-wider">
              Solution & Architecture Overview
            </h4>
            <p class="text-slate-300 text-sm leading-relaxed">
              {{ project.full_description || project.short_description }}
            </p>
          </div>

          <!-- Key Features Checklist -->
          <div v-if="project.features && project.features.length" class="space-y-3">
            <h4 class="text-xs font-mono font-bold text-emerald-400 uppercase tracking-wider">
              Core Technical Features & Capabilities
            </h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
              <div
                v-for="(feature, fIdx) in project.features"
                :key="fIdx"
                class="p-3 rounded-xl bg-slate-900/90 border border-slate-800 flex items-start gap-2.5 text-xs text-slate-300"
              >
                <div class="w-4 h-4 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                  ✓
                </div>
                <span>{{ feature }}</span>
              </div>
            </div>
          </div>

          <!-- Technologies Employed -->
          <div v-if="project.technologies && project.technologies.length" class="space-y-3">
            <h4 class="text-xs font-mono font-bold text-indigo-400 uppercase tracking-wider">
              Technologies & Frameworks
            </h4>
            <div class="flex flex-wrap gap-2">
              <span
                v-for="(tech, tIdx) in project.technologies"
                :key="tIdx"
                class="px-3 py-1.5 rounded-lg text-xs font-mono font-medium bg-slate-800 text-slate-200 border border-slate-700"
              >
                {{ tech }}
              </span>
            </div>
          </div>

        </div>

        <!-- Modal Footer -->
        <div class="p-6 bg-slate-950/80 border-t border-slate-800 flex items-center justify-between">
          <router-link
            :to="`/project/${project.slug || project.id}`"
            class="text-xs font-mono text-slate-400 hover:text-white flex items-center gap-1"
          >
            <span>Open Dedicated Standalone Page</span>
            <span>↗</span>
          </router-link>

          <button
            @click="close"
            class="px-5 py-2 rounded-xl text-sm font-semibold bg-slate-800 hover:bg-slate-700 text-white transition-colors"
          >
            Close
          </button>
        </div>

      </div>
    </div>
  </transition>
</template>

<script setup>
import { onMounted, onUnmounted } from 'vue';

const props = defineProps({
  isOpen: {
    type: Boolean,
    default: false
  },
  project: {
    type: Object,
    default: null
  }
});

const emit = defineEmits(['close']);

const close = () => {
  emit('close');
};

const handleKeyDown = (e) => {
  if (e.key === 'Escape' && props.isOpen) {
    close();
  }
};

onMounted(() => {
  window.addEventListener('keydown', handleKeyDown);
});

onUnmounted(() => {
  window.removeEventListener('keydown', handleKeyDown);
});
</script>
