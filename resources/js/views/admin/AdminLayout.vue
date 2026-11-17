<template>
  <div class="min-h-screen bg-[#070a12] text-slate-100 flex flex-col md:flex-row">
    
    <!-- Sidebar Navigation -->
    <aside class="w-full md:w-64 bg-[#0d1322] border-r border-slate-800 flex flex-col flex-shrink-0">
      
      <!-- Brand Header -->
      <div class="p-6 border-b border-slate-800 flex items-center justify-between">
        <router-link to="/admin/dashboard" class="flex items-center gap-2.5">
          <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-sky-400 to-indigo-600 flex items-center justify-center font-mono font-bold text-white text-sm shadow-md">
            M
          </div>
          <div>
            <div class="font-bold text-sm text-white">Malavika Admin</div>
            <div class="text-[10px] font-mono text-sky-400">Portfolio CMS</div>
          </div>
        </router-link>

        <router-link
          to="/"
          target="_blank"
          class="p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800"
          title="Open Public Site in New Tab"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
          </svg>
        </router-link>
      </div>

      <!-- Navigation Menu Items -->
      <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
        <router-link
          v-for="item in navItems"
          :key="item.path"
          :to="item.path"
          class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-medium transition-all"
          :class="[
            $route.path === item.path
              ? 'bg-sky-500/15 text-sky-400 font-semibold border border-sky-500/30'
              : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/60'
          ]"
        >
          <span class="text-base">{{ item.icon }}</span>
          <span>{{ item.label }}</span>
        </router-link>
      </nav>

      <!-- Sidebar Footer User / Logout -->
      <div class="p-4 border-t border-slate-800 space-y-2">
        <div class="px-3 py-2 rounded-xl bg-slate-900 border border-slate-800 text-xs">
          <div class="text-slate-300 font-medium truncate">{{ adminUser?.name || 'Malavika M M' }}</div>
          <div class="text-[10px] font-mono text-slate-500 truncate">{{ adminUser?.email || 'admin@portfolio' }}</div>
        </div>

        <button
          @click="handleLogout"
          class="w-full px-3 py-2 rounded-xl text-xs font-semibold text-rose-400 hover:bg-rose-500/10 border border-rose-500/20 flex items-center justify-center gap-2 transition-colors cursor-pointer"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
          </svg>
          <span>Sign Out</span>
        </button>
      </div>

    </aside>

    <!-- Main Admin Content Area -->
    <div class="flex-1 flex flex-col min-w-0">
      
      <!-- Top Bar -->
      <header class="h-16 bg-[#090d16] border-b border-slate-800 px-6 flex items-center justify-between">
        <h2 class="text-base font-bold text-white flex items-center gap-2">
          <span>Admin Control Center</span>
          <span class="text-slate-600">/</span>
          <span class="text-sky-400 text-xs font-mono font-normal">{{ currentRouteName }}</span>
        </h2>

        <div class="flex items-center gap-4">
          <router-link
            to="/"
            class="text-xs font-semibold text-sky-400 hover:text-sky-300 flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-sky-500/10 border border-sky-500/20"
          >
            <span>Live Portfolio</span>
            <span>↗</span>
          </router-link>
        </div>
      </header>

      <!-- Sub-view content -->
      <main class="flex-1 p-6 sm:p-8 overflow-y-auto">
        <router-view />
      </main>

    </div>

  </div>
</template>

<script setup>
import { computed } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import api from '../../services/api';

const router = useRouter();
const route = useRoute();

const navItems = [
  { label: 'Overview Dashboard', path: '/admin/dashboard', icon: '📊' },
  { label: 'Profile & Resume', path: '/admin/profile', icon: '👤' },
  { label: 'Manage Projects', path: '/admin/projects', icon: '🚀' },
  { label: 'Manage Skills', path: '/admin/skills', icon: '⚡' },
  { label: 'Experience & Timeline', path: '/admin/experience', icon: '💼' },
  { label: 'Education Details', path: '/admin/education', icon: '🎓' },
  { label: 'Certifications', path: '/admin/certifications', icon: '🏆' },
  { label: 'Social & Web Links', path: '/admin/social-links', icon: '🌐' },
  { label: 'Contact Messages', path: '/admin/messages', icon: '📬' },
];

const currentRouteName = computed(() => {
  const item = navItems.find(i => i.path === route.path);
  return item ? item.label : 'Management';
});

const adminUser = computed(() => {
  try {
    return JSON.parse(localStorage.getItem('admin_user') || '{}');
  } catch {
    return {};
  }
});

const handleLogout = async () => {
  try {
    await api.post('/auth/logout');
  } catch (err) {
    // continue
  }
  localStorage.removeItem('admin_token');
  localStorage.removeItem('admin_user');
  router.push('/login');
};
</script>
