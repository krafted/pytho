import './bootstrap'
import { createApp } from 'vue'
import { createHead } from '@vueuse/head'
import { plugin as inertia } from '@inertiajs/inertia-vue3'
import App from '@/Components/App'

const el = document.getElementById('app')
const app = createApp(App)
const head = createHead()

app.mount(el)
app.mixin({ methods: { route } })
app.use(head)
app.use(inertia)
