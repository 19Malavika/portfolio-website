<template>
  <div class="min-h-screen flex items-center justify-center p-4 bg-[#090d16] relative overflow-hidden">
    <!-- Ambient glow -->
    <div class="absolute w-[500px] h-[500px] bg-sky-500/10 rounded-full blur-3xl -top-20 -left-20 pointer-events-none"></div>
    <div class="absolute w-[400px] h-[400px] bg-indigo-500/10 rounded-full blur-3xl -bottom-20 -right-20 pointer-events-none"></div>

    <div class="w-full max-w-md relative">
      <!-- Back to site link -->
      <div class="mb-6 text-center">
        <router-link
          to="/"
          class="inline-flex items-center gap-2 text-xs font-mono text-slate-400 hover:text-sky-400 transition-colors"
        >
          <span>← Back to Public Portfolio</span>
        </router-link>
      </div>

      <!-- Login Card -->
      <div class="glass-card rounded-3xl p-8 sm:p-10 border border-slate-700/80 shadow-2xl relative">
        <div class="text-center space-y-2 mb-8">
          <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-sky-400 to-indigo-600 flex items-center justify-center text-white font-mono font-bold text-xl mx-auto shadow-lg shadow-sky-500/20">
            🔒
          </div>
          <h1 class="text-2xl font-extrabold text-white tracking-tight">Admin Portal</h1>
          <p class="text-xs text-slate-400">
            Authenticate to manage portfolio content, projects, and contact messages.
          </p>
        </div>

        <!-- Error Alert -->
        <div
          v-if="errorMessage"
          class="mb-6 p-4 rounded-xl bg-rose-950/80 border border-rose-700/60 text-xs text-rose-300 flex items-start gap-2.5"
        >
          <span class="text-sm">⚠️</span>
          <span>{{ errorMessage }}</span>
        </div>

        <form @submit.prevent="handleLogin" class="space-y-4">
          <div>
            <label class="block text-xs font-mono font-medium text-slate-300 mb-1.5">
              Email Address
            </label>
            <input
              v-model="email"
              type="email"
              required
              autocomplete="email"
              placeholder="admin@example.com"
              class="w-full px-4 py-3 rounded-xl bg-slate-900/90 border border-slate-800 text-slate-100 text-sm focus:outline-none focus:border-sky-500 transition-colors"
            />
          </div>

          <div>
            <label class="block text-xs font-mono font-medium text-slate-300 mb-1.5">
              Password
            </label>
            <input
              v-model="password"
              type="password"
              required
              autocomplete="current-password"
              placeholder="••••••••"
              class="w-full px-4 py-3 rounded-xl bg-slate-900/90 border border-slate-800 text-slate-100 text-sm focus:outline-none focus:border-sky-500 transition-colors"
            />
          </div>

          <!-- Quick Seeded Credentials Box for effortless testing -->
          <div class="p-3 rounded-xl bg-slate-900/60 border border-slate-800 text-[11px] font-mono text-slate-400 space-y-1">
            <div class="text-slate-300 font-semibold">Demo Credentials:</div>
            <div>Email: <span class="text-sky-300 select-all">malavikamm177@gmail.com</span></div>
            <div>Password: <span class="text-sky-300 select-all">admin12345</span></div>
          </div>

          <button
            type="submit"
            :disabled="loading"
            class="w-full py-3.5 px-6 rounded-xl font-semibold text-white bg-gradient-to-r from-sky-500 to-indigo-600 hover:from-sky-400 hover:to-indigo-500 shadow-lg shadow-sky-500/25 transition-all hover:scale-[1.02] flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50"
          >
            <span v-if="loading" class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
            <span>{{ loading ? 'Authenticating...' : 'Sign In to Dashboard' }}</span>
          </button>
        </form>

      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import api from '../services/api';

const router = useRouter();
const route = useRoute();

const email = ref('malavikamm177@gmail.com');
const password = ref('admin12345');
const loading = ref(false);
const errorMessage = ref('');

const handleLogin = async () => {
  loading.value = true;
  errorMessage.value = '';

  try {
    const res = await api.post('/auth/login', {
      email: email.value,
      password: password.value,
    });

    if (res.data && res.data.token) {
      localStorage.setItem('admin_token', res.data.token);
      localStorage.setItem('admin_user', JSON.stringify(res.data.user));

      const redirect = route.query.redirect || '/admin/dashboard';
      router.push(redirect);
    }
  } catch (err) {
    if (err.response && err.response.data && err.response.data.message) {
      errorMessage.value = err.response.data.message;
    } else {
      errorMessage.value = 'Failed to authenticate. Please check server connection.';
    }
  } finally {
    loading.value = false;
  }
};
</script>

