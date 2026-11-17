<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between flex-wrap gap-4">
      <div>
        <h1 class="text-2xl font-extrabold text-white">Experience & Career Journey</h1>
        <p class="text-xs text-slate-400">Manage professional positions, practical work, and timeline highlights.</p>
      </div>

      <button
        @click="openAddModal"
        class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-white bg-gradient-to-r from-sky-500 to-indigo-600 hover:from-sky-400 hover:to-indigo-500 shadow-md shadow-sky-500/25 flex items-center gap-2 cursor-pointer"
      >
        <span>+ Add Experience</span>
      </button>
    </div>

    <!-- Toast -->
    <div
      v-if="toast.message"
      class="p-4 rounded-xl text-xs flex items-center gap-2"
      :class="toast.type === 'success' ? 'bg-emerald-950 text-emerald-200 border border-emerald-800' : 'bg-rose-950 text-rose-200 border border-rose-800'"
    >
      <span>{{ toast.type === 'success' ? '✅' : '⚠️' }}</span>
      <span>{{ toast.message }}</span>
    </div>

    <!-- List -->
    <div class="space-y-4">
      <div
        v-for="e in experiences"
        :key="e.id"
        class="glass-card rounded-2xl p-6 border border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-4"
      >
        <div class="space-y-1 max-w-2xl">
          <div class="flex items-center gap-2">
            <span class="font-bold text-white text-base">{{ e.position }}</span>
            <span class="text-slate-500">•</span>
            <span class="text-sky-300 text-sm font-medium">{{ e.company }}</span>
            <span
              v-if="e.is_current"
              class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-950 text-emerald-300 border border-emerald-800"
            >
              Current
            </span>
          </div>
          <div class="text-xs font-mono text-slate-400">
            {{ e.start_date }} — {{ e.end_date || 'Present' }} • {{ e.location }}
          </div>
          <p class="text-xs text-slate-300 mt-2 leading-relaxed line-clamp-2">
            {{ e.description }}
          </p>
        </div>

        <div class="flex items-center gap-2 flex-shrink-0">
          <button
            @click="openEditModal(e)"
            class="px-3.5 py-2 rounded-xl bg-sky-500/10 text-sky-400 hover:bg-sky-500/20 font-semibold text-xs"
          >
            Edit
          </button>
          <button
            @click="deleteExperience(e.id)"
            class="px-3.5 py-2 rounded-xl bg-rose-500/10 text-rose-400 hover:bg-rose-500/20 font-semibold text-xs"
          >
            Delete
          </button>
        </div>
      </div>
    </div>

    <!-- Modal Form -->
    <div
      v-if="showModal"
      class="fixed inset-0 z-50 overflow-y-auto bg-black/80 backdrop-blur-md flex items-center justify-center p-4"
    >
      <div class="relative w-full max-w-xl bg-[#0f172a] border border-slate-700 rounded-3xl p-6 sm:p-8 space-y-4 my-8">
        <div class="flex items-center justify-between border-b border-slate-800 pb-3">
          <h3 class="text-lg font-bold text-white">{{ isEditing ? 'Edit Experience' : 'Add Experience Entry' }}</h3>
          <button @click="showModal = false" class="text-slate-400 hover:text-white">✕</button>
        </div>

        <form @submit.prevent="saveExperience" class="space-y-4 text-xs">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block font-mono text-slate-300 mb-1">Position / Role</label>
              <input
                v-model="modalForm.position"
                required
                type="text"
                class="w-full px-3.5 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-sm focus:outline-none focus:border-sky-500"
              />
            </div>

            <div>
              <label class="block font-mono text-slate-300 mb-1">Company / Organization</label>
              <input
                v-model="modalForm.company"
                required
                type="text"
                class="w-full px-3.5 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-sm focus:outline-none focus:border-sky-500"
              />
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
              <label class="block font-mono text-slate-300 mb-1">Start Date (e.g. 2023)</label>
              <input
                v-model="modalForm.start_date"
                required
                type="text"
                class="w-full px-3.5 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-xs focus:outline-none focus:border-sky-500"
              />
            </div>

            <div>
              <label class="block font-mono text-slate-300 mb-1">End Date</label>
              <input
                v-model="modalForm.end_date"
                type="text"
                placeholder="Present"
                class="w-full px-3.5 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-xs focus:outline-none focus:border-sky-500"
              />
            </div>

            <div>
              <label class="block font-mono text-slate-300 mb-1">Location</label>
              <input
                v-model="modalForm.location"
                type="text"
                class="w-full px-3.5 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-xs focus:outline-none focus:border-sky-500"
              />
            </div>
          </div>

          <div>
            <label class="block font-mono text-slate-300 mb-1">Role Description</label>
            <textarea
              v-model="modalForm.description"
              required
              rows="3"
              class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-xs focus:outline-none focus:border-sky-500"
            ></textarea>
          </div>

          <div>
            <label class="block font-mono text-slate-300 mb-1">Technologies Used (Comma separated)</label>
            <input
              v-model="techInput"
              type="text"
              placeholder="Flutter, Laravel, PHP, MySQL, Riverpod"
              class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-xs focus:outline-none focus:border-sky-500"
            />
          </div>

          <div class="flex items-center gap-2 pt-1">
            <input
              v-model="modalForm.is_current"
              type="checkbox"
              id="currCheck"
              class="rounded bg-slate-900 border-slate-700 text-sky-500"
            />
            <label for="currCheck" class="text-xs text-slate-300 font-mono">
              Currently working in this position
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
              Save Experience
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

