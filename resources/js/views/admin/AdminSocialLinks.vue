<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between flex-wrap gap-4">
      <div>
        <h1 class="text-2xl font-extrabold text-white">Social & Web Links</h1>
        <p class="text-xs text-slate-400">Configure GitHub, LinkedIn, email, and external profiles shown on the website.</p>
      </div>

      <button
        @click="openAddModal"
        class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-white bg-gradient-to-r from-sky-500 to-indigo-600 hover:from-sky-400 hover:to-indigo-500 shadow-md shadow-sky-500/25 flex items-center gap-2 cursor-pointer"
      >
        <span>+ Add Link</span>
      </button>
    </div>

    <div class="glass-card rounded-2xl border border-slate-800 overflow-hidden">
      <table class="w-full text-left text-xs text-slate-300">
        <thead class="bg-slate-900/80 text-slate-400 font-mono uppercase text-[11px] border-b border-slate-800">
          <tr>
            <th class="p-4">Platform</th>
            <th class="p-4">Label</th>
            <th class="p-4">URL</th>
            <th class="p-4">Status</th>
            <th class="p-4 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-800/60">
          <tr v-for="link in socialLinks" :key="link.id" class="hover:bg-slate-900/40">
            <td class="p-4 font-bold text-white text-sm">{{ link.platform }}</td>
            <td class="p-4 font-mono text-slate-300">{{ link.label }}</td>
            <td class="p-4 font-mono text-sky-400 max-w-xs truncate">{{ link.url }}</td>
            <td class="p-4">
              <span
                class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider font-mono"
                :class="link.is_active ? 'bg-emerald-950 text-emerald-300 border border-emerald-800' : 'bg-slate-800 text-slate-500'"
              >
                {{ link.is_active ? 'Active' : 'Inactive' }}
              </span>
            </td>
            <td class="p-4 text-right space-x-2">
              <button
                @click="openEditModal(link)"
                class="px-3 py-1.5 rounded-lg bg-sky-500/10 text-sky-400 hover:bg-sky-500/20 font-semibold"
              >
                Edit
              </button>
              <button
                @click="deleteLink(link.id)"
                class="px-3 py-1.5 rounded-lg bg-rose-500/10 text-rose-400 hover:bg-rose-500/20 font-semibold"
              >
                Delete
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Modal Form -->
    <div
      v-if="showModal"
      class="fixed inset-0 z-50 overflow-y-auto bg-black/80 backdrop-blur-md flex items-center justify-center p-4"
    >
      <div class="relative w-full max-w-md bg-[#0f172a] border border-slate-700 rounded-3xl p-6 sm:p-8 space-y-4">
        <div class="flex items-center justify-between border-b border-slate-800 pb-3">
          <h3 class="text-lg font-bold text-white">{{ isEditing ? 'Edit Link' : 'Add Social Link' }}</h3>
          <button @click="showModal = false" class="text-slate-400 hover:text-white">✕</button>
        </div>

        <form @submit.prevent="saveLink" class="space-y-4 text-xs">
          <div>
            <label class="block font-mono text-slate-300 mb-1">Platform Name</label>
            <input
              v-model="modalForm.platform"
              required
              type="text"
              placeholder="e.g. GitHub, LinkedIn, Twitter"
              class="w-full px-3.5 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-sm focus:outline-none focus:border-sky-500"
            />
          </div>

          <div>
            <label class="block font-mono text-slate-300 mb-1">Display Label</label>
            <input
              v-model="modalForm.label"
              required
              type="text"
              placeholder="e.g. github.com/19Malavika"
              class="w-full px-3.5 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-xs focus:outline-none focus:border-sky-500"
            />
          </div>

          <div>
            <label class="block font-mono text-slate-300 mb-1">Destination URL</label>
            <input
              v-model="modalForm.url"
              required
              type="text"
              placeholder="https://..."
              class="w-full px-3.5 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-xs focus:outline-none focus:border-sky-500"
            />
          </div>

          <div class="flex items-center gap-2 pt-2">
            <input
              v-model="modalForm.is_active"
              type="checkbox"
              id="activeLinkCheck"
              class="rounded bg-slate-900 border-slate-700 text-sky-500"
            />
            <label for="activeLinkCheck" class="text-xs text-slate-300 font-mono">
              Display publicly on website
            </label>
          </div>

          <div class="pt-4 border-t border-slate-800 flex items-center justify-end gap-3">
            <button
              type="button"
              @click="showModal = false"
              class="px-4 py-2 rounded-xl bg-slate-800 text-slate-300 hover:text-white"
            >
              Cancel
            </button>
            <button
              type="submit"
              class="px-5 py-2 rounded-xl font-semibold bg-sky-500 text-white hover:bg-sky-400"
            >
              Save Link
            </button>
          </div>
        </form>
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
import api from '../../services/api';

const socialLinks = ref([]);
const showModal = ref(false);
const isEditing = ref(false);
const currentId = ref(null);

const modalForm = reactive({
  platform: '',
  label: '',
  url: '',
  is_active: true,
});

const loadLinks = async () => {
  try {
    const res = await api.get('/admin/social-links');
    if (res.data && res.data.data) {
      socialLinks.value = res.data.data;
    }
  } catch (err) {
    console.error(err);
  }
};

const openAddModal = () => {
  isEditing.value = false;
  currentId.value = null;
  modalForm.platform = '';
  modalForm.label = '';
  modalForm.url = '';
  modalForm.is_active = true;
  showModal.value = true;
};

const openEditModal = (link) => {
  isEditing.value = true;
  currentId.value = link.id;
  modalForm.platform = link.platform;
  modalForm.label = link.label;
  modalForm.url = link.url;
  modalForm.is_active = !!link.is_active;
  showModal.value = true;
};

const saveLink = async () => {
  try {
    if (isEditing.value) {
      await api.put(`/admin/social-links/${currentId.value}`, modalForm);
    } else {
      await api.post('/admin/social-links', modalForm);
    }
    showModal.value = false;
    loadLinks();
  } catch (err) {
    alert('Failed to save social link.');
  }
};

const deleteLink = async (id) => {
  if (!confirm('Remove this social link?')) return;
  try {
    await api.delete(`/admin/social-links/${id}`);
    loadLinks();
  } catch (err) {
    alert('Failed to delete link.');
  }
};

onMounted(() => {
  loadLinks();
});
</script>
