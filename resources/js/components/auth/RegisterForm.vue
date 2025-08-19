<template>
  <div class="flex items-center justify-center min-h-screen bg-gray-100 p-4">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
      <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Create an Account</h2>
      <form @submit.prevent="handleRegistration">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="mb-4">
            <label for="first_name" class="block text-gray-700 text-sm font-bold mb-2">First Name</label>
            <input type="text" id="first_name" v-model="form.first_name" required
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
          </div>
          <div class="mb-4">
            <label for="last_name" class="block text-gray-700 text-sm font-bold mb-2">Last Name</label>
            <input type="text" id="last_name" v-model="form.last_name" required
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
          </div>
        </div>
        <div class="mb-4">
          <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
          <input type="email" id="email" v-model="form.email" required
                 class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
        </div>
        <div class="mb-6">
          <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
          <input type="password" id="password" v-model="form.password" required
                 class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" />
        </div>
        <div class="mb-6">
          <label class="block text-gray-700 text-sm font-bold mb-2">Register As:</label>
          <div class="flex items-center space-x-4">
            <label class="inline-flex items-center">
              <input type="radio" v-model="form.role" value="student" required class="form-radio text-indigo-600" />
              <span class="ml-2 text-gray-700">Student</span>
            </label>
            <label class="inline-flex items-center">
              <input type="radio" v-model="form.role" value="teacher" class="form-radio text-indigo-600" />
              <span class="ml-2 text-gray-700">Teacher</span>
            </label>
          </div>
        </div>
        <div class="flex items-center justify-between">
          <button type="submit" :disabled="isLoading"
                  class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline disabled:opacity-50">
            {{ isLoading ? 'Registering...' : 'Register' }}
          </button>
        </div>
        <p v-if="error" class="text-red-500 text-sm mt-4">{{ error }}</p>
        <p class="text-center text-sm mt-4">
          Already have an account? <router-link to="/login" class="text-indigo-600 hover:text-indigo-800 font-bold">Login</router-link>
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

const form = ref({
  first_name: '',
  last_name: '',
  email: '',
  password: '',
  role: 'student', // Default role
});

const handleRegistration = async () => {
  isLoading.value = true;
  error.value = '';
  try {
    if (form.value.role === 'student') {
      await authStore.registerStudent(form.value);
    } else {
      await authStore.registerTeacher(form.value);
    }
    router.push('/dashboard'); // Redirect to dashboard on success
  } catch (err) {
    error.value = 'Registration failed. Please try again.';
    console.error(err);
  } finally {
    isLoading.value = false;
  }
};
</script>