const experiences = ref([]);
const showModal = ref(false);
const isEditing = ref(false);
const currentId = ref(null);
const techInput = ref('');

const modalForm = reactive({
  position: '',
  company: '',
  location: '',
  start_date: '',
  end_date: '',
  is_current: false,
  description: '',
});

const toast = reactive({ type: '', message: '' });

const showToast = (type, message) => {
  toast.type = type;
  toast.message = message;
  setTimeout(() => toast.message = '', 4000);
};

const loadExperiences = async () => {
  try {
    const res = await api.get('/admin/experience');
    if (res.data && res.data.data) {
      experiences.value = res.data.data;
    }
  } catch (err) {
    console.error(err);
  }
};

const openAddModal = () => {
  isEditing.value = false;
  currentId.value = null;
  modalForm.position = '';
  modalForm.company = '';
  modalForm.location = '';
  modalForm.start_date = '';
  modalForm.end_date = '';
  modalForm.is_current = false;
  modalForm.description = '';
  techInput.value = '';
  showModal.value = true;
};

const openEditModal = (e) => {
  isEditing.value = true;
  currentId.value = e.id;
  modalForm.position = e.position;
  modalForm.company = e.company;
  modalForm.location = e.location;
  modalForm.start_date = e.start_date;
  modalForm.end_date = e.end_date;
  modalForm.is_current = !!e.is_current;
  modalForm.description = e.description;
  techInput.value = (e.technologies || []).join(', ');
  showModal.value = true;
};

const saveExperience = async () => {
  const payload = {
    ...modalForm,
    technologies: techInput.value.split(',').map(s => s.trim()).filter(Boolean),
  };

  try {
    if (isEditing.value) {
      await api.put(`/admin/experience/${currentId.value}`, payload);
      showToast('success', 'Experience updated.');
    } else {
      await api.post('/admin/experience', payload);
      showToast('success', 'Experience added.');
    }
    showModal.value = false;
    loadExperiences();
  } catch (err) {
    showToast('error', 'Failed to save experience.');
  }
};

const deleteExperience = async (id) => {
  if (!confirm('Are you sure you want to delete this experience entry?')) return;
  try {
    await api.delete(`/admin/experience/${id}`);
    showToast('success', 'Experience entry removed.');
    loadExperiences();
  } catch (err) {
    showToast('error', 'Failed to delete experience.');
  }
};

onMounted(() => {
  loadExperiences();
});
</script>

