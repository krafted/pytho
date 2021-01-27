<template>
    <app-layout>
        <div class="w-full py-6 mx-auto sm:px-4 max-w-7xl">
            <div class="mt-6 pl-safe-left pr-safe-right">
                <div class="flex items-center px-4 space-x-6 sm:items-start sm:space-x-0 sm:space-y-6 sm:flex-col sm:px-0">
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
                            <inertia-link class="hover:underline focus:outline-none focus:ring-2 focus:ring-primary-500" :href="route('profile.show', { user: profile })">@{{ profile.username }}</inertia-link>
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 mt-6 md:grid-cols-3 lg:grid-cols-4">
                    <section class="col-span-1 md:col-span-2 lg:col-span-3">
                        <header class="border-b border-gray-100 dark:border-gray-800">
                            <nav class="flex items-center px-4 -mb-px space-x-4 sm:px-0">
                                <template
                                    v-for="
                                        (visibility, key) in {
                                            '': 'Public',
                                            unlisted: 'Unlisted',
                                            private: 'Private'
                                        }
                                    "
                                >
                                    <inertia-link
                                        v-if="key === '' || profile.id === page.props.value.user?.id"
                                        :key="key"
                                        class="flex items-center py-4 border-b-2 focus:outline-none"
                                        :class="[
                                            route().current('profile.show', { visibility: key })
                                                ? 'border-primary-500 text-gray-900 dark:text-gray-200'
                                                : 'border-transparent text-gray-500 dark:text-gray-700 hover:text-gray-700 dark:hover:text-gray-400 focus:text-gray-700 dark:focus:text-gray-400'
                                        ]"
                                        :href="route('profile.show', { user: profile, visibility: key })"
                                    >
                                        {{ visibility }}

                                        <span class="inline-block px-2.5 py-0.5 ml-3 bg-gray-100 dark:bg-gray-800 rounded-full text-2xs">
                                            {{ counts[key ? key : 'public'] }}
                                        </span>
                                    </inertia-link>
                                </template>
                            </nav>
                        </header>

                        <div
                            v-if="pens.length"
                            class="grid grid-cols-1 gap-6 mt-6 md:grid-cols-2 lg:grid-cols-3"
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>

                            <p class="text-2xl font-medium text-left text-gray-500">
                                Nothing to be<br />seen here.
                            </p>
                        </div>
                    </section>

                    <aside class="col-span-1">
                        <header class="px-4 border-b border-gray-100 dark:border-gray-800 sm:px-0">
                            <h3 class="flex items-center py-4 -mb-px text-gray-900 border-b-2 border-transparent focus:outline-none dark:text-gray-200">
                                Recent Activity
                            </h3>
                        </header>

                        <div
                            v-if="activity.length"
                            class="pl-6 mx-4 mt-6 border-l border-gray-100 dark:border-gray-800 sm:mx-0"
                        >
                            <div
                                v-for="action in activity"
                                :key="action.id"
                                class="flex items-center py-3"
                            >
                                <span
                                    class="absolute inline-block w-4 h-4 bg-gray-200 border-4 border-white rounded-full dark:bg-gray-700 dark:border-gray-900"
                                    style="left: -32px"
                                />

                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ action.method }}
                                    
                                    <inertia-link
                                        class="font-semibold text-gray-700 dark:text-gray-300 focus:outline-none hover:underline focus:ring-2 focus:ring-primary-500"
                                        :href="route('pen.show', action.subject.slug)"
                                        :title="action.subject.title"
                                    >
                                        a {{ action.subject.visibility }} {{ action.type }}
                                    </inertia-link>

                                    &mdash; <time>{{ action.at }}</time>
                                </p>
                            </div>
                        </div>

                        <div
                            v-else
                            class="py-16 mt-6"
                        >
                            <p class="text-sm text-center text-gray-600 dark:text-gray-400">
                                No recent activity.
                            </p>
                        </div>
                    </aside>
                </div>
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
        props: ['activity', 'counts', 'profile', 'pens'],
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
