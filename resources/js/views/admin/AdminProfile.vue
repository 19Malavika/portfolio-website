<template>
  <div class="space-y-8 max-w-4xl">
    
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-extrabold text-white">Profile & Resume Management</h1>
        <p class="text-xs text-slate-400">Update your developer bio, contact details, profile photo, and downloadable PDF resume.</p>
      </div>

      <button
        @click="saveProfile"
        :disabled="saving"
        class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-white bg-gradient-to-r from-sky-500 to-indigo-600 hover:from-sky-400 hover:to-indigo-500 shadow-md shadow-sky-500/25 flex items-center gap-2 cursor-pointer disabled:opacity-50"
      >
        <span v-if="saving" class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
        <span>{{ saving ? 'Saving Changes...' : 'Save Profile Changes' }}</span>
      </button>
    </div>

    <!-- Toast Feedback Notification -->
    <div
      v-if="toast.message"
      class="p-4 rounded-xl text-xs flex items-center gap-2"
      :class="toast.type === 'success' ? 'bg-emerald-950 text-emerald-200 border border-emerald-800' : 'bg-rose-950 text-rose-200 border border-rose-800'"
    >
      <span>{{ toast.type === 'success' ? '✅' : '⚠️' }}</span>
      <span>{{ toast.message }}</span>
    </div>

    <!-- File Uploads Card (Resume PDF & Avatar Photo) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      
      <!-- Resume PDF Upload -->
      <div class="glass-card rounded-2xl p-6 border border-slate-800 space-y-4">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-rose-500/10 text-rose-400 flex items-center justify-center font-bold text-lg">
            📄
          </div>
          <div>
            <h3 class="text-sm font-bold text-white">Resume PDF File</h3>
            <p class="text-[11px] text-slate-400">Current: <span class="font-mono text-sky-400 truncate">{{ form.resume_path || 'None uploaded' }}</span></p>
          </div>
        </div>

        <div>
          <label class="block text-xs font-mono text-slate-300 mb-2">Upload New PDF (Max 10MB)</label>
          <input
            type="file"
            accept=".pdf,application/pdf"
            @change="handleResumeUpload"
            class="block w-full text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-sky-500 file:text-white hover:file:bg-sky-400 cursor-pointer"
          />
        </div>
        
        <div v-if="uploadingResume" class="text-xs text-sky-400 font-mono flex items-center gap-2">
          <span class="w-3 h-3 border-2 border-sky-400 border-t-transparent rounded-full animate-spin"></span>
          <span>Uploading and storing resume in Laravel storage...</span>
        </div>
      </div>

      <!-- Avatar Photo Upload -->
      <div class="glass-card rounded-2xl p-6 border border-slate-800 space-y-4">
        <div class="flex items-center gap-3">
          <div class="w-12 h-12 rounded-xl overflow-hidden border border-slate-700 bg-slate-900 flex-shrink-0">
            <img :src="form.avatar_url || '/images/avatar.jpg'" class="w-full h-full object-cover" />
          </div>
          <div>
            <h3 class="text-sm font-bold text-white">Profile Photo</h3>
            <p class="text-[11px] text-slate-400">Supported formats: JPG, PNG, WEBP, SVG</p>
          </div>
        </div>

        <div>
          <label class="block text-xs font-mono text-slate-300 mb-2">Upload New Photo (Max 5MB)</label>
          <input
            type="file"
            accept="image/*"
            @change="handleAvatarUpload"
            class="block w-full text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-500 file:text-white hover:file:bg-indigo-400 cursor-pointer"
          />
        </div>

        <div v-if="uploadingAvatar" class="text-xs text-indigo-400 font-mono flex items-center gap-2">
          <span class="w-3 h-3 border-2 border-indigo-400 border-t-transparent rounded-full animate-spin"></span>
          <span>Uploading avatar...</span>
        </div>
      </div>

    </div>

    <!-- Main Profile Form -->
    <div class="glass-card rounded-2xl p-6 sm:p-8 border border-slate-800 space-y-5">
      
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-xs font-mono text-slate-300 mb-1">Full Name</label>
          <input
            v-model="form.name"
            type="text"
            class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-sm focus:outline-none focus:border-sky-500"
          />
        </div>

        <div>
          <label class="block text-xs font-mono text-slate-300 mb-1">Professional Title</label>
          <input
            v-model="form.title"
            type="text"
            class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-sm focus:outline-none focus:border-sky-500"
          />
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
          <label class="block text-xs font-mono text-slate-300 mb-1">Email</label>
          <input
            v-model="form.email"
            type="email"
            class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-sm focus:outline-none focus:border-sky-500"
          />
        </div>

        <div>
          <label class="block text-xs font-mono text-slate-300 mb-1">Phone / WhatsApp</label>
          <input
            v-model="form.phone"
            type="text"
            class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-sm focus:outline-none focus:border-sky-500"
          />
        </div>

        <div>
          <label class="block text-xs font-mono text-slate-300 mb-1">Location</label>
          <input
            v-model="form.location"
            type="text"
            class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-sm focus:outline-none focus:border-sky-500"
          />
        </div>
      </div>

      <div>
        <label class="block text-xs font-mono text-slate-300 mb-1">Tagline / Subtitle</label>
        <input
          v-model="form.tagline"
          type="text"
          class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-sm focus:outline-none focus:border-sky-500"
        />
      </div>

      <div>
        <label class="block text-xs font-mono text-slate-300 mb-1">Short Introduction (Hero Section)</label>
        <textarea
          v-model="form.short_intro"
          rows="3"
          class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-sm focus:outline-none focus:border-sky-500 resize-none"
        ></textarea>
      </div>

      <div>
        <label class="block text-xs font-mono text-slate-300 mb-1">Career Objective</label>
        <textarea
          v-model="form.career_objective"
          rows="3"
          class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-sm focus:outline-none focus:border-sky-500 resize-none"
        ></textarea>
      </div>

      <div>
        <label class="block text-xs font-mono text-slate-300 mb-1">Extended Bio / Professional Intro</label>
        <textarea
          v-model="form.bio"
          rows="4"
          class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-sm focus:outline-none focus:border-sky-500"
        ></textarea>
      </div>

    </div>

  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
