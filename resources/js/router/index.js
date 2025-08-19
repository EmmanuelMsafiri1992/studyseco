import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '../stores/auth';
import Home from '../components/Home.vue';
import RegisterForm from '../components/auth/RegisterForm.vue';
import LoginForm from '../components/auth/LoginForm.vue';
import Dashboard from '../components/auth/Dashboard.vue';

const routes = [
  { path: '/', component: Home }, // This handles the default route
  { path: '/register', component: RegisterForm },
  { path: '/login', component: LoginForm },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: Dashboard,
    meta: { requiresAuth: true }
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const authStore = useAuthStore();
  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    next('/login');
  } else {
    next();
  }
});

export default router;
