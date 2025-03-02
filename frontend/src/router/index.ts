import { createRouter, createWebHistory } from 'vue-router'

const getUsernameFromCookies = (): string | null => {
  const match = document.cookie.match(/(?:^|;\s*)username=([^;]*)/)
  return match ? decodeURIComponent(match[1]) : null
}

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: () => import('../views/LoginView.vue'),
      meta: { requiresAuth: false },
    },
    {
      path: '/chat',
      name: 'chat',
      component: () => import('../views/ChatView.vue'),
      meta: { requiresAuth: true },
    },
  ],
})

router.beforeEach((to, from, next) => {
  const username = getUsernameFromCookies()
  if (to.meta.requiresAuth && !username) {
    next('/')
  } else {
    next()
  }
})

export default router
