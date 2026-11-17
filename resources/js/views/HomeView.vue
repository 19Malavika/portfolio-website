<template>
  <div>
    <!-- Sticky Navbar -->
    <Navbar />

    <!-- Main Content -->
    <main>
      <!-- Hero Section -->
      <Hero :profile="portfolioData.profile" />

      <!-- About Section -->
      <About :profile="portfolioData.profile" />

      <!-- Skills Section -->
      <Skills :skills="portfolioData.skills" />

      <!-- Experience Section -->
      <Experience :experiences="portfolioData.experiences" />

      <!-- Education Section -->
      <Education :education="portfolioData.education" />

      <!-- Projects Section -->
      <Projects :projects="portfolioData.all_projects" />

      <!-- Certifications Section -->
      <Certifications :certifications="portfolioData.certifications" />

      <!-- Resume Section -->
      <ResumeSection :profile="portfolioData.profile" />

      <!-- Contact Section -->
      <Contact />
    </main>

    <!-- Footer -->
    <Footer />
  </div>
</template>

<script setup>
import { reactive, onMounted } from 'vue';
import api from '../services/api';

import Navbar from '../components/Navbar.vue';
import Hero from '../components/Hero.vue';
import About from '../components/About.vue';
import Skills from '../components/Skills.vue';
import Experience from '../components/Experience.vue';
import Education from '../components/Education.vue';
import Projects from '../components/Projects.vue';
import Certifications from '../components/Certifications.vue';
import ResumeSection from '../components/ResumeSection.vue';
import Contact from '../components/Contact.vue';
import Footer from '../components/Footer.vue';

const portfolioData = reactive({
  profile: null,
  skills: [],
  experiences: [],
  education: [],
  all_projects: [],
  certifications: [],
  social_links: []
});

const loadData = async () => {
  try {
    const res = await api.get('/initial-data');
    if (res.data && res.data.data) {
      Object.assign(portfolioData, res.data.data);
    }
  } catch (error) {
    console.error('Failed to load portfolio initial data:', error);
  }
};

onMounted(() => {
  loadData();
});
</script>
