<template>
  <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="p-8 text-center">
      <h1 class="text-4xl font-bold text-gray-800 mb-4">Welcome to our Online School!</h1>
      <p class="text-lg text-gray-600 mb-6">Please log in or register to get started.</p>
      <div class="space-x-4">
        <router-link to="/login" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-full">Login</router-link>
        <router-link to="/register" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-6 rounded-full">Register</router-link>
      </div>
    </div>
  </div>
</template>
