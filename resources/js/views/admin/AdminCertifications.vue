<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between flex-wrap gap-4">
      <div>
        <h1 class="text-2xl font-extrabold text-white">Certifications & Coursework</h1>
        <p class="text-xs text-slate-400">Add and manage technical certifications and verified credentials.</p>
      </div>

      <button
        @click="openAddModal"
        class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-white bg-gradient-to-r from-sky-500 to-indigo-600 hover:from-sky-400 hover:to-indigo-500 shadow-md shadow-sky-500/25 flex items-center gap-2 cursor-pointer"
      >
        <span>+ Add Certification</span>
      </button>
    </div>

    <!-- Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div
        v-for="c in certifications"
        :key="c.id"
        class="glass-card rounded-2xl p-6 border border-slate-800 flex flex-col justify-between space-y-4"
      >
        <div class="space-y-2">
          <div class="flex items-center justify-between">
            <span class="text-xs font-mono text-sky-400">{{ c.issue_date || 'Certified' }}</span>
            <span v-if="c.credential_id" class="text-[10px] font-mono text-slate-500">ID: {{ c.credential_id }}</span>
          </div>
          <h3 class="text-base font-bold text-white">{{ c.title }}</h3>
          <div class="text-xs font-medium text-slate-300">{{ c.issuer }}</div>
          <p v-if="c.description" class="text-xs text-slate-400 leading-relaxed">{{ c.description }}</p>
        </div>

        <div class="flex items-center justify-between pt-3 border-t border-slate-800">
          <a
            v-if="c.credential_url"
            :href="c.credential_url"
            target="_blank"
            class="text-xs text-sky-400 hover:underline font-mono"
          >
            Verify Link ↗
          </a>
          <div class="space-x-2 ml-auto">
            <button
              @click="openEditModal(c)"
              class="px-3 py-1 rounded-lg bg-sky-500/10 text-sky-400 hover:bg-sky-500/20 text-xs font-semibold"
            >
              Edit
            </button>
            <button
              @click="deleteCert(c.id)"
              class="px-3 py-1 rounded-lg bg-rose-500/10 text-rose-400 hover:bg-rose-500/20 text-xs font-semibold"
            >
              Delete
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Form -->
    <div
      v-if="showModal"
      class="fixed inset-0 z-50 overflow-y-auto bg-black/80 backdrop-blur-md flex items-center justify-center p-4"
    >
      <div class="relative w-full max-w-md bg-[#0f172a] border border-slate-700 rounded-3xl p-6 sm:p-8 space-y-4">
        <div class="flex items-center justify-between border-b border-slate-800 pb-3">
          <h3 class="text-lg font-bold text-white">{{ isEditing ? 'Edit Certification' : 'Add Certification' }}</h3>
          <button @click="showModal = false" class="text-slate-400 hover:text-white">✕</button>
        </div>

        <form @submit.prevent="saveCert" class="space-y-4 text-xs">
          <div>
            <label class="block font-mono text-slate-300 mb-1">Certification Title</label>
            <input
              v-model="modalForm.title"
              required
              type="text"
              class="w-full px-3.5 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-sm focus:outline-none focus:border-sky-500"
            />
          </div>

          <div>
            <label class="block font-mono text-slate-300 mb-1">Issuer / Authority</label>
            <input
              v-model="modalForm.issuer"
              required
              type="text"
              class="w-full px-3.5 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-xs focus:outline-none focus:border-sky-500"
            />
          </div>

          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="block font-mono text-slate-300 mb-1">Issue Date</label>
              <input
                v-model="modalForm.issue_date"
                type="text"
                class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-xs focus:outline-none focus:border-sky-500"
              />
            </div>

            <div>
              <label class="block font-mono text-slate-300 mb-1">Credential ID</label>
              <input
                v-model="modalForm.credential_id"
                type="text"
                class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-xs focus:outline-none focus:border-sky-500"
              />
            </div>
          </div>

          <div>
            <label class="block font-mono text-slate-300 mb-1">Credential Verification URL</label>
            <input
              v-model="modalForm.credential_url"
              type="text"
              class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-xs focus:outline-none focus:border-sky-500"
            />
          </div>

          <div>
            <label class="block font-mono text-slate-300 mb-1">Description</label>
            <textarea
              v-model="modalForm.description"
              rows="3"
              class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-xs focus:outline-none focus:border-sky-500"
            ></textarea>
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
              Save Certification
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

const certifications = ref([]);
const showModal = ref(false);
const isEditing = ref(false);
const currentId = ref(null);

const modalForm = reactive({
  title: '',
  issuer: '',
  issue_date: '',
  credential_id: '',
  credential_url: '',
  description: '',
});

const loadCerts = async () => {
  try {
    const res = await api.get('/admin/certifications');
    if (res.data && res.data.data) {
      certifications.value = res.data.data;
    }
  } catch (err) {
    console.error(err);
  }
};

const openAddModal = () => {
  isEditing.value = false;
  currentId.value = null;
  modalForm.title = '';
  modalForm.issuer = '';
  modalForm.issue_date = '';
  modalForm.credential_id = '';
  modalForm.credential_url = '';
  modalForm.description = '';
  showModal.value = true;
};

const openEditModal = (c) => {
  isEditing.value = true;
  currentId.value = c.id;
  modalForm.title = c.title;
  modalForm.issuer = c.issuer;
  modalForm.issue_date = c.issue_date;
  modalForm.credential_id = c.credential_id;
  modalForm.credential_url = c.credential_url;
  modalForm.description = c.description;
  showModal.value = true;
};

const saveCert = async () => {
  try {
    if (isEditing.value) {
      await api.put(`/admin/certifications/${currentId.value}`, modalForm);
    } else {
      await api.post('/admin/certifications', modalForm);
    }
    showModal.value = false;
    loadCerts();
  } catch (err) {
    alert('Failed to save certification.');
  }
};

const deleteCert = async (id) => {
  if (!confirm('Delete this certification?')) return;
  try {
    await api.delete(`/admin/certifications/${id}`);
    loadCerts();
  } catch (err) {
    alert('Failed to delete certification.');
  }
};

onMounted(() => {
  loadCerts();
});
</script>
