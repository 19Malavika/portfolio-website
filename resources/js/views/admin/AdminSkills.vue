<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between flex-wrap gap-4">
      <div>
        <h1 class="text-2xl font-extrabold text-white">Manage Technical Skills</h1>
        <p class="text-xs text-slate-400">Configure skill levels, categories, and featured badges.</p>
      </div>

      <button
        @click="openAddModal"
        class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-white bg-gradient-to-r from-sky-500 to-indigo-600 hover:from-sky-400 hover:to-indigo-500 shadow-md shadow-sky-500/25 flex items-center gap-2 cursor-pointer"
      >
        <span>+ Add Skill</span>
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

    <!-- Skills List Table -->
    <div class="glass-card rounded-2xl border border-slate-800 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-slate-300">
          <thead class="bg-slate-900/80 text-slate-400 font-mono uppercase text-[11px] border-b border-slate-800">
            <tr>
              <th class="p-4">Skill Name</th>
              <th class="p-4">Category</th>
              <th class="p-4">Proficiency</th>
              <th class="p-4">Level Label</th>
              <th class="p-4 text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-800/60">
            <tr
              v-for="s in skills"
              :key="s.id"
              class="hover:bg-slate-900/40 transition-colors"
            >
              <td class="p-4 font-bold text-white text-sm">
                {{ s.name }}
              </td>
              <td class="p-4">
                <span class="px-2.5 py-1 rounded-md text-[11px] font-mono bg-slate-800 text-sky-300 border border-slate-700">
                  {{ s.category }}
                </span>
              </td>
              <td class="p-4">
                <div class="flex items-center gap-3">
                  <div class="w-24 h-2 bg-slate-800 rounded-full overflow-hidden">
                    <div class="h-full bg-sky-400 rounded-full" :style="{ width: `${s.proficiency}%` }"></div>
                  </div>
                  <span class="font-mono text-slate-200">{{ s.proficiency }}%</span>
                </div>
              </td>
              <td class="p-4 font-mono text-slate-400">
                {{ s.level_label || 'Proficient' }}
              </td>
              <td class="p-4 text-right space-x-2">
                <button
                  @click="openEditModal(s)"
                  class="px-3 py-1.5 rounded-lg bg-sky-500/10 text-sky-400 hover:bg-sky-500/20 font-semibold"
                >
                  Edit
                </button>
                <button
                  @click="deleteSkill(s.id)"
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

    <!-- Modal Form -->
    <div
      v-if="showModal"
      class="fixed inset-0 z-50 overflow-y-auto bg-black/80 backdrop-blur-md flex items-center justify-center p-4"
    >
      <div class="relative w-full max-w-md bg-[#0f172a] border border-slate-700 rounded-3xl p-6 sm:p-8 space-y-4">
        <div class="flex items-center justify-between border-b border-slate-800 pb-3">
          <h3 class="text-lg font-bold text-white">{{ isEditing ? 'Edit Skill' : 'Add New Skill' }}</h3>
          <button @click="showModal = false" class="text-slate-400 hover:text-white">✕</button>
        </div>

        <form @submit.prevent="saveSkill" class="space-y-4 text-xs">
          <div>
            <label class="block font-mono text-slate-300 mb-1">Skill Name</label>
            <input
              v-model="modalForm.name"
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
              <option value="Programming">Programming</option>
              <option value="Mobile">Mobile (Flutter)</option>
              <option value="Backend">Backend (Laravel/PHP)</option>
              <option value="Frontend">Frontend (Vue/React)</option>
              <option value="Database">Database</option>
              <option value="Tools">Tools & Architecture</option>
            </select>
          </div>

          <div>
            <div class="flex justify-between font-mono text-slate-300 mb-1">
              <span>Proficiency Score</span>
              <span class="text-sky-400 font-bold">{{ modalForm.proficiency }}%</span>
            </div>
            <input
              v-model="modalForm.proficiency"
              type="range"
              min="10"
              max="100"
              class="w-full accent-sky-400 cursor-pointer"
            />
          </div>

          <div>
            <label class="block font-mono text-slate-300 mb-1">Level Label</label>
            <select
              v-model="modalForm.level_label"
              class="w-full px-3.5 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-sm focus:outline-none focus:border-sky-500"
            >
              <option value="Advanced">Advanced (90%+)</option>
              <option value="Proficient">Proficient (80-89%)</option>
              <option value="Intermediate">Intermediate (70-79%)</option>
              <option value="Familiar">Familiar (Under 70%)</option>
            </select>
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
              Save Skill
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

const skills = ref([]);
const showModal = ref(false);
const isEditing = ref(false);
const currentId = ref(null);

const modalForm = reactive({
  name: '',
  category: 'Programming',
  proficiency: 85,
  level_label: 'Proficient',
});

const toast = reactive({ type: '', message: '' });

const showToast = (type, message) => {
  toast.type = type;
  toast.message = message;
  setTimeout(() => toast.message = '', 4000);
};

const loadSkills = async () => {
  try {
    const res = await api.get('/admin/skills');
    if (res.data && res.data.data) {
      skills.value = res.data.data;
    }
  } catch (err) {
    console.error(err);
  }
};

const openAddModal = () => {
  isEditing.value = false;
  currentId.value = null;
  modalForm.name = '';
  modalForm.category = 'Programming';
  modalForm.proficiency = 85;
  modalForm.level_label = 'Proficient';
  showModal.value = true;
};

const openEditModal = (s) => {
  isEditing.value = true;
  currentId.value = s.id;
  modalForm.name = s.name;
  modalForm.category = s.category;
  modalForm.proficiency = s.proficiency;
  modalForm.level_label = s.level_label || 'Proficient';
  showModal.value = true;
};

const saveSkill = async () => {
  try {
    if (isEditing.value) {
      await api.put(`/admin/skills/${currentId.value}`, modalForm);
      showToast('success', 'Skill updated.');
    } else {
      await api.post('/admin/skills', modalForm);
      showToast('success', 'Skill created.');
    }
    showModal.value = false;
    loadSkills();
  } catch (err) {
    showToast('error', 'Failed to save skill.');
  }
};

const deleteSkill = async (id) => {
  if (!confirm('Are you sure you want to remove this skill?')) return;
  try {
    await api.delete(`/admin/skills/${id}`);
    showToast('success', 'Skill removed.');
    loadSkills();
  } catch (err) {
    showToast('error', 'Failed to delete skill.');
  }
};

onMounted(() => {
  loadSkills();
});
</script>

