import './bootstrap';
import { createApp } from 'vue'
import Counter from './Components/Counter.vue'

const app = createApp()

app.component('counter', Counter)

app.mount('#app')
