<template>
  <div class="space-y-6">
    <!-- Toast Notification -->
    <div
      v-if="toast.message"
      :class="[
        'px-4 py-3 rounded-xl text-xs font-mono border transition-all duration-300',
        toast.type === 'success' ? 'bg-emerald-950/70 border-emerald-800 text-emerald-300' : 'bg-rose-950/70 border-rose-800 text-rose-300'
      ]"
    >
      {{ toast.message }}
    </div>

    <div class="flex items-center justify-between flex-wrap gap-4">
      <div>
        <h1 class="text-2xl font-extrabold text-white">Education & Degrees</h1>
        <p class="text-xs text-slate-400">Manage academic degrees, universities, CGPA scores, and coursework.</p>
      </div>

      <button
        @click="openAddModal"
        class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-white bg-gradient-to-r from-sky-500 to-indigo-600 hover:from-sky-400 hover:to-indigo-500 shadow-md shadow-sky-500/25 flex items-center gap-2 cursor-pointer"
      >
        <span>+ Add Education</span>
      </button>
    </div>

    <!-- List -->
    <div class="space-y-4">
      <div
        v-for="edu in educationList"
        :key="edu.id"
        class="glass-card rounded-2xl p-6 border border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-4"
      >
        <div class="space-y-1">
          <div class="flex items-center gap-3">
            <span class="font-bold text-white text-base">{{ edu.degree }}</span>
            <span class="text-xs font-mono text-emerald-400 px-2.5 py-0.5 rounded bg-emerald-950/80 border border-emerald-800">
              {{ edu.cgpa }}
            </span>
          </div>
          <div class="text-sm text-slate-300 font-medium">{{ edu.institution }}</div>
          <div class="text-xs text-sky-400 font-mono">{{ edu.duration }} • {{ edu.location }}</div>
          <p v-if="edu.description" class="text-xs text-slate-400 mt-2 max-w-2xl">{{ edu.description }}</p>
        </div>

        <div class="flex items-center gap-2 flex-shrink-0">
          <button
            @click="openEditModal(edu)"
            class="px-3.5 py-2 rounded-xl bg-sky-500/10 text-sky-400 hover:bg-sky-500/20 font-semibold text-xs"
          >
            Edit
          </button>
          <button
            @click="deleteEducation(edu.id)"
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
          <h3 class="text-lg font-bold text-white">{{ isEditing ? 'Edit Education' : 'Add Education' }}</h3>
          <button @click="showModal = false" class="text-slate-400 hover:text-white">✕</button>
        </div>

        <form @submit.prevent="saveEducation" class="space-y-4 text-xs">
          <div>
            <label class="block font-mono text-slate-300 mb-1">Degree Title</label>
            <input
              v-model="modalForm.degree"
              required
              type="text"
              class="w-full px-3.5 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-sm focus:outline-none focus:border-sky-500"
            />
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block font-mono text-slate-300 mb-1">College / Institution</label>
              <input
                v-model="modalForm.institution"
                required
                type="text"
                class="w-full px-3.5 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-xs focus:outline-none focus:border-sky-500"
              />
            </div>

            <div>
              <label class="block font-mono text-slate-300 mb-1">University / Board</label>
              <input
                v-model="modalForm.university"
                type="text"
                class="w-full px-3.5 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-xs focus:outline-none focus:border-sky-500"
              />
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
              <label class="block font-mono text-slate-300 mb-1">Duration (e.g. 2020 - 2024)</label>
              <input
                v-model="modalForm.duration"
                required
                type="text"
                class="w-full px-3.5 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-xs focus:outline-none focus:border-sky-500"
              />
            </div>

            <div>
              <label class="block font-mono text-slate-300 mb-1">CGPA / Score</label>
              <input
                v-model="modalForm.cgpa"
                type="text"
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
            <label class="block font-mono text-slate-300 mb-1">Description / Coursework</label>
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
              Save Education
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

const educationList = ref([]);
const showModal = ref(false);
const isEditing = ref(false);
const currentId = ref(null);
const toast = reactive({ type: '', message: '' });

const showToast = (type, message) => {
  toast.type = type;
  toast.message = message;
  setTimeout(() => toast.message = '', 4000);
};

const modalForm = reactive({
  degree: '',
  institution: '',
  university: '',
  duration: '',
  cgpa: '',
  location: '',
  description: '',
});

const loadEducation = async () => {
  try {
    const res = await api.get('/admin/education');
    if (res.data && res.data.data) {
      educationList.value = res.data.data;
    }
  } catch (err) {
    console.error(err);
  }
};

const openAddModal = () => {
  isEditing.value = false;
  currentId.value = null;
  modalForm.degree = '';
  modalForm.institution = '';
  modalForm.university = '';
  modalForm.duration = '';
  modalForm.cgpa = '';
  modalForm.location = '';
  modalForm.description = '';
  showModal.value = true;
};

const openEditModal = (edu) => {
  isEditing.value = true;
  currentId.value = edu.id;
  modalForm.degree = edu.degree;
  modalForm.institution = edu.institution;
  modalForm.university = edu.university;
  modalForm.duration = edu.duration;
  modalForm.cgpa = edu.cgpa;
  modalForm.location = edu.location;
  modalForm.description = edu.description;
  showModal.value = true;
};

const saveEducation = async () => {
  try {
    if (isEditing.value) {
      await api.put(`/admin/education/${currentId.value}`, modalForm);
      showToast('success', 'Education updated successfully.');
    } else {
      await api.post('/admin/education', modalForm);
      showToast('success', 'Education entry created successfully.');
    }
    showModal.value = false;
    loadEducation();
  } catch (err) {
    showToast('error', 'Failed to save education entry. Please check required fields.');
  }
};

const deleteEducation = async (id) => {
  if (!confirm('Delete this education entry?')) return;
  try {
    await api.delete(`/admin/education/${id}`);
    showToast('success', 'Education entry deleted.');
    loadEducation();
  } catch (err) {
    showToast('error', 'Failed to delete education.');
  }
};

onMounted(() => {
  loadEducation();
});
</script>

