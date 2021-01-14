<template>
    <div class="flex flex-col h-screen">
        <jet-banner />

        <app-header />

        <slot />

        <app-settings @update:setting="updateSetting" />
    </div>
</template>

<script>
    import AppHeader from '@/Components/Header'
    import AppSettings from '@/Components/Settings'
    import JetApplicationMark from '@/Jetstream/ApplicationMark'
    import JetBanner from '@/Jetstream/Banner'
    import JetDropdown from '@/Jetstream/Dropdown'
    import JetDropdownLink from '@/Jetstream/DropdownLink'
    import JetNavLink from '@/Jetstream/NavLink'
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink'
    import { Inertia } from '@inertiajs/inertia'
    import { usePage } from '@inertiajs/inertia-vue3'
    import { inject, onMounted, provide, reactive, ref, toRaw, watchEffect } from 'vue'
    import DEFAULT_SETTINGS, { nonEditorSettings } from '@/Config/settings'
    import useMedia from '@/Hooks/useMedia'
    import { updateTheme } from '@/Utils/theme'
    import isMobile from 'is-mobile'

    export default {
        components: {
            AppHeader,
            AppSettings,
            JetApplicationMark,
            JetBanner,
            JetDropdown,
            JetDropdownLink,
            JetNavLink,
            JetResponsiveNavLink,
        },
        setup(props, context) {
            const page = usePage()
            const state = inject('state')
            const editor = inject('editor')
            const isMd = inject('isMd')
            const showingNavigationDropdown = ref(false)
            const logout = () => Inertia.post(route('logout'))
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

            watchEffect(() => {
                if (isMd.value) state.activeTab = 'editor'
            })

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

            return {
                page,
                logout,
                showingNavigationDropdown,
                switchToTeam,
                updateSetting,
            }
        }
    }
</script>
