<template>
  <q-page class="q-pa-md column">
    <div class="text-h6 text-center q-mb-md">Чат</div>

    <q-banner v-if="chatStore.error" class="bg-red text-white q-mb-md">
      {{ chatStore.error }}
    </q-banner>

    <q-scroll-area ref="scrollAreaRef" class="chat-box">
      <div v-if="chatStore.messages && chatStore.messages.length > 0">
        <div v-for="(message, index) in chatStore.messages" :key="message.id">
          <q-chat-message v-if="shouldShowDate(index)" :label="formatDate(message.created_at)" />

          <q-chat-message
            :style="{ color: !message.isMine ? message.user.color : '' }"
            :name="message.user.username"
            :text="[message.content]"
            :sent="message.isMine"
          />
        </div>
      </div>
      <div v-else>
        <p>Нет сообщений</p>
      </div>
    </q-scroll-area>

    <div class="q-mt-md row items-center">
      <q-input
        v-model="newMessage"
        outlined
        placeholder="Введите сообщение..."
        class="col-grow"
        @keyup.enter="sendMessage"
        :disable="!!chatStore.error"
      />
      <q-btn
        icon="send"
        color="primary"
        @click="sendMessage"
        class="q-ml-sm"
        :disable="!!chatStore.error"
      />
    </div>
  </q-page>
</template>

<script lang="ts">
import { ref, onMounted, nextTick } from 'vue'
import { useChatStore } from '@/stores/chatStore'
import { format, parseISO } from 'date-fns'
import type { QScrollArea } from 'quasar'
import { onUnmounted } from '@vue/runtime-core'

export default {
  setup() {
    const chatStore = useChatStore()
    const newMessage = ref<string>('')
    const scrollAreaRef = ref<QScrollArea | null>(null)
    let interval = 0

    const shouldShowDate = (index: number): boolean => {
      if (index === 0) return true
      const currentMessageDate = parseISO(chatStore.messages[index].created_at)
      const previousMessageDate = parseISO(chatStore.messages[index - 1].created_at)

      return format(currentMessageDate, 'yyyy-MM-dd') !== format(previousMessageDate, 'yyyy-MM-dd')
    }

    const formatDate = (date: string): string => {
      const parsedDate = parseISO(date)
      return format(parsedDate, 'eeee, d MMMM')
    }

    onMounted(async () => {
      try {
        await chatStore.fetchMessages()
        scrollToBottom()

        interval = setInterval(async () => {
          try {
            await chatStore.fetchMessages()
            scrollToBottom()
          } catch (error) {
            console.error('Ошибка при загрузке сообщений:', error)
          }
        }, 3000)
      } catch (error) {
        console.error('Ошибка при первоначальной загрузке сообщений:', error)
      }
    })

    onUnmounted(() => {
      clearInterval(interval)
    })

    const scrollToBottom = () => {
      nextTick(() => {
        setTimeout(() => {
          if (scrollAreaRef.value) {
            scrollAreaRef.value.setScrollPercentage('vertical', 1)
          }
        }, 10)
      })
    }

    const sendMessage = async () => {
      await chatStore.sendMessage(newMessage.value)
      newMessage.value = ''
      scrollToBottom()
    }

    return {
      chatStore,
      newMessage,
      sendMessage,
      scrollAreaRef,
      shouldShowDate,
      formatDate,
    }
  },
}
</script>

<style scoped>
.chat-box {
  height: 60vh;
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 0 50px;
}
</style>
