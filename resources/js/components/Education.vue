<template>
  <section id="education" class="py-20 relative border-t border-slate-800/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Section Header -->
      <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
        <span class="px-3 py-1 rounded-full text-xs font-mono font-semibold tracking-wider text-rose-400 bg-rose-950/60 border border-rose-800/40 uppercase">
          Academic Foundation
        </span>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
          Education & <span class="gradient-text">Qualifications</span>
        </h2>
        <p class="text-slate-400 text-base leading-relaxed">
          Grounded in Computer Science theory, software design principles, and systems architecture.
        </p>
      </div>

      <!-- Education Cards -->
      <div class="max-w-4xl mx-auto space-y-6">
        <div
          v-for="(edu, idx) in education"
          :key="edu.id || idx"
          class="glass-card glass-card-hover rounded-2xl p-6 sm:p-8 border border-slate-800 relative overflow-hidden"
        >
          <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
            
            <!-- Degree & College Info -->
            <div class="space-y-2">
              <div class="inline-flex items-center gap-2 px-3 py-1 rounded-md text-xs font-mono font-semibold bg-rose-950/70 text-rose-300 border border-rose-800/40">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                </svg>
                <span>{{ edu.duration }}</span>
              </div>

              <h3 class="text-xl sm:text-2xl font-bold text-white">
                {{ edu.degree }}
              </h3>

              <div class="text-slate-300 font-medium text-base">
                {{ edu.institution }}
              </div>

              <div v-if="edu.university" class="text-xs text-sky-400 font-mono">
                Affiliated to {{ edu.university }} • {{ edu.location }}
              </div>
            </div>

            <!-- CGPA Badge -->
            <div v-if="edu.cgpa" class="flex-shrink-0">
              <div class="px-4 py-2.5 rounded-xl bg-gradient-to-br from-emerald-500/20 to-sky-500/20 border border-emerald-500/40 text-center shadow-lg">
                <div class="text-xs font-mono text-emerald-400 uppercase tracking-wider font-semibold">Academic Score</div>
                <div class="text-xl font-extrabold text-white mt-0.5">{{ edu.cgpa }}</div>
              </div>
            </div>

          </div>

          <!-- Description -->
          <p v-if="edu.description" class="text-slate-300 text-sm leading-relaxed mt-5 pt-4 border-t border-slate-800/80">
            {{ edu.description }}
          </p>

          <!-- Highlights List -->
          <div v-if="edu.highlights && edu.highlights.length" class="mt-4 space-y-2">
            <div class="text-xs font-mono font-semibold text-slate-400 uppercase tracking-wider">
              Academic & Capstone Highlights
            </div>
            <ul class="space-y-1.5">
              <li
                v-for="(h, hIdx) in edu.highlights"
                :key="hIdx"
                class="text-xs text-slate-300 flex items-start gap-2"
              >
                <span class="text-sky-400 font-bold mt-0.5">✔</span>
                <span>{{ h }}</span>
              </li>
            </ul>
          </div>

        </div>
      </div>

    </div>
  </section>
</template>

<script setup>
defineProps({
  education: {
    type: Array,
    default: () => []
  }
});
</script>
