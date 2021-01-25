import { h, onMounted, provide, readonly, ref, toRaw } from 'vue'
import DEFAULT_PREFERENCES, { nonEditorPreferences } from '@/Config/Preferences'
import useMedia from '@/Hooks/useMedia'
import isMobile from 'is-mobile'
import { App } from '@inertiajs/inertia-vue3/dist'
import { updateTheme } from '@/Utils/theme'

const el = document.getElementById('app')

export default {
    setup() {
        const preferences = ref({ DEFAULT_PREFERENCES })
        const editor = ref(null)
        const isMac = ref(navigator.userAgent.indexOf('Mac') !== -1)
        const isMd = useMedia('(min-width: 768px)')
        const updatePreference = (key, value) => {
            preferences.value[key] = value
            localStorage.preferences = JSON.stringify(preferences.value)
            if (!nonEditorPreferences.includes(key) && editor.value) editor.value.setOption(key, value)
        }

        onMounted(() => {
            if (!localStorage.preferences) localStorage.preferences = JSON.stringify(DEFAULT_PREFERENCES)
            else localStorage.preferences = JSON.stringify({ ...DEFAULT_PREFERENCES, ...JSON.parse(localStorage.preferences) })
            preferences.value = JSON.parse(localStorage.preferences)
            Object.keys(toRaw(preferences.value)).forEach(key => {
                if (!nonEditorPreferences.includes(key) && editor.value) editor.value.setOption(key, preferences.value[key])
            })
        })

        onMounted(() => preferences.value.theme && updateTheme(preferences.value.theme))

        provide('preferences', readonly(preferences))
        provide('editor', editor)
        provide('isMac', isMac)
        provide('isMd', isMd)
        provide('isMobile', isMobile())
        provide('updatePreference', updatePreference)
    },
    render: () => h(App, {
        initialPage: JSON.parse(el.dataset.page),
        resolveComponent: name => require(`@/Pages/${name}`).default,
    })
}
