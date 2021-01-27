<template>
    <app-layout>
        <div class="w-full py-6 mt-6">
            <div class="w-full mx-auto max-w-7xl sm:px-4">
                <h1 class="px-4 text-4xl font-semibold leading-tight text-gray-900 sm:px-0 dark:text-gray-100">
                    Settings
                </h1>
            </div>

            <header
                class="sticky z-10 px-4 mt-6 bg-white bg-opacity-75 border-b border-gray-100 dark:bg-gray-900 dark:bg-opacity-75 backdrop-filter-blur sm:px-0 dark:border-gray-800"
                style="top: calc(3.125rem + env(safe-area-inset-top))"
            >
                <div class="pl-safe-left pr-safe-right">
                    <nav class="flex items-center w-full px-0 mx-auto -mb-px space-x-4 max-w-7xl sm:px-4">
                        <inertia-link
                            v-if="page.props.value.jetstream.canUpdateProfileInformation"
                            class="flex items-center py-4 border-b-2 focus:outline-none"
                            :class="[
                                route().current('settings.profile.show')
                                    ? 'border-primary-500 text-gray-900 dark:text-gray-200'
                                    : 'border-transparent text-gray-500 hover:text-gray-600 dark:hover:text-gray-400 focus:text-gray-600 dark:focus:text-gray-400'
                            ]"
                            :href="route('settings.profile.show')"
                        >
                            Profile
                        </inertia-link>

                        <inertia-link
                            class="flex items-center py-4 border-b-2 focus:outline-none"
                            :class="[
                                route().current('settings.security.show')
                                    ? 'border-primary-500 text-gray-900 dark:text-gray-200'
                                    : 'border-transparent text-gray-500 hover:text-gray-600 dark:hover:text-gray-400 focus:text-gray-600 dark:focus:text-gray-400'
                            ]"
                            :href="route('settings.security.show')"
                        >
                            Security
                        </inertia-link>

                        <inertia-link
                            v-if="page.props.value.socialstream.show"
                            class="flex items-center py-4 border-b-2 focus:outline-none"
                            :class="[
                                route().current('settings.social.show')
                                    ? 'border-primary-500 text-gray-900 dark:text-gray-200'
                                    : 'border-transparent text-gray-500 hover:text-gray-600 dark:hover:text-gray-400 focus:text-gray-600 dark:focus:text-gray-400'
                            ]"
                            :href="route('settings.social.show')"
                        >
                            Social
                        </inertia-link>

                        <inertia-link
                            v-if="page.props.value.socialstream.hasPassword"
                            class="flex items-center py-4 border-b-2 focus:outline-none"
                            :class="[
                                route().current('settings.advanced.show')
                                    ? 'border-primary-500 text-gray-900 dark:text-gray-200'
                                    : 'border-transparent text-gray-500 hover:text-gray-600 dark:hover:text-gray-400 focus:text-gray-600 dark:focus:text-gray-400'
                            ]"
                            :href="route('settings.advanced.show')"
                        >
                            Advanced
                        </inertia-link>
                    </nav>
                </div>
            </header>

            <div class="w-full mx-auto mt-6 sm:px-4 max-w-7xl">
                <div class="pl-safe-left pr-safe-right">
                    <slot />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/App'
    import { usePage } from '@inertiajs/inertia-vue3'

    export default {
        components: { AppLayout },
        setup() {
            const page = usePage()

            return { page }
        },
    }
</script>
