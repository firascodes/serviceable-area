// import './assets/main.css'

import VueGoogleMaps from '@fawmi/vue-google-maps'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'
import './assets/style.css'

const app = createApp(App)

app.use(VueGoogleMaps, {
  load: {
    key: 'AIzaSyByFQx9G1-8D0HhL6L4iYp_7yZA127oGFY',
    libraries: 'places'
  }
})

app.use(createPinia())
app.use(router)

app.mount('#app')
