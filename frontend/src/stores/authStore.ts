import { defineStore } from 'pinia'
import axiosInstance from '@/utils/axiosInstance'

interface AuthState {
  loading: boolean
  error: string | null
}

export const useAuthStore = defineStore('auth', {
  state: (): AuthState => ({
    loading: false,
    error: null,
  }),

  actions: {
    async login(username: string): Promise<boolean> {
      if (!username.trim()) {
        this.error = 'Введите имя пользователя'
        return false
      }

      this.loading = true
      this.error = null

      try {
        const response = await axiosInstance.post('/user', { username })
        return response.data.data
      } catch (err: unknown) {
        this.error = 'Ошибка при входе'
        return false
      } finally {
        this.loading = false
      }
    },
  },
})
