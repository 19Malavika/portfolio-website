<template>
  <div class="glass-card glass-card-hover rounded-2xl overflow-hidden border border-slate-800 flex flex-col h-full group">
    
    <!-- Image Header with Hover Action Overlay -->
    <div class="relative aspect-video w-full overflow-hidden bg-slate-900">
      <img
        :src="project.image_url || '/images/projects/smart-resource-booking.svg'"
        :alt="project.title"
        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
        loading="lazy"
      />
      
      <!-- Category Tag on Top Left -->
      <div class="absolute top-3 left-3">
        <span
          class="px-3 py-1 rounded-lg text-xs font-mono font-semibold backdrop-blur-md border shadow-md"
          :class="getCategoryBadgeClass(project.category)"
        >
          {{ project.category }}
        </span>
      </div>

      <!-- Featured Star on Top Right -->
      <div v-if="project.is_featured" class="absolute top-3 right-3">
        <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-amber-500/90 text-slate-950 flex items-center gap-1 shadow-md">
          ★ Featured
        </span>
      </div>
    </div>

    <!-- Body -->
    <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
      <div class="space-y-2">
        <h3 class="text-xl font-bold text-white group-hover:text-sky-300 transition-colors line-clamp-1">
          {{ project.title }}
        </h3>
        
        <p class="text-sm text-slate-400 leading-relaxed line-clamp-3">
          {{ project.short_description }}
        </p>
      </div>

      <!-- Feature Bullet Points (First 2) -->
      <div v-if="project.features && project.features.length" class="space-y-1.5 pt-1">
        <div
          v-for="(feat, fIdx) in project.features.slice(0, 2)"
          :key="fIdx"
          class="text-xs text-slate-300 flex items-start gap-2 line-clamp-1"
        >
          <span class="text-sky-400 font-bold">✓</span>
          <span class="truncate">{{ feat }}</span>
        </div>
      </div>

      <!-- Tech Stack Badges -->
      <div class="pt-2 flex flex-wrap gap-1.5">
        <span
          v-for="(tech, tIdx) in (project.technologies || []).slice(0, 5)"
          :key="tIdx"
          class="px-2.5 py-0.5 rounded-md text-[11px] font-mono bg-slate-800/90 text-slate-300 border border-slate-700/60"
        >
          {{ tech }}
        </span>
        <span
          v-if="project.technologies && project.technologies.length > 5"
          class="px-2 py-0.5 rounded-md text-[11px] font-mono bg-slate-800 text-slate-400"
        >
          +{{ project.technologies.length - 5 }}
        </span>
      </div>

      <!-- Actions -->
      <div class="pt-4 border-t border-slate-800 flex items-center justify-between gap-2">
        <!-- View Details Button (Emits event to open modal) -->
        <button
          @click="$emit('view-details', project)"
          class="text-xs font-semibold text-sky-400 hover:text-sky-300 flex items-center gap-1.5 py-1.5 px-3 rounded-lg hover:bg-sky-500/10 transition-colors"
        >
          <span>View Details</span>
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
          </svg>
        </button>

        <div class="flex items-center gap-2">
          <!-- GitHub Repo -->
          <a
            v-if="project.github_url"
            :href="project.github_url"
            target="_blank"
            rel="noopener noreferrer"
            class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 border border-slate-800 transition-colors"
            title="View Source on GitHub"
          >
            <svg class="w-4 h-4 fill-currentColor" viewBox="0 0 24 24">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" />
            </svg>
          </a>

          <!-- Live Demo Link (if any) -->
          <a
            v-if="project.live_url"
            :href="project.live_url"
            target="_blank"
            rel="noopener noreferrer"
            class="p-2 rounded-lg text-emerald-400 hover:text-white hover:bg-emerald-600 border border-emerald-500/40 transition-colors"
            title="Live Demo"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
          </a>
        </div>
      </div>
    </div>

  </div>
</template>

<script setup>
defineProps({
  project: {
    type: Object,
    required: true
  }
});

defineEmits(['view-details']);

const getCategoryBadgeClass = (category) => {
  const cat = (category || '').toLowerCase();
  if (cat.includes('mobile') || cat.includes('flutter')) {
    return 'bg-sky-950/80 text-sky-300 border-sky-700/60';
  }
  if (cat.includes('full stack') || cat.includes('laravel')) {
    return 'bg-rose-950/80 text-rose-300 border-rose-700/60';
  }
  if (cat.includes('frontend') || cat.includes('react')) {
    return 'bg-emerald-950/80 text-emerald-300 border-emerald-700/60';
  }
  return 'bg-slate-900/80 text-slate-300 border-slate-700/60';
};
</script>

