<template>
  <div class="space-y-8">
    
    <!-- Top Welcome Banner -->
    <div class="glass-card rounded-3xl p-6 sm:p-8 border border-slate-800 bg-gradient-to-r from-sky-950/40 via-indigo-950/30 to-slate-900 relative overflow-hidden">
      <div class="relative z-10 max-w-2xl space-y-2">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-white">
          Welcome, <span class="gradient-text">Malavika</span> 👋
        </h1>
        <p class="text-sm text-slate-300 leading-relaxed">
          Manage your developer portfolio, update skills, showcase new projects, upload latest resume PDF, and respond to incoming recruiter messages.
        </p>
      </div>
      <div class="absolute right-6 top-1/2 -translate-y-1/2 text-7xl opacity-20 hidden lg:block">
        🚀
      </div>
    </div>

    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
      <div class="glass-card rounded-2xl p-5 border border-slate-800 space-y-1">
        <div class="text-xs font-mono text-slate-400">Total Projects</div>
        <div class="text-3xl font-extrabold text-white">{{ stats.total_projects || 0 }}</div>
        <div class="text-[11px] text-sky-400 font-mono">{{ stats.featured_projects || 0 }} featured</div>
      </div>

      <div class="glass-card rounded-2xl p-5 border border-slate-800 space-y-1">
        <div class="text-xs font-mono text-slate-400">Skills Listed</div>
        <div class="text-3xl font-extrabold text-white">{{ stats.total_skills || 0 }}</div>
        <div class="text-[11px] text-emerald-400 font-mono">Categorized & graded</div>
      </div>

      <div class="glass-card rounded-2xl p-5 border border-slate-800 space-y-1">
        <div class="text-xs font-mono text-slate-400">Contact Inquiries</div>
        <div class="text-3xl font-extrabold text-white">{{ stats.total_messages || 0 }}</div>
        <div class="text-[11px] font-mono" :class="stats.unread_messages ? 'text-rose-400 font-bold' : 'text-slate-500'">
          {{ stats.unread_messages || 0 }} unread
        </div>
      </div>

      <div class="glass-card rounded-2xl p-5 border border-slate-800 space-y-1">
        <div class="text-xs font-mono text-slate-400">Experience & Education</div>
        <div class="text-3xl font-extrabold text-white">
          {{ (stats.total_experiences || 0) + (stats.total_education || 0) }}
        </div>
        <div class="text-[11px] text-indigo-400 font-mono">Academic & timeline entries</div>
      </div>
    </div>

    <!-- Quick Navigation Shortcuts -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
      <router-link
        to="/admin/projects"
        class="glass-card glass-card-hover rounded-2xl p-5 border border-slate-800 flex items-center justify-between group"
      >
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-sky-500/10 text-sky-400 flex items-center justify-center font-bold text-lg">
            🚀
          </div>
          <div>
            <div class="text-sm font-bold text-white group-hover:text-sky-300">Add New Project</div>
            <div class="text-xs text-slate-400">Upload screenshot & tech stack</div>
          </div>
        </div>
        <span class="text-slate-500 group-hover:text-sky-400 transition-colors">→</span>
      </router-link>

      <router-link
        to="/admin/profile"
        class="glass-card glass-card-hover rounded-2xl p-5 border border-slate-800 flex items-center justify-between group"
      >
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-rose-500/10 text-rose-400 flex items-center justify-center font-bold text-lg">
            📄
          </div>
          <div>
            <div class="text-sm font-bold text-white group-hover:text-rose-300">Upload Resume PDF</div>
            <div class="text-xs text-slate-400">Keep CV updated for recruiters</div>
          </div>
        </div>
        <span class="text-slate-500 group-hover:text-rose-400 transition-colors">→</span>
      </router-link>

      <router-link
        to="/admin/messages"
        class="glass-card glass-card-hover rounded-2xl p-5 border border-slate-800 flex items-center justify-between group"
      >
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center font-bold text-lg">
            📬
          </div>
          <div>
            <div class="text-sm font-bold text-white group-hover:text-emerald-300">Review Inquiries</div>
            <div class="text-xs text-slate-400">View incoming recruiter emails</div>
          </div>
        </div>
        <span class="text-slate-500 group-hover:text-emerald-400 transition-colors">→</span>
      </router-link>
    </div>

    <!-- Recent Messages Box -->
    <div class="glass-card rounded-2xl p-6 sm:p-8 border border-slate-800 space-y-4">
      <div class="flex items-center justify-between">
        <h3 class="text-lg font-bold text-white">Recent Recruiter Inquiries</h3>
        <router-link to="/admin/messages" class="text-xs font-mono text-sky-400 hover:underline">
          View All Messages →
        </router-link>
      </div>

      <div v-if="stats.latest_messages && stats.latest_messages.length" class="space-y-3">
        <div
          v-for="msg in stats.latest_messages"
          :key="msg.id"
          class="p-4 rounded-xl bg-slate-900/80 border border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3"
        >
          <div>
            <div class="flex items-center gap-2">
              <span class="font-bold text-white text-sm">{{ msg.name }}</span>
              <span class="text-xs text-slate-400 font-mono">&lt;{{ msg.email }}&gt;</span>
              <span
                v-if="!msg.is_read"
                class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-950 text-rose-300 border border-rose-800"
              >
                NEW
              </span>
            </div>
            <div class="text-xs font-semibold text-sky-300 mt-0.5">{{ msg.subject }}</div>
            <p class="text-xs text-slate-400 mt-1 line-clamp-1">{{ msg.message }}</p>
          </div>
          <div class="text-[11px] font-mono text-slate-500 flex-shrink-0">
            {{ new Date(msg.created_at).toLocaleDateString() }}
          </div>
        </div>
      </div>

      <div v-else class="text-center py-8 text-xs text-slate-400">
        No contact messages received yet. Testing submissions from the contact form will appear here.
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import api from '../../services/api';

const stats = ref({});

const loadOverview = async () => {
  try {
    const res = await api.get('/admin/overview');
    if (res.data && res.data.data) {
      stats.value = res.data.data;
    }
  } catch (err) {
    console.error(err);
  }
};

onMounted(() => {
  loadOverview();
});
</script>
