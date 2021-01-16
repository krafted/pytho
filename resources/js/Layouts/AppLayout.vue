<template>
    <div class="flex flex-col h-screen">
        <app-banner />

        <app-header>
            <template #header-actions><slot name="header-actions" /></template>
        </app-header>

        <slot />

        <app-settings @update:setting="updateSetting" />
    </div>
</template>

<script>
    import AppBanner from '@/Components/Banner'
    import AppHeader from '@/Components/Header'
    import AppSettings from '@/Components/Settings'
    import JetNavLink from '@/Jetstream/NavLink'
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink'
    import { Inertia } from '@inertiajs/inertia'
    import { inject, onMounted, provide, reactive, ref, toRaw, watchEffect } from 'vue'
    import DEFAULT_SETTINGS, { nonEditorSettings } from '@/Config/Settings'
    import useMedia from '@/Hooks/useMedia'
    import { updateTheme } from '@/Utils/theme'

    export default {
        components: {
            AppBanner,
            AppHeader,
            AppSettings,
            JetNavLink,
            JetResponsiveNavLink,
        },
        setup(props, context) {
            const state = inject('state')
            const editor = inject('editor', null)
            const isMd = useMedia('(min-width: 768px)')
            const showSettings = ref(false)
            const switchToTeam = (team) => {
                Inertia.put(route('current-team.update'), {
                    'team_id': team.id,
                }, {
                    preserveState: false,
                })
            }
            const updateSetting = ({ key, value }) => {
                state.settings[key] = value
                localStorage.settings = JSON.stringify(state.settings)
                if (!nonEditorSettings.includes(key) && editor) editor.value.setOption(key, value)
            }

            onMounted(() => {
                if (!localStorage.settings) localStorage.settings = JSON.stringify(DEFAULT_SETTINGS)
                else localStorage.settings = JSON.stringify({ ...DEFAULT_SETTINGS, ...JSON.parse(localStorage.settings) })
                state.settings = JSON.parse(localStorage.settings)
                Object.keys(toRaw(state.settings)).forEach(key => {
                    if (!nonEditorSettings.includes(key) && editor) editor.value.setOption(key, state.settings[key])
                })
            })

            onMounted(() => {
                if (state.settings.theme) updateTheme(state.settings.theme)
            })

            provide('isMd', isMd)
            provide('showSettings', showSettings)

            return {
                switchToTeam,
                updateSetting,
            }
        }
    }
</script>
