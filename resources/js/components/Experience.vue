<template>
  <section id="experience" class="py-20 relative border-t border-slate-800/60 bg-[#090d16]/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Section Header -->
      <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
        <span class="px-3 py-1 rounded-full text-xs font-mono font-semibold tracking-wider text-indigo-400 bg-indigo-950/60 border border-indigo-800/40 uppercase">
          Career Journey
        </span>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
          Experience & <span class="gradient-text">Practical Work</span>
        </h2>
        <p class="text-slate-400 text-base leading-relaxed">
          Demonstrated history architecting web applications, cross-platform mobile apps, and engineering database-driven systems.
        </p>
      </div>

      <!-- Timeline Container -->
      <div class="relative max-w-4xl mx-auto">
        
        <!-- Central vertical line for desktop -->
        <div class="hidden md:block absolute left-1/2 top-4 bottom-4 -translate-x-1/2 w-0.5 bg-gradient-to-b from-sky-500/80 via-indigo-500/50 to-transparent"></div>

        <!-- Left vertical line for mobile -->
        <div class="md:hidden absolute left-6 top-4 bottom-4 w-0.5 bg-gradient-to-b from-sky-500/80 via-indigo-500/50 to-transparent"></div>

        <div class="space-y-12">
          <div
            v-for="(item, idx) in experiences"
            :key="item.id || idx"
            class="relative flex flex-col md:flex-row items-start group"
            :class="idx % 2 === 0 ? 'md:flex-row-reverse' : ''"
          >
            <!-- Timeline Center Marker / Node -->
            <div class="absolute left-6 md:left-1/2 -translate-x-1/2 top-6 w-5 h-5 rounded-full bg-[#0b0f19] border-4 border-sky-400 shadow-md shadow-sky-500/50 z-10 group-hover:scale-125 group-hover:border-emerald-400 transition-all"></div>

            <!-- Content Card -->
            <div
              class="ml-14 md:ml-0 md:w-1/2"
              :class="idx % 2 === 0 ? 'md:pl-10' : 'md:pr-10'"
            >
              <div class="glass-card glass-card-hover rounded-2xl p-6 sm:p-7 border border-slate-800 relative">
                
                <!-- Period & Status -->
                <div class="flex items-center justify-between gap-2 flex-wrap mb-2">
                  <span class="px-3 py-1 rounded-full text-xs font-mono font-semibold bg-sky-950/80 text-sky-300 border border-sky-800/40">
                    {{ item.start_date }} — {{ item.end_date || 'Present' }}
                  </span>
                  <span
                    v-if="item.is_current"
                    class="px-2.5 py-0.5 rounded text-[11px] font-medium bg-emerald-950/80 text-emerald-400 border border-emerald-800/50"
                  >
                    Current Role
                  </span>
                </div>

                <!-- Position & Company -->
                <h3 class="text-xl font-bold text-white group-hover:text-sky-300 transition-colors">
                  {{ item.position }}
                </h3>
                <div class="text-sm font-medium text-slate-300 flex items-center gap-2 mt-1">
                  <span>{{ item.company }}</span>
                  <span v-if="item.location" class="text-slate-500">•</span>
                  <span v-if="item.location" class="text-xs text-slate-400 font-mono">{{ item.location }}</span>
                </div>

                <!-- Description -->
                <p class="text-sm text-slate-400 leading-relaxed mt-4">
                  {{ item.description }}
                </p>

                <!-- Key Achievements -->
                <div v-if="item.achievements && item.achievements.length" class="mt-4 pt-4 border-t border-slate-800/80 space-y-2">
                  <div class="text-xs font-mono font-semibold text-slate-300 uppercase tracking-wider">
                    Key Highlights
                  </div>
                  <ul class="space-y-1.5">
                    <li
                      v-for="(ach, aIdx) in item.achievements"
                      :key="aIdx"
                      class="text-xs text-slate-300 flex items-start gap-2"
                    >
                      <span class="text-emerald-400 font-bold mt-0.5">▹</span>
                      <span>{{ ach }}</span>
                    </li>
                  </ul>
                </div>

                <!-- Technologies Used -->
                <div v-if="item.technologies && item.technologies.length" class="mt-5 flex flex-wrap gap-1.5">
                  <span
                    v-for="(tech, tIdx) in item.technologies"
                    :key="tIdx"
                    class="px-2.5 py-1 rounded-md text-[11px] font-mono bg-slate-800/90 text-slate-300 border border-slate-700/60"
                  >
                    {{ tech }}
                  </span>
                </div>

              </div>
            </div>

          </div>
        </div>

      </div>

    </div>
  </section>
</template>

<script setup>
defineProps({
  experiences: {
    type: Array,
    default: () => []
  }
});
</script>
