<template>
  <div class="flex items-center justify-center min-h-screen bg-gray-100 p-4">
    <div class="w-full max-w-sm bg-white p-8 rounded-lg shadow-md">
      <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Login</h2>
      <form @submit.prevent="handleLogin">
        <div class="mb-4">
          <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
          <input type="email" id="email" v-model="credentials.email" required
                 class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
        </div>
        <div class="mb-6">
          <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
          <input type="password" id="password" v-model="credentials.password" required
                 class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" />
        </div>
        <div class="flex items-center justify-between">
          <button type="submit" :disabled="isLoading"
                  class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline disabled:opacity-50">
            {{ isLoading ? 'Logging in...' : 'Login' }}
          </button>
        </div>
        <p v-if="error" class="text-red-500 text-sm mt-4">{{ error }}</p>
        <p class="text-center text-sm mt-4">
          Don't have an account? <router-link to="/register" class="text-indigo-600 hover:text-indigo-800 font-bold">Register</router-link>
        </p>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../../stores/auth';

const router = useRouter();
const authStore = useAuthStore();
const isLoading = ref(false);
const error = ref('');

const credentials = ref({
  email: '',
  password: '',
});

const handleLogin = async () => {
  isLoading.value = true;
  error.value = '';
  try {
    await authStore.login(credentials.value);
    router.push('/dashboard'); // Redirect to dashboard on success
  } catch (err) {
    error.value = 'Invalid email or password. Please try again.';
    console.error(err);
  } finally {
    isLoading.value = false;
  }
};
</script>
