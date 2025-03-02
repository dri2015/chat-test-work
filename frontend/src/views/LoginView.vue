<template>
  <q-page>
    <q-card class="q-pa-md">
      <q-card-section>
        <div class="text-h6 text-center">Вход в чат</div>
      </q-card-section>

      <q-card-section>
        <q-input
          v-model="username"
          label="Имя пользователя"
          filled
          clearable
          :error="!!authStore.error"
          :error-message="authStore.error || ''"
        />
      </q-card-section>

      <q-card-actions align="center">
        <q-btn color="primary" label="Войти" :disable="authStore.loading" @click="handleLogin" />
      </q-card-actions>
    </q-card>
  </q-page>
</template>

<script lang="ts">
import { ref } from 'vue'
import { useAuthStore } from '@/stores/authStore'
import { useRouter } from 'vue-router'

export default {
  setup() {
    const username = ref<string>('')
    const authStore = useAuthStore()
    const router = useRouter()

    const handleLogin = async (): Promise<void> => {
      const success = await authStore.login(username.value)

      if (success) {
        document.cookie = `username=${encodeURIComponent(username.value)}; path=/; max-age=${7 * 24 * 60 * 60}`
        await router.push('/chat')
      }
    }

    return {
      username,
      authStore,
      handleLogin,
    }
  },
}
</script>
