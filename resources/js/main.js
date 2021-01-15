import './bootstrap'
import { createApp } from 'vue'
import { plugin as InertiaPlugin } from '@inertiajs/inertia-vue3'
import App from '@/Components/App'

const el = document.getElementById('app')
const app = createApp(App)

app.mount(el)
app.mixin({ methods: { route } })
app.use(InertiaPlugin)
