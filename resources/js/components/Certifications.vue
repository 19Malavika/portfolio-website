<template>
  <section id="certifications" class="py-20 relative border-t border-slate-800/60 bg-[#090d16]/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Section Header -->
      <div class="text-center max-w-3xl mx-auto mb-14 space-y-3">
        <span class="px-3 py-1 rounded-full text-xs font-mono font-semibold tracking-wider text-amber-400 bg-amber-950/60 border border-amber-800/40 uppercase">
          Continuous Learning
        </span>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
          Certifications & <span class="gradient-text">Specializations</span>
        </h2>
        <p class="text-slate-400 text-base leading-relaxed">
          Demonstrated commitment to modern engineering standards, mobile architecture, and full-stack software development.
        </p>
      </div>

      <!-- Certifications Grid -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
        <div
          v-for="(cert, idx) in certifications"
          :key="cert.id || idx"
          class="glass-card glass-card-hover rounded-2xl p-6 border border-slate-800 flex flex-col justify-between space-y-4"
        >
          <div class="space-y-3">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500/20 to-sky-500/20 border border-amber-500/30 text-amber-400 flex items-center justify-center font-bold text-xl">
              🏆
            </div>

            <div class="space-y-1">
              <span class="text-xs font-mono text-sky-400">{{ cert.issue_date || 'Certified' }}</span>
              <h3 class="text-lg font-bold text-white leading-snug">
                {{ cert.title }}
              </h3>
              <p class="text-xs text-slate-400 font-medium">
                {{ cert.issuer }}
              </p>
            </div>

            <p v-if="cert.description" class="text-xs text-slate-300 leading-relaxed pt-2">
              {{ cert.description }}
            </p>
          </div>

          <div class="pt-4 border-t border-slate-800 flex items-center justify-between text-xs">
            <span v-if="cert.credential_id" class="font-mono text-slate-500 truncate">
              ID: {{ cert.credential_id }}
            </span>
            <a
              v-if="cert.credential_url"
              :href="cert.credential_url"
              target="_blank"
              rel="noopener noreferrer"
              class="text-sky-400 hover:text-sky-300 font-semibold flex items-center gap-1 ml-auto"
            >
              <span>Verify Credential</span>
              <span>↗</span>
            </a>
          </div>
        </div>
      </div>

    </div>
  </section>
</template>

<script setup>
defineProps({
  certifications: {
    type: Array,
    default: () => []
  }
});
</script>

