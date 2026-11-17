import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/HomeView.vue';
import ProjectDetailView from '../views/ProjectDetailView.vue';
import ResumeView from '../views/ResumeView.vue';
import LoginView from '../views/LoginView.vue';
import AdminLayout from '../views/admin/AdminLayout.vue';
import AdminDashboard from '../views/admin/AdminDashboard.vue';
import AdminProfile from '../views/admin/AdminProfile.vue';
import AdminProjects from '../views/admin/AdminProjects.vue';
import AdminSkills from '../views/admin/AdminSkills.vue';
import AdminExperience from '../views/admin/AdminExperience.vue';
import AdminEducation from '../views/admin/AdminEducation.vue';
import AdminCertifications from '../views/admin/AdminCertifications.vue';
import AdminSocialLinks from '../views/admin/AdminSocialLinks.vue';
import AdminMessages from '../views/admin/AdminMessages.vue';

const routes = [
  {
    path: '/',
    name: 'Home',
    component: HomeView,
  },
  {
    path: '/project/:slug',
    name: 'ProjectDetail',
    component: ProjectDetailView,
    props: true,
  },
  {
    path: '/resume',
    name: 'Resume',
    component: ResumeView,
  },
  {
    path: '/login',
    name: 'Login',
    component: LoginView,
  },
  {
    path: '/admin',
    component: AdminLayout,
    meta: { requiresAuth: true },
    children: [
      {
        path: '',
        redirect: '/admin/dashboard',
      },
      {
        path: 'dashboard',
        name: 'AdminDashboard',
        component: AdminDashboard,
      },
      {
        path: 'profile',
        name: 'AdminProfile',
        component: AdminProfile,
      },
      {
        path: 'projects',
        name: 'AdminProjects',
        component: AdminProjects,
      },
      {
        path: 'skills',
        name: 'AdminSkills',
        component: AdminSkills,
      },
      {
        path: 'experience',
        name: 'AdminExperience',
        component: AdminExperience,
      },
      {
        path: 'education',
        name: 'AdminEducation',
        component: AdminEducation,
      },
      {
        path: 'certifications',
        name: 'AdminCertifications',
        component: AdminCertifications,
      },
      {
        path: 'social-links',
        name: 'AdminSocialLinks',
        component: AdminSocialLinks,
      },
      {
        path: 'messages',
        name: 'AdminMessages',
        component: AdminMessages,
      },
    ],
  },
  {
    path: '/:pathMatch(.*)*',
    redirect: '/',
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition;
    }
    if (to.hash) {
      return {
        el: to.hash,
        behavior: 'smooth',
      };
    }
    return { top: 0, behavior: 'smooth' };
  },
});

// Admin Auth Guard
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('admin_token');
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!token) {
      next({ name: 'Login', query: { redirect: to.fullPath } });
    } else {
      next();
    }
  } else if (to.name === 'Login' && token) {
    next({ name: 'AdminDashboard' });
  } else {
    next();
  }
});

export default router;

