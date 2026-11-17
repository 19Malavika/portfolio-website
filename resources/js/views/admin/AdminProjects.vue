<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between flex-wrap gap-4">
      <div>
        <h1 class="text-2xl font-extrabold text-white">Manage Projects</h1>
        <p class="text-xs text-slate-400">Add, edit, remove, and upload screenshots for your portfolio projects.</p>
      </div>

      <button
        @click="openCreateModal"
        class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-white bg-gradient-to-r from-sky-500 to-indigo-600 hover:from-sky-400 hover:to-indigo-500 shadow-md shadow-sky-500/25 flex items-center gap-2 cursor-pointer"
      >
        <span>+ Add New Project</span>
      </button>
    </div>

    <!-- Toast Notification -->
    <div
      v-if="toast.message"
      class="p-4 rounded-xl text-xs flex items-center gap-2"
      :class="toast.type === 'success' ? 'bg-emerald-950 text-emerald-200 border border-emerald-800' : 'bg-rose-950 text-rose-200 border border-rose-800'"
    >
      <span>{{ toast.type === 'success' ? '✅' : '⚠️' }}</span>
      <span>{{ toast.message }}</span>
    </div>

    <!-- Projects Table / List -->
    <div class="glass-card rounded-2xl border border-slate-800 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-slate-300">
          <thead class="bg-slate-900/80 text-slate-400 font-mono uppercase text-[11px] border-b border-slate-800">
            <tr>
              <th class="p-4">Project</th>
              <th class="p-4">Category</th>
              <th class="p-4">Technologies</th>
              <th class="p-4">Featured</th>
              <th class="p-4 text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-800/60">
            <tr
              v-for="p in projects"
              :key="p.id"
              class="hover:bg-slate-900/40 transition-colors"
            >
              <td class="p-4">
                <div class="flex items-center gap-3">
                  <div class="w-12 h-8 rounded-lg overflow-hidden bg-slate-900 border border-slate-800 flex-shrink-0">
                    <img :src="p.image_url || '/images/projects/smart-resource-booking.svg'" class="w-full h-full object-cover" />
                  </div>
                  <div>
                    <div class="font-bold text-white text-sm">{{ p.title }}</div>
                    <div class="text-[11px] text-slate-400 font-mono truncate max-w-xs">{{ p.slug }}</div>
                  </div>
                </div>
              </td>
              <td class="p-4">
                <span class="px-2.5 py-1 rounded-md text-[11px] font-mono bg-slate-800 text-sky-300 border border-slate-700">
                  {{ p.category }}
                </span>
              </td>
              <td class="p-4">
                <div class="flex flex-wrap gap-1 max-w-xs">
                  <span
                    v-for="(tech, tIdx) in (p.technologies || []).slice(0, 3)"
                    :key="tIdx"
                    class="px-2 py-0.5 rounded text-[10px] font-mono bg-slate-800/80 text-slate-300"
                  >
                    {{ tech }}
                  </span>
                  <span v-if="(p.technologies || []).length > 3" class="text-[10px] text-slate-500 font-mono">
                    +{{ p.technologies.length - 3 }}
                  </span>
                </div>
              </td>
              <td class="p-4">
                <span
                  class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider font-mono"
                  :class="p.is_featured ? 'bg-amber-950 text-amber-300 border border-amber-800' : 'text-slate-500'"
                >
                  {{ p.is_featured ? '★ Yes' : 'No' }}
                </span>
              </td>
              <td class="p-4 text-right space-x-2">
                <button
                  @click="openEditModal(p)"
                  class="px-3 py-1.5 rounded-lg bg-sky-500/10 text-sky-400 hover:bg-sky-500/20 font-semibold"
                >
                  Edit
                </button>
                <button
                  @click="deleteProject(p.id)"
                  class="px-3 py-1.5 rounded-lg bg-rose-500/10 text-rose-400 hover:bg-rose-500/20 font-semibold"
                >
                  Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Create / Edit Modal -->
    <div
      v-if="showModal"
      class="fixed inset-0 z-50 overflow-y-auto bg-black/80 backdrop-blur-md flex items-center justify-center p-4"
    >
      <div class="relative w-full max-w-2xl bg-[#0f172a] border border-slate-700 rounded-3xl p-6 sm:p-8 space-y-5 my-8">
        <div class="flex items-center justify-between border-b border-slate-800 pb-4">
          <h3 class="text-xl font-bold text-white">
            {{ isEditing ? 'Edit Project' : 'Create New Project' }}
          </h3>
          <button @click="showModal = false" class="text-slate-400 hover:text-white">✕</button>
        </div>

        <form @submit.prevent="saveProject" class="space-y-4 text-xs">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block font-mono text-slate-300 mb-1">Project Title</label>
              <input
                v-model="modalForm.title"
                required
                type="text"
                class="w-full px-3.5 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-sm focus:outline-none focus:border-sky-500"
              />
            </div>

            <div>
              <label class="block font-mono text-slate-300 mb-1">Category</label>
              <select
                v-model="modalForm.category"
                required
                class="w-full px-3.5 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-sm focus:outline-none focus:border-sky-500"
              >
                <option value="Full Stack">Full Stack</option>
                <option value="Mobile (Flutter)">Mobile (Flutter)</option>
                <option value="Frontend">Frontend</option>
              </select>
            </div>
          </div>

          <div>
            <label class="block font-mono text-slate-300 mb-1">Short Description</label>
            <textarea
              v-model="modalForm.short_description"
              required
              rows="2"
              class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-xs focus:outline-none focus:border-sky-500 resize-none"
            ></textarea>
          </div>

          <div>
            <label class="block font-mono text-slate-300 mb-1">Problem Statement</label>
            <textarea
              v-model="modalForm.problem_statement"
              rows="2"
              class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-xs focus:outline-none focus:border-sky-500 resize-none"
            ></textarea>
          </div>

          <div>
            <label class="block font-mono text-slate-300 mb-1">Full Technical Description</label>
            <textarea
              v-model="modalForm.full_description"
              rows="3"
              class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-xs focus:outline-none focus:border-sky-500"
            ></textarea>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block font-mono text-slate-300 mb-1">GitHub Repository URL</label>
              <input
                v-model="modalForm.github_url"
                type="text"
                class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-xs focus:outline-none focus:border-sky-500"
              />
            </div>

            <div>
              <label class="block font-mono text-slate-300 mb-1">Live Demo URL</label>
              <input
                v-model="modalForm.live_url"
                type="text"
                class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-xs focus:outline-none focus:border-sky-500"
              />
            </div>
          </div>

          <div>
            <label class="block font-mono text-slate-300 mb-1">Technologies (Comma separated)</label>
            <input
              v-model="techInput"
              type="text"
              placeholder="e.g. Flutter, Dart, Riverpod, Laravel, MySQL"
              class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-xs focus:outline-none focus:border-sky-500"
            />
          </div>

          <div>
            <label class="block font-mono text-slate-300 mb-1">Features (One per line)</label>
            <textarea
              v-model="featuresInput"
              rows="3"
              placeholder="Feature 1&#10;Feature 2&#10;Feature 3"
              class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-xs focus:outline-none focus:border-sky-500"
            ></textarea>
          </div>

          <div class="flex items-center gap-2 pt-2">
            <input
              v-model="modalForm.is_featured"
              type="checkbox"
              id="featuredCheck"
              class="rounded bg-slate-900 border-slate-700 text-sky-500 focus:ring-0"
            />
            <label for="featuredCheck" class="text-xs text-slate-300 font-mono">
              Feature this project prominently on homepage
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
              Save Project
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

