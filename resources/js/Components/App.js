import { h, provide, reactive, ref } from "vue"
import DEFAULT_SETTINGS from '@/Config/Settings'
import isMobile from "is-mobile"
import { App } from "@inertiajs/inertia-vue3/dist"

const el = document.getElementById('app')

export default {
    setup() {
        const state = reactive({ settings: DEFAULT_SETTINGS })
        const isMac = ref(navigator.userAgent.indexOf('Mac') !== -1)

        provide('state', state)
        provide('isMac', isMac)
        provide('isMobile', isMobile())
    },
    render: () => h(App, {
        initialPage: JSON.parse(el.dataset.page),
        resolveComponent: name => require(`@/Pages/${name}`).default,
    })
}
