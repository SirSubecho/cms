import { defineStore } from 'pinia'
import api from 'src/services/api'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: localStorage.getItem('auth_token') || null
  }),

  getters: {
    isAuthenticated: (state) => !!state.token
  },

  actions: {
    async login(credentials) {
      const response = await api.post('/login', credentials)
      this.token = response.data.token
      this.user = response.data.user
      localStorage.setItem('auth_token', this.token)
    },

    async logout() {
      await api.post('/logout')
      this.token = null
      this.user = null
      localStorage.removeItem('auth_token')
    },

    async fetchUser() {
      if (this.token) {
        const response = await api.get('/user')
        this.user = response.data
      }
    }
  }
})
