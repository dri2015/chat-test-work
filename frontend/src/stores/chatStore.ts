import { defineStore } from 'pinia'
import axiosInstance from '@/utils/axiosInstance'

interface MessageInterface {
  id: number
  content: string
  user: UserInterface
  created_at: string
  isMine: boolean
}

interface UserInterface {
  id: number
  username: string
  color: string
}

interface ChatState {
  messages: MessageInterface[]
  loading: boolean
  error: string | null
}

const getUsernameFromCookies = (): string | null => {
  const match = document.cookie.match(/(?:^|;\s*)username=([^;]*)/)
  return match ? decodeURIComponent(match[1]) : null
}

export const useChatStore = defineStore('chat', {
  state: (): ChatState => ({
    messages: [] as MessageInterface[],
    loading: false,
    error: null,
  }),

  actions: {
    async fetchMessages() {
      this.loading = true
      this.error = null

      try {
        const username = getUsernameFromCookies()

        const response = await axiosInstance.get('/messages')
        this.messages = response.data.data.map((msg: MessageInterface) => ({
          id: msg.id,
          content: msg.content,
          user: msg.user,
          created_at: msg.created_at,
          isMine: msg.user.username === username,
        }))
      } catch (err) {
        this.error = 'Ошибка загрузки сообщений'
      } finally {
        this.loading = false
      }
    },

    async sendMessage(text: string) {
      if (!text.trim()) return
      try {
        const username = getUsernameFromCookies()

        await axiosInstance.post('/messages', { content: text })
        const newMessage: MessageInterface = {
          id: Date.now(),
          content: text,
          user: {
            id: Date.now(),
            username: username ?? '',
            color: '',
          },
          created_at: new Date().toISOString(),
          isMine: true,
        }
        this.messages.push(newMessage)
      } catch (err) {
        this.error = 'Ошибка отправки сообщения'
      }
    },
  },
})
