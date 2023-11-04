// import './assets/main.css'

import VueGoogleMaps from '@fawmi/vue-google-maps'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import './axios'

import App from './App.vue'
import router from './router'
import './assets/style.css'

const app = createApp(App)

app.use(VueGoogleMaps, {
  load: {
    key: import.meta.env.VITE_GOOGLE_MAPS_API_KEY,
    libraries: 'places'
  }
})

app.use(createPinia())
app.use(router)

app.mount('#app')
