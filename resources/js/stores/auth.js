import { defineStore } from 'pinia';
import axios from 'axios';

// Set your Laravel API base URL
const API_BASE_URL = '/api';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    token: localStorage.getItem('token') || null,
    user: null,
  }),
  actions: {
    async login(credentials) {
      try {
        const response = await axios.post(`${API_BASE_URL}/login`, credentials);
        this.setAuth(response.data.token, response.data.user);
        return response.data;
      } catch (error) {
        throw error;
      }
    },
    async registerStudent(userData) {
      try {
        const response = await axios.post(`${API_BASE_URL}/register/student`, userData);
        this.setAuth(response.data.token, response.data.user);
        return response.data;
      } catch (error) {
        throw error;
      }
    },
    async registerTeacher(userData) {
      try {
        const response = await axios.post(`${API_BASE_URL}/register/teacher`, userData);
        this.setAuth(response.data.token, response.data.user);
        return response.data;
      } catch (error) {
        throw error;
      }
    },
    setAuth(token, user) {
      this.token = token;
      this.user = user;
      localStorage.setItem('token', token);
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    },
    logout() {
      this.token = null;
      this.user = null;
      localStorage.removeItem('token');
      delete axios.defaults.headers.common['Authorization'];
    },
  },
  getters: {
    isAuthenticated: (state) => !!state.token,
  },
});