const projects = ref([]);
const showModal = ref(false);
const isEditing = ref(false);
const currentId = ref(null);
const techInput = ref('');
const featuresInput = ref('');

const modalForm = reactive({
  title: '',
  category: 'Full Stack',
  short_description: '',
  full_description: '',
  problem_statement: '',
  github_url: '',
  live_url: '',
  is_featured: false,
});

const toast = reactive({ type: '', message: '' });

const showToast = (type, message) => {
  toast.type = type;
  toast.message = message;
  setTimeout(() => toast.message = '', 4000);
};

const loadProjects = async () => {
  try {
    const res = await api.get('/admin/projects');
    if (res.data && res.data.data) {
      projects.value = res.data.data;
    }
  } catch (err) {
    console.error(err);
  }
};

const openCreateModal = () => {
  isEditing.value = false;
  currentId.value = null;
  modalForm.title = '';
  modalForm.category = 'Full Stack';
  modalForm.short_description = '';
  modalForm.full_description = '';
  modalForm.problem_statement = '';
  modalForm.github_url = '';
  modalForm.live_url = '';
  modalForm.is_featured = false;
  techInput.value = '';
  featuresInput.value = '';
  showModal.value = true;
};

const openEditModal = (p) => {
  isEditing.value = true;
  currentId.value = p.id;
  modalForm.title = p.title;
  modalForm.category = p.category;
  modalForm.short_description = p.short_description;
  modalForm.full_description = p.full_description;
  modalForm.problem_statement = p.problem_statement;
  modalForm.github_url = p.github_url;
  modalForm.live_url = p.live_url;
  modalForm.is_featured = !!p.is_featured;
  techInput.value = (p.technologies || []).join(', ');
  featuresInput.value = (p.features || []).join('\n');
  showModal.value = true;
};

const saveProject = async () => {
  const payload = {
    ...modalForm,
    technologies: techInput.value.split(',').map(s => s.trim()).filter(Boolean),
    features: featuresInput.value.split('\n').map(s => s.trim()).filter(Boolean),
  };

  try {
    if (isEditing.value) {
      await api.put(`/admin/projects/${currentId.value}`, payload);
      showToast('success', 'Project updated successfully.');
    } else {
      await api.post('/admin/projects', payload);
      showToast('success', 'New project added successfully.');
    }
    showModal.value = false;
    loadProjects();
  } catch (err) {
    showToast('error', 'Failed to save project. Please check required fields.');
  }
};

const deleteProject = async (id) => {
  if (!confirm('Are you sure you want to remove this project?')) return;
  try {
    await api.delete(`/admin/projects/${id}`);
    showToast('success', 'Project deleted.');
    loadProjects();
  } catch (err) {
    showToast('error', 'Failed to delete project.');
  }
};

onMounted(() => {
  loadProjects();
});
</script>
