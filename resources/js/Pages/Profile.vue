<template>
    <app-layout>
        <div class="w-full py-6 mx-auto sm:px-4 max-w-7xl">
            <div class="flex items-center px-4 mt-6 space-x-6 sm:px-0">
                <img
                    class="object-cover transform border-4 border-gray-100 rounded-full w-28 h-28 dark:border-gray-800"
                    :src="`${profile.profile_photo_url}`"
                    :alt="profile.name"
                />

                <div>
                    <h1 class="text-4xl font-semibold leading-tight text-gray-900 dark:text-gray-100">
                        {{ profile.name }}
                    </h1>

                    <p class="text-2xl font-medium leading-tight text-gray-500">
                        <inertia-link class="hover:underline focus:outline-none focus:ring-2 focus:ring-primary-500" :href="route('profile.show', profile)">@{{ profile.username }}</inertia-link>
                    </p>
                </div>
            </div>

            <nav class="mt-12 border-b border-gray-100 dark:border-gray-800">
                <div class="flex items-center px-4 -mb-px space-x-4 sm:px-0">
                    <inertia-link
                        class="flex py-4 border-b-2 focus:outline-none"
                        :class="[
                            route().current('profile.show')
                                ? 'border-primary-500 text-gray-900 dark:text-gray-200'
                                : 'border-transparent text-gray-500 dark:text-gray-700 hover:text-gray-700 dark:hover:text-gray-400 focus:text-gray-700 dark:focus:text-gray-400'
                        ]"
                        :href="route('profile.show', profile)"
                    >
                        Public
                    </inertia-link>

                    <inertia-link
                        v-if="profile.id === page.props.value.user?.id"
                        class="flex py-4 border-b-2 focus:outline-none"
                        :class="[
                            route().current('profile.private.show')
                                ? 'border-primary-500 text-gray-900 dark:text-gray-200'
                                : 'border-transparent text-gray-500 dark:text-gray-700 hover:text-gray-700 dark:hover:text-gray-400 focus:text-gray-700 dark:focus:text-gray-400'
                        ]"
                        :href="route('profile.private.show', profile)"
                    >
                        Private
                    </inertia-link>
                </div>
            </nav>

            <div
                v-if="pens.length"
                class="grid grid-cols-1 gap-6 mt-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
            >
                <inertia-link
                    v-for="pen in pens"
                    class="flex flex-col overflow-hidden transition ease-in-out transform bg-white border-t border-b border-gray-100 duration-250 sm:border-r sm:border-l dark:border-gray-800 dark:bg-gray-900 sm:rounded-lg sm:hover:-translate-y-2 sm:focus:translate-y-0 sm:hover:shadow sm:focus:shadow focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-900"
                    :href="route('pen.show', pen)"
                    :key="pen.id"
                >
                    <div class="p-4 sm:p-6">
                        <h3 class="text-2xl font-semibold text-gray-700 dark:text-gray-300">
                            {{ pen.title }}
                        </h3>

                        <p class="text-gray-500 line-clamp-4">
                            {{ pen.description }}
                        </p>
                    </div>

                    <footer class="flex items-center p-4 mt-auto space-x-2 bg-gray-100 sm:py-3 sm:px-6 dark:bg-gray-800">
                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>

                        <time class="text-gray-500">{{ pen.updated_at }}</time>
                    </footer>
                </inertia-link>
            </div>

            <div v-else class="flex items-center justify-center py-16 space-x-3">
                <svg class="w-16 h-16 text-gray-300 dark:text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>

                <p class="text-2xl font-medium text-left text-gray-500">
                    Nothing to be<br />seen here.
                </p>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import FormSectionBorder from '@/Components/Form/SectionBorder'
    import { usePage } from '@inertiajs/inertia-vue3'
    import { useHead } from '@vueuse/head'
    import { computed } from 'vue'

    export default {
        props: ['profile', 'pens'],
        components: {
            AppLayout,
            FormSectionBorder,
        },
        setup(props) {
            const page = usePage()

            useHead({ title: computed(() => props.profile ? `${props.profile?.name} — Py` : 'Py') })

            return { page }
        },
    }
</script>
