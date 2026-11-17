<template>
  <div class="min-h-screen flex flex-col bg-[#090d16]">
    <Navbar />

    <main class="flex-1 pt-32 pb-20">
      <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Back Link -->
        <div class="mb-8">
          <router-link
            to="/#projects"
            class="inline-flex items-center gap-2 text-sm font-semibold text-slate-400 hover:text-sky-400 transition-colors"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Back to All Projects</span>
          </router-link>
        </div>

        <!-- Loading State -->
        <div v-if="loading" class="text-center py-24 space-y-4">
          <div class="w-10 h-10 border-4 border-sky-400 border-t-transparent rounded-full animate-spin mx-auto"></div>
          <p class="text-sm font-mono text-slate-400">Loading project specification...</p>
        </div>

        <!-- Project Detail Content -->
        <div v-else-if="project" class="space-y-10">
          
          <!-- Header Image Banner -->
          <div class="relative w-full aspect-video sm:aspect-[21/9] rounded-3xl overflow-hidden glass-card border border-slate-700/80 shadow-2xl">
            <img
              :src="project.image_url || '/images/projects/smart-resource-booking.svg'"
              :alt="project.title"
              class="w-full h-full object-cover"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-[#090d16] via-[#090d16]/30 to-transparent"></div>

            <div class="absolute bottom-6 left-6 right-6 flex items-center justify-between flex-wrap gap-2">
              <span class="px-4 py-1.5 rounded-xl text-xs font-mono font-bold bg-sky-950/90 text-sky-300 border border-sky-600/50 shadow-lg">
                {{ project.category }}
              </span>
              <span v-if="project.is_featured" class="px-3 py-1 rounded-xl text-xs font-semibold bg-amber-500 text-slate-950 font-mono shadow-md">
                ★ Featured Production Project
              </span>
            </div>
          </div>

          <!-- Title & Actions Row -->
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 border-b border-slate-800 pb-8">
            <div class="space-y-2">
              <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
                {{ project.title }}
              </h1>
              <p class="text-slate-400 text-base">
                {{ project.short_description }}
              </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3 flex-shrink-0">
              <a
                v-if="project.github_url"
                :href="project.github_url"
                target="_blank"
                rel="noopener noreferrer"
                class="px-5 py-2.5 rounded-xl font-semibold text-sm bg-slate-900 hover:bg-slate-800 border border-slate-700 text-white flex items-center gap-2 transition-all hover:scale-105"
              >
                <svg class="w-4 h-4 fill-currentColor" viewBox="0 0 24 24">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" />
                </svg>
                <span>GitHub Repository</span>
              </a>

              <a
                v-if="project.live_url"
                :href="project.live_url"
                target="_blank"
                rel="noopener noreferrer"
                class="px-5 py-2.5 rounded-xl font-semibold text-sm bg-emerald-500 hover:bg-emerald-400 text-slate-950 flex items-center gap-2 transition-all hover:scale-105"
              >
                <span>Live Demo</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
              </a>
            </div>
          </div>

          <!-- Problem Statement Box -->
          <div v-if="project.problem_statement" class="p-6 rounded-2xl bg-amber-950/20 border border-amber-800/40 space-y-2">
            <h3 class="text-xs font-mono font-bold text-amber-400 uppercase tracking-wider flex items-center gap-2">
              <span>⚠️</span>
              <span>The Problem Statement</span>
            </h3>
            <p class="text-slate-300 text-sm leading-relaxed">
              {{ project.problem_statement }}
            </p>
          </div>

          <!-- Full Architecture Overview -->
          <div class="glass-card rounded-2xl p-6 sm:p-8 space-y-4 border border-slate-800">
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
              <span class="w-2.5 h-2.5 rounded-full bg-sky-400"></span>
              <span>Technical Solution & Architecture</span>
            </h3>
            <p class="text-slate-300 text-sm sm:text-base leading-relaxed whitespace-pre-line">
              {{ project.full_description || project.short_description }}
            </p>
          </div>

          <!-- Features Grid -->
          <div v-if="project.features && project.features.length" class="space-y-4">
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
              <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
              <span>Key Features & Engineering Deliverables</span>
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div
                v-for="(feature, fIdx) in project.features"
                :key="fIdx"
                class="glass-card rounded-xl p-4 border border-slate-800 flex items-start gap-3"
              >
                <div class="w-5 h-5 rounded-md bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 flex items-center justify-center flex-shrink-0 mt-0.5 font-bold text-xs">
                  ✓
                </div>
                <span class="text-sm text-slate-300">{{ feature }}</span>
              </div>
            </div>
          </div>

          <!-- Technologies Grid -->
          <div v-if="project.technologies && project.technologies.length" class="space-y-4">
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
              <span class="w-2.5 h-2.5 rounded-full bg-indigo-400"></span>
              <span>Tech Stack Used</span>
            </h3>
            <div class="flex flex-wrap gap-2.5">
              <span
                v-for="(tech, tIdx) in project.technologies"
                :key="tIdx"
                class="px-4 py-2 rounded-xl text-xs font-mono font-medium bg-slate-900 text-slate-200 border border-slate-700/80 shadow-sm"
              >
                {{ tech }}
              </span>
            </div>
          </div>

          <!-- Related Projects -->
          <div v-if="relatedProjects.length" class="pt-8 border-t border-slate-800 space-y-6">
            <h3 class="text-xl font-bold text-white">Related Projects</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
              <div
                v-for="rel in relatedProjects"
                :key="rel.id"
                class="glass-card rounded-2xl p-5 border border-slate-800 space-y-3 flex flex-col justify-between"
              >
                <div>
                  <span class="text-[11px] font-mono text-sky-400">{{ rel.category }}</span>
                  <h4 class="font-bold text-white text-base mt-1 line-clamp-1">{{ rel.title }}</h4>
                  <p class="text-xs text-slate-400 line-clamp-2 mt-1">{{ rel.short_description }}</p>
                </div>
                <router-link
                  :to="`/project/${rel.slug || rel.id}`"
                  class="text-xs font-semibold text-sky-400 hover:text-sky-300 flex items-center gap-1"
                >
                  <span>Explore Project</span>
                  <span>→</span>
                </router-link>
              </div>
            </div>
          </div>

        </div>

        <!-- 404 State -->
        <div v-else class="text-center py-20 glass-card rounded-3xl border border-slate-800 space-y-4">
          <div class="text-4xl">⚠️</div>
          <h2 class="text-2xl font-bold text-white">Project Not Found</h2>
          <p class="text-sm text-slate-400">The requested project could not be located in our database.</p>
          <router-link
            to="/#projects"
            class="inline-block px-6 py-2.5 rounded-xl text-sm font-semibold bg-sky-500 text-white"
          >
            Back to All Projects
          </router-link>
        </div>

      </div>
    </main>

    <Footer />
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import { useRoute } from 'vue-router';
import api from '../services/api';
import Navbar from '../components/Navbar.vue';
import Footer from '../components/Footer.vue';

const route = useRoute();
const project = ref(null);
const relatedProjects = ref([]);
const loading = ref(true);

const loadProject = async () => {
  loading.value = true;
  try {
    const slug = route.params.slug;
    const res = await api.get(`/projects/${slug}`);
    if (res.data && res.data.data) {
      project.value = res.data.data;
      relatedProjects.value = res.data.related || [];
    }
  } catch (err) {
    project.value = null;
  } finally {
    loading.value = false;
  }
};

watch(() => route.params.slug, () => {
  loadProject();
  window.scrollTo({ top: 0, behavior: 'smooth' });
});

onMounted(() => {
  loadProject();
});
</script>

