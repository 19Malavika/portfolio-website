<template>
  <section id="skills" class="py-20 relative border-t border-slate-800/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Section Header -->
      <div class="text-center max-w-3xl mx-auto mb-14 space-y-3">
        <span class="px-3 py-1 rounded-full text-xs font-mono font-semibold tracking-wider text-emerald-400 bg-emerald-950/60 border border-emerald-800/40 uppercase">
          Technical Arsenal
        </span>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
          Skills & <span class="gradient-text">Competencies</span>
        </h2>
        <p class="text-slate-400 text-base leading-relaxed">
          Carefully cultivated skills across mobile development, backend engineering, databases, and modern developer tooling.
        </p>

        <!-- Category Filter Tabs -->
        <div class="flex items-center justify-center gap-2 flex-wrap pt-4">
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
      </div>

      <!-- Skills Cards Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        <div
          v-for="skill in filteredSkills"
          :key="skill.id || skill.name"
          class="glass-card glass-card-hover rounded-2xl p-5 border border-slate-800 relative overflow-hidden group"
        >
          <!-- Top row: Name, Category & Level badge -->
          <div class="flex items-center justify-between gap-3 mb-3">
            <div class="flex items-center gap-3">
              <!-- Icon indicator -->
              <div class="w-10 h-10 rounded-xl bg-slate-800/90 border border-slate-700/60 flex items-center justify-center text-sky-400 font-mono text-sm font-bold group-hover:border-sky-500/50 group-hover:text-sky-300 transition-colors">
                {{ getInitial(skill.name) }}
              </div>
              <div>
                <h4 class="font-bold text-white text-base group-hover:text-sky-300 transition-colors">
                  {{ skill.name }}
                </h4>
                <span class="text-xs font-mono text-slate-400">
                  {{ skill.category }}
                </span>
              </div>
            </div>

            <!-- Level Label Pill -->
            <span
              class="px-2.5 py-1 rounded-md text-[11px] font-mono font-medium border"
              :class="getLevelBadgeClasses(skill.proficiency)"
            >
              {{ skill.level_label || getLevelLabel(skill.proficiency) }}
            </span>
          </div>

          <!-- Progress Bar -->
          <div class="space-y-1.5 mt-4">
            <div class="flex justify-between text-xs text-slate-400 font-mono">
              <span>Proficiency</span>
              <span class="text-slate-200 font-semibold">{{ skill.proficiency }}%</span>
            </div>
            <div class="w-full h-2 rounded-full bg-slate-800 overflow-hidden">
              <div
                class="h-full rounded-full transition-all duration-700 ease-out"
                :class="getProgressGradient(skill.category)"
                :style="{ width: `${skill.proficiency}%` }"
              ></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Skill Stack Categorized Summary Badges -->
      <div class="mt-16 glass-card rounded-2xl p-6 sm:p-8 border border-slate-800">
        <h3 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
          <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span>Architecture & Specialized Methodology</span>
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
          <div class="space-y-2">
            <div class="font-semibold text-sky-400 font-mono text-xs uppercase tracking-wider">Mobile Architecture</div>
            <p class="text-slate-300 text-xs leading-relaxed">
              Riverpod 3.x StateNotifier, derived providers, reactive rebuild optimization, Clean Architecture (Data, Domain, Presentation), Material 3 design systems.
            </p>
          </div>
          <div class="space-y-2">
            <div class="font-semibold text-rose-400 font-mono text-xs uppercase tracking-wider">Backend Architecture</div>
            <p class="text-slate-300 text-xs leading-relaxed">
              Laravel MVC, RESTful APIs, Eloquent ORM relationships, database transactions, form validation requests, authentication & role-based access control.
            </p>
          </div>
          <div class="space-y-2">
            <div class="font-semibold text-emerald-400 font-mono text-xs uppercase tracking-wider">Data & Tools</div>
            <p class="text-slate-300 text-xs leading-relaxed">
              MySQL schema normalization, foreign key constraints, Firebase Realtime Database, Git & GitHub feature branching, Axios API consumption.
            </p>
          </div>
        </div>
      </div>

    </div>
  </section>
</template>

<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
  skills: {
    type: Array,
    default: () => []
  }
});

const selectedCategory = ref('All');

const categories = ['All', 'Programming', 'Mobile', 'Backend', 'Frontend', 'Database', 'Tools'];

const filteredSkills = computed(() => {
  if (selectedCategory.value === 'All') {
    return props.skills;
  }
  return props.skills.filter(s => s.category.toLowerCase() === selectedCategory.value.toLowerCase());
});

const getInitial = (name) => {
  return name ? name.substring(0, 2).toUpperCase() : '</>';
};

const getLevelLabel = (score) => {
  if (score >= 90) return 'Advanced';
  if (score >= 80) return 'Proficient';
  return 'Intermediate';
};

const getLevelBadgeClasses = (score) => {
  if (score >= 90) {
    return 'bg-emerald-950/60 text-emerald-300 border-emerald-800/50';
  }
  if (score >= 80) {
    return 'bg-sky-950/60 text-sky-300 border-sky-800/50';
  }
  return 'bg-indigo-950/60 text-indigo-300 border-indigo-800/50';
};

const getProgressGradient = (category) => {
  const cat = (category || '').toLowerCase();
  if (cat.includes('mobile')) {
    return 'bg-gradient-to-r from-sky-500 to-indigo-500';
  }
  if (cat.includes('backend')) {
    return 'bg-gradient-to-r from-rose-500 to-pink-500';
  }
  if (cat.includes('frontend')) {
    return 'bg-gradient-to-r from-emerald-500 to-teal-400';
  }
  if (cat.includes('database')) {
    return 'bg-gradient-to-r from-amber-500 to-orange-500';
  }
  return 'bg-gradient-to-r from-sky-400 to-indigo-500';
};
</script>
