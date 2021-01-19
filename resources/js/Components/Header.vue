<template>
    <header class="px-4 border-b border-gray-100 pt-safe-top dark:border-gray-800">
        <div class="flex items-center justify-between py-1 pl-safe-left pr-safe-right">
            <app-logo class="w-10 h-10 -ml-2 text-lg" />

            <div class="flex items-center justify-end -mr-2 space-x-2">
                <slot name="header-actions" />

                <!-- Teams Dropdown -->
                <app-dropdown
                    v-if="page.props.value.user && page.props.value.jetstream.hasTeamFeatures"
                    align="right"
                    width="48"
                >
                    <template #trigger>
                        <button class="flex items-center justify-center p-2.5 text-gray-500 dark:text-gray-700 border border-transparent rounded-md group hover:w-auto hover:bg-gray-200 dark:hover:bg-black focus:bg-gray-200 dark:focus:bg-black focus:border-gray-300 dark:focus:border-gray-800 hover:border-gray-300 dark:hover:border-gray-800 hover:text-gray-900 dark:hover:text-gray-400 focus:text-gray-900 dark:focus:text-gray-400 focus:outline-none focus:w-auto">
                            <span
                                v-if="!isMobile"
                                class="flex-shrink-0 hidden mr-2 text-sm group-hover:inline group-focus:inline"
                            >
                                Team
                            </span>

                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </button>
                    </template>

                    <template #content>
                        <template v-if="page.props.value.jetstream.hasTeamFeatures">
                            <div class="block px-4 py-2 font-semibold tracking-wide text-gray-400 uppercase text-2xs">
                                Manage Team
                            </div>

                            <app-dropdown-link :href="route('teams.show', page.props.value.user.current_team)">
                                Team Settings
                            </app-dropdown-link>

                            <app-dropdown-link :href="route('teams.create')" v-if="page.props.value.jetstream.canCreateTeams">
                                Create New Team
                            </app-dropdown-link>

                            <div class="border-t border-gray-100 dark:border-gray-800" />

                            <div class="block px-4 py-2 font-semibold tracking-wide text-gray-400 uppercase text-2xs">
                                Switch Teams
                            </div>

                            <template v-for="team in page.props.value.user.all_teams" :key="team.id">
                                <form @submit.prevent="switchToTeam(team)">
                                    <app-dropdown-link as="button">
                                        <div class="flex items-center justify-between">
                                            <div>{{ team.name }}</div>

                                            <svg
                                                v-if="team.id == page.props.value.user.current_team_id"
                                                class="w-4 h-4 ml-3"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                        </div>
                                    </app-dropdown-link>
                                </form>
                            </template>
                        </template>
                    </template>
                </app-dropdown>

                <app-dropdown
                    align="right"
                    width="48"
                >
                    <template #trigger>
                        <button class="flex items-center justify-center p-2.5 text-gray-500 dark:text-gray-700 border border-transparent rounded-md group hover:w-auto hover:bg-gray-200 dark:hover:bg-black focus:bg-gray-200 dark:focus:bg-black focus:border-gray-300 dark:focus:border-gray-800 hover:border-gray-300 dark:hover:border-gray-800 hover:text-gray-900 dark:hover:text-gray-400 focus:text-gray-900 dark:focus:text-gray-400 focus:outline-none focus:w-auto">
                            <span
                                v-if="!isMobile"
                                class="flex-shrink-0 hidden mr-2 text-sm group-hover:inline group-focus:inline"
                            >
                                Menu
                            </span>

                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </template>

                    <template #content>
                        <app-dropdown-link
                            as="button"
                            type="button"
                            @click="showSettings = true"
                        >
                            <span class="inline-flex items-center justify-between w-full space-x-2">
                                <span>Settings</span>

                                <span
                                    v-if="!isMobile"
                                    class="px-1.5 border border-gray-200 dark:border-gray-800 rounded text-2xs"
                                    v-text="isMac ? '⌘ + ,' : '⌃ + ,'"
                                />
                            </span>

                            <app-settings />
                        </app-dropdown-link>

                        <!-- Authentication -->
                        <template v-if="page.props.value.user">
                            <app-dropdown-link :href="route('profile.show')">
                                Profile
                            </app-dropdown-link>

                            <app-dropdown-link :href="route('api-tokens.index')" v-if="page.props.value.jetstream.hasApiFeatures">
                                API Tokens
                            </app-dropdown-link>

                            <div class="border-t border-gray-100 dark:border-gray-800" />

                            <form @submit.prevent="logout">
                                <app-dropdown-link as="button">
                                    Logout
                                </app-dropdown-link>
                            </form>
                        </template>

                        <template v-else>
                            <div class="border-t border-gray-100 dark:border-gray-800" />

                            <app-dropdown-link :href="route('login')">
                                Login
                            </app-dropdown-link>

                            <app-dropdown-link v-if="route().has('register')" :href="route('register')">
                                Register
                            </app-dropdown-link>
                        </template>
                    </template>
                </app-dropdown>
            </div>
        </div>
    </header>
</template>

<script>
    import AppDropdown from '@/Components/Dropdown'
    import AppDropdownLink from '@/Components/DropdownLink'
    import AppLogo from '@/Components/Logo'
    import AppSettings from '@/Components/Settings'
    import { inject } from 'vue'
    import { usePage } from '@inertiajs/inertia-vue3'
    import { Inertia } from '@inertiajs/inertia'
    import hotkeys from 'hotkeys-js'

    export default {
        components: {
            AppDropdown,
            AppDropdownLink,
            AppLogo,
            AppSettings,
        },
        setup() {
            const page = usePage()
            const isMac = inject('isMac')
            const isMd = inject('isMd')
            const isMobile = inject('isMobile')
            const showSettings = inject('showSettings')
            const logout = () => {
                Inertia.post(route('logout'))
            }
            const switchToTeam = (team) => {
                Inertia.put(route('current-team.update'), {
                    'team_id': team.id
                }, {
                    preserveState: false
                })
            }

            return {
                page,
                isMac,
                isMd,
                isMobile,
                showSettings,
                logout,
                switchToTeam,
            }
        }
    }
</script>