import api from '../../services/api';

const form = reactive({
  name: '',
  title: '',
  tagline: '',
  short_intro: '',
  career_objective: '',
  bio: '',
  phone: '',
  email: '',
  location: '',
  avatar_url: '',
  resume_path: '',
});

const saving = ref(false);
const uploadingResume = ref(false);
const uploadingAvatar = ref(false);
const toast = reactive({ type: '', message: '' });

const showToast = (type, message) => {
  toast.type = type;
  toast.message = message;
  setTimeout(() => {
    toast.message = '';
  }, 4000);
};

const loadProfile = async () => {
  try {
    const res = await api.get('/admin/profile');
    if (res.data && res.data.data) {
      Object.assign(form, res.data.data);
    }
  } catch (err) {
    console.error(err);
  }
};

const saveProfile = async () => {
  saving.value = true;
  try {
    await api.put('/admin/profile', form);
    showToast('success', 'Profile details saved successfully.');
  } catch (err) {
    showToast('error', 'Failed to update profile. Please check validation rules.');
  } finally {
    saving.value = false;
  }
};

const handleResumeUpload = async (event) => {
  const file = event.target.files[0];
  if (!file) return;

  const data = new FormData();
  data.append('resume', file);

  uploadingResume.value = true;
  try {
    const res = await api.post('/admin/resume/upload', data, {
      headers: { 'Content-Type': 'multipart/form-data' }
    });
    if (res.data && res.data.url) {
      form.resume_path = res.data.url;
      showToast('success', 'Resume PDF uploaded successfully!');
    }
  } catch (err) {
    showToast('error', 'Failed to upload resume. Ensure file is a PDF under 10MB.');
  } finally {
    uploadingResume.value = false;
  }
};

const handleAvatarUpload = async (event) => {
  const file = event.target.files[0];
  if (!file) return;

  const data = new FormData();
  data.append('avatar', file);

  uploadingAvatar.value = true;
  try {
    const res = await api.post('/admin/avatar/upload', data, {
      headers: { 'Content-Type': 'multipart/form-data' }
    });
    if (res.data && res.data.url) {
      form.avatar_url = res.data.url;
      showToast('success', 'Avatar image uploaded successfully!');
    }
  } catch (err) {
    showToast('error', 'Failed to upload avatar. Ensure file is an image under 5MB.');
  } finally {
    uploadingAvatar.value = false;
  }
};

onMounted(() => {
  loadProfile();
});
</script>
