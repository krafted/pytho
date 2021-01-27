<template>
    <header class="fixed inset-x-0 top-0 z-30 px-4 bg-white bg-opacity-75 border-b border-gray-100 sm:px-0 pt-safe-top dark:border-gray-800 backdrop-filter-blur dark:bg-opacity-75 dark:bg-gray-900">
        <div class="sm:px-4" :class="{'max-w-7xl mx-auto': !route().current('pen.show')}">
            <div
                class="flex items-center justify-between w-full py-1 pl-safe-left pr-safe-right"
            >
                <div class="flex items-center -ml-2 space-x-2">
                    <app-logo class="text-lg w-10.5 h-10.5" />

                    <slot name="header-left-actions" />
                </div>

                <div class="flex items-center justify-end -mr-2 space-x-2">
                    <slot name="header-right-actions" />

                    <!-- Teams Dropdown -->
                    <app-dropdown
                        v-if="page.props.value.user && page.props.value.jetstream.hasTeamFeatures"
                        align="right"
                        width="48"
                    >
                        <template #trigger>
                            <button class="flex items-center justify-center p-2.5 text-gray-600 dark:text-gray-400 border border-white bg-white dark:bg-gray-900 dark:border-gray-900 rounded-md group hover:w-auto hover:bg-gray-200 dark:hover:bg-gray-1000 focus:bg-gray-200 dark:focus:bg-gray-1000 focus:border-gray-300 dark:focus:border-gray-600 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-900 dark:hover:text-gray-200 focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-200 dark:focus:ring-offset-gray-900 focus:ring-primary-500 focus:outline-none focus:w-auto">
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
                                <div class="block px-4 py-2 font-semibold tracking-wide text-gray-400 uppercase border-b border-gray-100 dark:border-gray-800 text-2xs">
                                    Manage Team
                                </div>

                                <app-dropdown-link :href="route('teams.show', page.props.value.user.current_team)">
                                    Team Settings
                                </app-dropdown-link>

                                <app-dropdown-link :href="route('teams.create')" v-if="page.props.value.jetstream.canCreateTeams">
                                    Create New Team
                                </app-dropdown-link>

                                <div class="block px-4 py-2 font-semibold tracking-wide text-gray-400 uppercase border-b border-gray-100 dark:border-gray-800 text-2xs">
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
                            <button class="flex items-center justify-center p-2.5 text-gray-600 dark:text-gray-400 border border-white bg-white dark:bg-gray-900 dark:border-gray-900 rounded-md group hover:w-auto hover:bg-gray-200 dark:hover:bg-gray-1000 focus:bg-gray-200 dark:focus:bg-gray-1000 focus:border-gray-300 dark:focus:border-gray-600 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-900 dark:hover:text-gray-200 focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-200 dark:focus:ring-offset-gray-900 focus:ring-primary-500 focus:outline-none focus:w-auto">
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
                            <template v-if="page.props.value.user">
                                <app-dropdown-link :href="route('profile.show', { user: page.props.value.user })">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <img
                                                class="object-cover w-8 h-8 border-2 border-gray-100 rounded-full dark:border-gray-800"
                                                :src="`${page.props.value.user.profile_photo_url}`"
                                                :alt="page.props.value.user.name"
                                            />

                                            <div class="flex flex-col justify-center leading-none text-left">
                                                <div class="text-sm font-semibold text-gray-800 dark:text-gray-300">{{ page.props.value.user.name }}</div>
                                            </div>
                                        </div>

                                        <svg class="w-3 h-3 ml-auto text-gray-500 justify-self-end" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </app-dropdown-link>
                                
                                <div class="border-t border-gray-100 dark:border-gray-800" />

                                <app-dropdown-link :href="route('settings.profile.show')">
                                    Account Settings
                                </app-dropdown-link>
                            </template>

                            <app-dropdown-link
                                as="button"
                                type="button"
                                @click="showPreferences = true"
                            >
                                <span class="inline-flex items-center justify-between w-full space-x-2">
                                    <span>Preferences</span>

                                    <span
                                        v-if="!isMobile"
                                        class="px-1.5 border border-gray-200 dark:border-gray-800 rounded text-2xs"
                                        v-text="isMac ? '⌘ + ,' : '⌃ + ,'"
                                    />
                                </span>

                                <app-preferences />
                            </app-dropdown-link>

                            <!-- Authentication -->
                            <template v-if="page.props.value.user">
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

                            <div class="px-3 py-2 -mb-1 space-x-1 text-xs text-center bg-gray-100 rounded-b dark:bg-gray-800">
                                <a target="_blank" :href="route('terms.show')" class="text-gray-400 focus:ring focus:outline-none focus:ring-primary-500 hover:underline">
                                    Terms
                                </a>

                                <a target="_blank" :href="route('privacy.show')" class="text-gray-400 focus:outline-none focus:ring focus:ring-primary-500 hover:underline">
                                    Privacy
                                </a>
                            </div>
                        </template>
                    </app-dropdown>
                </div>
            </div>
        </div>
    </header>
</template>

<script>
    import AppDropdown from '@/Components/Dropdown'
    import AppDropdownLink from '@/Components/DropdownLink'
    import AppLogo from '@/Components/Logo'
    import AppPreferences from '@/Components/Preferences'
    import { inject } from 'vue'
    import { usePage } from '@inertiajs/inertia-vue3'
    import { Inertia } from '@inertiajs/inertia'
    import hotkeys from 'hotkeys-js'

    export default {
        components: {
            AppDropdown,
            AppDropdownLink,
            AppLogo,
            AppPreferences,
        },
        setup() {
            const page = usePage()
            const isMac = inject('isMac')
            const isMd = inject('isMd')
            const isMobile = inject('isMobile')
            const showPreferences = inject('showPreferences')
            const logout = () => {
                Inertia.post(route('logout'), {}, { preserveState: false })
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
                showPreferences,
                logout,
                switchToTeam,
            }
        }
    }
</script>
