<template>
  <section id="projects" class="py-20 relative border-t border-slate-800/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Section Header -->
      <div class="text-center max-w-3xl mx-auto mb-12 space-y-3">
        <span class="px-3 py-1 rounded-full text-xs font-mono font-semibold tracking-wider text-sky-400 bg-sky-950/60 border border-sky-800/40 uppercase">
          Featured Engineering
        </span>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
          Projects & <span class="gradient-text">Architectural Systems</span>
        </h2>
        <p class="text-slate-400 text-base leading-relaxed">
          Real production systems, enterprise platforms, and cross-platform mobile apps engineered with clean code and modern frameworks.
        </p>
      </div>

      <!-- Controls: Category Filter Tabs & Search Bar -->
      <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
        
        <!-- Category Tabs -->
        <div class="flex items-center gap-2 flex-wrap">
          <button
            v-for="cat in categories"
            :key="cat"
            @click="selectedCategory = cat"
            class="px-4 py-2 rounded-xl text-xs sm:text-sm font-medium transition-all"
            :class="[
              selectedCategory === cat
                ? 'bg-sky-500 text-white shadow-md shadow-sky-500/25 scale-105'
                : 'bg-slate-900/80 text-slate-400 hover:text-slate-200 hover:bg-slate-800 border border-slate-800'
            ]"
          >
            {{ cat }}
          </button>
        </div>

        <!-- Search Input -->
        <div class="relative w-full md:w-72">
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search tech (e.g. Flutter, Laravel)..."
            class="w-full px-4 py-2.5 pl-10 rounded-xl bg-slate-900/90 border border-slate-800 text-slate-200 text-xs sm:text-sm placeholder-slate-500 focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-colors"
          />
          <svg class="w-4 h-4 text-slate-500 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </div>

      </div>

      <!-- Projects Grid -->
      <div v-if="filteredProjects.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
        <ProjectCard
          v-for="proj in filteredProjects"
          :key="proj.id || proj.slug"
          :project="proj"
          @view-details="openModal"
        />
      </div>

      <!-- Empty State -->
      <div v-else class="text-center py-16 glass-card rounded-2xl border border-slate-800 space-y-3">
        <div class="text-3xl">🔍</div>
        <h3 class="text-lg font-bold text-white">No projects match your filter</h3>
        <p class="text-xs text-slate-400">Try adjusting your search query or select "All" categories.</p>
        <button
          @click="selectedCategory = 'All'; searchQuery = ''"
          class="px-4 py-2 rounded-xl text-xs font-semibold bg-sky-500 text-white"
        >
          Reset Filters
        </button>
      </div>

      <!-- GitHub Repositories Footer Banner -->
      <div class="mt-16 text-center">
        <a
          href="https://github.com/19Malavika?tab=repositories"
          target="_blank"
          rel="noopener noreferrer"
          class="inline-flex items-center gap-2.5 px-6 py-3 rounded-2xl bg-slate-900/90 hover:bg-slate-800 border border-slate-700/80 text-sm font-semibold text-slate-200 hover:text-white shadow-lg transition-all hover:scale-105"
        >
          <svg class="w-5 h-5 fill-currentColor" viewBox="0 0 24 24">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" />
          </svg>
          <span>Explore All 10+ Repositories on GitHub</span>
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
          </svg>
        </a>
      </div>

    </div>

    <!-- Project Inspection Modal -->
    <ProjectModal
      :is-open="isModalOpen"
      :project="selectedProject"
      @close="isModalOpen = false"
    />
  </section>
</template>

<script setup>
import { ref, computed } from 'vue';
import ProjectCard from './ProjectCard.vue';
import ProjectModal from './ProjectModal.vue';

const props = defineProps({
  projects: {
    type: Array,
    default: () => []
  }
});

const selectedCategory = ref('All');
const searchQuery = ref('');
const isModalOpen = ref(false);
const selectedProject = ref(null);

const categories = ['All', 'Full Stack', 'Mobile (Flutter)', 'Frontend'];

const filteredProjects = computed(() => {
  return props.projects.filter(p => {
    const matchesCategory = selectedCategory.value === 'All' ||
      (p.category && p.category.toLowerCase().includes(selectedCategory.value.toLowerCase().replace(' (flutter)', '')));
    
    if (!matchesCategory) return false;

    if (!searchQuery.value.trim()) return true;

    const q = searchQuery.value.toLowerCase();
    const titleMatch = (p.title || '').toLowerCase().includes(q);
    const descMatch = (p.short_description || '').toLowerCase().includes(q);
    const techMatch = Array.isArray(p.technologies) && p.technologies.some(t => t.toLowerCase().includes(q));

    return titleMatch || descMatch || techMatch;
  });
});

const openModal = (project) => {
  selectedProject.value = project;
  isModalOpen.value = true;
};
</script>

