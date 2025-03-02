import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import router from './router'
import {
  QBtn,
  QCard,
  QCardActions,
  QCardSection,
  QInput,
  QLayout,
  QPage,
  QPageContainer,
  Quasar,
  QChatMessage,
  QScrollArea,
  QBanner,
} from 'quasar'
import App from '@/App.vue'

const app = createApp(App).use(Quasar, {
  config: {},
  plugins: {},
  framework: {
    iconSet: 'material-icons',
  },
  components: {
    QCardSection,
    QBtn,
    QCardActions,
    QInput,
    QCard,
    QPage,
    QLayout,
    QPageContainer,
    QChatMessage,
    QScrollArea,
    QBanner,
  },
})

app.use(createPinia())
app.use(router)

app.mount('#app')
