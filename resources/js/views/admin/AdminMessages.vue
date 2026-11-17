<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between flex-wrap gap-4">
      <div>
        <h1 class="text-2xl font-extrabold text-white">Contact Submissions Inbox</h1>
        <p class="text-xs text-slate-400">Incoming inquiries from recruiters, founders, and visitors.</p>
      </div>

      <button
        @click="loadMessages"
        class="px-4 py-2 rounded-xl text-xs font-semibold bg-slate-800 hover:bg-slate-700 text-slate-300 flex items-center gap-1.5"
      >
        <span>🔄 Refresh</span>
      </button>
    </div>

    <!-- Message list -->
    <div v-if="messages.length" class="space-y-3">
      <div
        v-for="msg in messages"
        :key="msg.id"
        class="glass-card rounded-2xl p-5 border transition-all"
        :class="msg.is_read ? 'border-slate-800 opacity-90' : 'border-sky-500/40 bg-sky-950/10 shadow-lg shadow-sky-500/5'"
      >
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-800/80 pb-3">
          <div class="flex items-center gap-2.5">
            <span class="font-bold text-white text-sm">{{ msg.name }}</span>
            <span class="text-xs text-sky-400 font-mono">&lt;{{ msg.email }}&gt;</span>
            <span
              v-if="!msg.is_read"
              class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-950 text-rose-300 border border-rose-800"
            >
              NEW
            </span>
          </div>

          <div class="text-[11px] font-mono text-slate-500">
            {{ new Date(msg.created_at).toLocaleString() }}
          </div>
        </div>

        <div class="py-3">
          <div class="text-xs font-bold text-slate-200 mb-1">Subject: {{ msg.subject }}</div>
          <p class="text-xs text-slate-300 whitespace-pre-wrap leading-relaxed">{{ msg.message }}</p>
        </div>

        <div class="pt-3 border-t border-slate-800 flex items-center justify-between text-xs">
          <a
            :href="`mailto:${msg.email}?subject=Re: ${encodeURIComponent(msg.subject)}`"
            class="text-sky-400 hover:text-sky-300 font-semibold flex items-center gap-1"
          >
            <span>Reply via Email</span>
            <span>↗</span>
          </a>

          <div class="flex items-center gap-2">
            <button
              v-if="!msg.is_read"
              @click="markRead(msg.id)"
              class="px-3 py-1 rounded-lg bg-sky-500/10 text-sky-400 hover:bg-sky-500/20 font-semibold"
            >
              Mark Read
            </button>
            <button
              @click="deleteMsg(msg.id)"
              class="px-3 py-1 rounded-lg bg-rose-500/10 text-rose-400 hover:bg-rose-500/20 font-semibold"
            >
              Delete
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Empty state -->
    <div v-else class="text-center py-16 glass-card rounded-2xl border border-slate-800 space-y-3">
      <div class="text-3xl">📭</div>
      <h3 class="text-base font-bold text-white">Inbox is clean</h3>
      <p class="text-xs text-slate-400">No contact messages received yet.</p>
    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import api from '../../services/api';

const messages = ref([]);

const loadMessages = async () => {
  try {
    const res = await api.get('/admin/messages');
    if (res.data && res.data.data) {
      messages.value = res.data.data.data || res.data.data;
    }
  } catch (err) {
    console.error(err);
  }
};

const markRead = async (id) => {
  try {
    await api.patch(`/admin/messages/${id}/read`);
    const found = messages.value.find(m => m.id === id);
    if (found) found.is_read = true;
  } catch (err) {
    console.error(err);
  }
};

const deleteMsg = async (id) => {
  if (!confirm('Delete this message?')) return;
  try {
    await api.delete(`/admin/messages/${id}`);
    messages.value = messages.value.filter(m => m.id !== id);
  } catch (err) {
    console.error(err);
  }
};

onMounted(() => {
  loadMessages();
});
</script>

