import { createApp } from 'vue'
import router from './router'
import './assets/style.css'
import App from './App.vue'

// Crear la aplicación Vue
const app = createApp(App)

// Usar Vue Router
app.use(router)

// Montar la aplicación
app.mount('#app')