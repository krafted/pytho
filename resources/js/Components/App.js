import { h, onMounted, provide, readonly, ref, toRaw } from 'vue'
import DEFAULT_SETTINGS, { nonEditorSettings } from '@/Config/Settings'
import useMedia from '@/Hooks/useMedia'
import isMobile from 'is-mobile'
import { App } from '@inertiajs/inertia-vue3/dist'
import { updateTheme } from '@/Utils/theme'

const el = document.getElementById('app')

export default {
    setup() {
        const settings = ref({ DEFAULT_SETTINGS })
        const editor = ref(null)
        const isMac = ref(navigator.userAgent.indexOf('Mac') !== -1)
        const isMd = useMedia('(min-width: 768px)')
        const updateSetting = (key, value) => {
            settings.value[key] = value
            localStorage.settings = JSON.stringify(settings.value)
            if (!nonEditorSettings.includes(key) && editor.value) editor.value.setOption(key, value)
        }

        onMounted(() => {
            if (!localStorage.settings) localStorage.settings = JSON.stringify(DEFAULT_SETTINGS)
            else localStorage.settings = JSON.stringify({ ...DEFAULT_SETTINGS, ...JSON.parse(localStorage.settings) })
            settings.value = JSON.parse(localStorage.settings)
            Object.keys(toRaw(settings.value)).forEach(key => {
                if (!nonEditorSettings.includes(key) && editor.value) editor.value.setOption(key, settings.value[key])
            })
        })

        onMounted(() => settings.value.theme && updateTheme(settings.value.theme))

        provide('settings', readonly(settings))
        provide('editor', editor)
        provide('isMac', isMac)
        provide('isMd', isMd)
        provide('isMobile', isMobile())
        provide('updateSetting', updateSetting)
    },
    render: () => h(App, {
        initialPage: JSON.parse(el.dataset.page),
        resolveComponent: name => require(`@/Pages/${name}`).default,
    })
}
