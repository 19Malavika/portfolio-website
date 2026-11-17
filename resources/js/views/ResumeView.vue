<template>
  <div class="min-h-screen flex flex-col bg-[#090d16]">
    <Navbar class="print:hidden" />

    <main class="flex-1 pt-28 pb-20 print:p-0 print:pt-0">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Controls Bar (Hidden in Print) -->
        <div class="mb-8 flex items-center justify-between gap-4 flex-wrap print:hidden">
          <router-link
            to="/#resume"
            class="inline-flex items-center gap-2 text-sm font-semibold text-slate-400 hover:text-sky-400"
          >
            <span>← Back to Portfolio</span>
          </router-link>

          <div class="flex items-center gap-3">
            <button
              @click="printResume"
              class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold bg-slate-800 hover:bg-slate-700 text-white border border-slate-700 flex items-center gap-2"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
              </svg>
              <span>Print CV</span>
            </button>

            <a
              :href="resumeDownloadUrl"
              target="_blank"
              download="Malavika_MM_Resume.pdf"
              class="px-5 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white bg-gradient-to-r from-sky-500 to-indigo-600 hover:from-sky-400 hover:to-indigo-500 shadow-md shadow-sky-500/25 flex items-center gap-2"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
              </svg>
              <span>Download PDF</span>
            </a>
          </div>
        </div>

        <!-- Printable Document Container -->
        <div class="glass-card rounded-3xl p-8 sm:p-12 border border-slate-700 shadow-2xl print:bg-white print:text-black print:p-6 print:rounded-none print:shadow-none print:border-none">
          
          <!-- Resume Header -->
          <div class="border-b border-slate-800 print:border-slate-300 pb-6 mb-6">
            <h1 class="text-3xl font-extrabold text-white print:text-black tracking-tight">
              {{ profile?.name || 'MALAVIKA M M' }}
            </h1>
            <p class="text-sm font-bold text-sky-400 print:text-sky-700 font-mono mt-1">
              FULL STACK DEVELOPER | FLUTTER | LARAVEL | PHP
            </p>
            <div class="flex items-center gap-3 text-xs text-slate-400 print:text-slate-600 mt-2 flex-wrap font-mono">
              <span>{{ profile?.location || 'Thrissur, Kerala, India' }}</span>
              <span>|</span>
              <span>{{ profile?.phone || '7736192047' }}</span>
              <span>|</span>
              <span>{{ profile?.email || 'malavikamm177@gmail.com' }}</span>
            </div>
            <div class="flex items-center gap-4 text-xs font-mono mt-1 text-slate-400 print:text-slate-700">
              <span>GitHub: https://github.com/19Malavika</span>
              <span>|</span>
              <span>LinkedIn: https://www.linkedin.com/in/malavika-m-m-b722142a0/</span>
            </div>
          </div>

          <!-- Section: Professional Summary -->
          <div class="mb-6 space-y-2">
            <h2 class="text-xs font-mono font-bold text-sky-400 print:text-sky-800 uppercase tracking-widest border-b border-slate-800 print:border-slate-300 pb-1">
              PROFESSIONAL SUMMARY
            </h2>
            <p class="text-xs sm:text-sm text-slate-300 print:text-slate-800 leading-relaxed">
              {{ profile?.bio || profile?.short_intro }}
            </p>
          </div>

          <!-- Section: Technical Skills -->
          <div class="mb-6 space-y-2">
            <h2 class="text-xs font-mono font-bold text-emerald-400 print:text-emerald-800 uppercase tracking-widest border-b border-slate-800 print:border-slate-300 pb-1">
              TECHNICAL SKILLS
            </h2>
            <div class="text-xs sm:text-sm text-slate-300 print:text-slate-800 space-y-1">
              <div><strong>Languages:</strong> Dart, PHP, JavaScript, Python, HTML5, CSS3</div>
              <div><strong>Frontend & Mobile:</strong> Flutter, React.js, Vue.js, Material 3, Bootstrap, Responsive UI/UX, Custom Widgets, CustomPainter</div>
              <div><strong>Backend:</strong> Laravel, PHP, MVC Architecture, REST APIs, Authentication, Authorization, RBAC, CRUD Operations, Form Validation, Eloquent ORM</div>
              <div><strong>State Management & Architecture:</strong> Riverpod 3.x, Clean Architecture, Feature-Based Architecture, Modular Design</div>
              <div><strong>Databases & Services:</strong> MySQL, SQLite, Firebase, Firestore</div>
              <div><strong>Tools & APIs:</strong> Git, GitHub, Axios, TMDB API, Figma, VS Code</div>
            </div>
          </div>

          <!-- Section: Key Projects -->
          <div class="mb-6 space-y-4">
            <h2 class="text-xs font-mono font-bold text-indigo-400 print:text-indigo-800 uppercase tracking-widest border-b border-slate-800 print:border-slate-300 pb-1">
              PROJECTS & SYSTEMS
            </h2>

            <!-- Project 1 -->
            <div class="space-y-1 text-xs sm:text-sm">
              <div class="flex items-center justify-between font-bold text-white print:text-black">
                <span>SMART RESOURCE BOOKING & ALLOCATION SYSTEM</span>
                <span class="text-xs font-mono text-sky-400 print:text-sky-700">Laravel | PHP | MySQL</span>
              </div>
              <ul class="list-disc list-inside text-xs text-slate-300 print:text-slate-800 space-y-0.5">
                <li>Developed enterprise resource booking for meeting rooms, vehicles, projectors, and shared organizational assets.</li>
                <li>Implemented multi-tier role-based access for Employees, Resource Managers, and System Administrators.</li>
                <li>Applied transaction-based booking logic and conflict prevention workflows.</li>
                <li>GitHub: https://github.com/19Malavika/smart_resource_booking</li>
              </ul>
            </div>

            <!-- Project 2 -->
            <div class="space-y-1 text-xs sm:text-sm">
              <div class="flex items-center justify-between font-bold text-white print:text-black">
                <span>EMPLOYEE LEAVE MANAGEMENT SYSTEM</span>
                <span class="text-xs font-mono text-sky-400 print:text-sky-700">Laravel | PHP | Eloquent</span>
              </div>
              <ul class="list-disc list-inside text-xs text-slate-300 print:text-slate-800 space-y-0.5">
                <li>Developed web-based employee leave management system for applications, approvals, and balance accounting.</li>
                <li>Implemented employee and manager approval/rejection workflows with role-based access control.</li>
                <li>Applied Laravel MVC, migrations, form validation, and database relationships.</li>
                <li>GitHub: https://github.com/19Malavika/employee-leave-management-system.git</li>
              </ul>
            </div>

            <!-- Project 3 -->
            <div class="space-y-1 text-xs sm:text-sm">
              <div class="flex items-center justify-between font-bold text-white print:text-black">
                <span>RIVERPOD FLUTTER SHOPPING APP</span>
                <span class="text-xs font-mono text-sky-400 print:text-sky-700">Flutter | Dart | Riverpod 3.x</span>
              </div>
              <ul class="list-disc list-inside text-xs text-slate-300 print:text-slate-800 space-y-0.5">
                <li>Developed responsive cross-platform e-commerce application using Flutter and Material 3.</li>
                <li>Implemented reactive state management using Riverpod providers and derived providers.</li>
                <li>Built dynamic product catalog with lazy GridView.builder and price filtering.</li>
                <li>GitHub: https://github.com/19Malavika/riverpod-flutter.git</li>
              </ul>
            </div>

            <!-- Project 4 -->
            <div class="space-y-1 text-xs sm:text-sm">
              <div class="flex items-center justify-between font-bold text-white print:text-black">
                <span>FLEXTENURE – BNPL & EMI FINANCING APPLICATION</span>
                <span class="text-xs font-mono text-sky-400 print:text-sky-700">Flutter | Dart | Material 3</span>
              </div>
              <ul class="list-disc list-inside text-xs text-slate-300 print:text-slate-800 space-y-0.5">
                <li>Developed Flutter fintech application UI for Buy Now Pay Later and EMI financing.</li>
                <li>Engineered dedicated interfaces for Buyer and Merchant personas with credit dashboard and EMI calculators.</li>
                <li>GitHub: https://github.com/19Malavika/flextenure-app-simple-UI.git</li>
              </ul>
            </div>

            <!-- Project 5 -->
            <div class="space-y-1 text-xs sm:text-sm">
              <div class="flex items-center justify-between font-bold text-white print:text-black">
                <span>GOWAYANAD – EMERGENCY RIDE BOOKING APPLICATION</span>
                <span class="text-xs font-mono text-sky-400 print:text-sky-700">Flutter | Firebase</span>
              </div>
              <ul class="list-disc list-inside text-xs text-slate-300 print:text-slate-800 space-y-0.5">
                <li>Developed Android emergency transport app supporting passenger and driver roles with live GPS tracking.</li>
                <li>Implemented OTP authentication, fare calculation, and Firebase realtime persistence.</li>
                <li>GitHub: https://github.com/Athmana/MiniProject-group-19.git</li>
              </ul>
            </div>
          </div>

          <!-- Section: Education -->
          <div class="space-y-2">
            <h2 class="text-xs font-mono font-bold text-rose-400 print:text-rose-800 uppercase tracking-widest border-b border-slate-800 print:border-slate-300 pb-1">
              EDUCATION
            </h2>
            <div class="flex items-center justify-between text-xs sm:text-sm text-slate-300 print:text-slate-800">
              <div>
                <strong>B.Tech in Computer Science and Engineering</strong>
                <div class="text-xs text-slate-400 print:text-slate-600">Government Engineering College, Wayanad (APJ Abdul Kalam Technological University)</div>
              </div>
              <span class="font-mono text-xs text-sky-400 print:text-black">2020 – 2024 | 8.2 CGPA</span>
            </div>
          </div>

        </div>

      </div>
    </main>

    <Footer class="print:hidden" />
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import api from '../services/api';
import Navbar from '../components/Navbar.vue';
import Footer from '../components/Footer.vue';

const profile = ref(null);

const loadProfile = async () => {
  try {
    const res = await api.get('/profile');
    if (res.data && res.data.data) {
      profile.value = res.data.data;
    }
  } catch (e) {
    console.error(e);
  }
};

const resumeDownloadUrl = computed(() => {
  return profile.value?.resume_path || '/api/resume/download';
});

const printResume = () => {
  window.print();
};

onMounted(() => {
  loadProfile();
});
</script>

