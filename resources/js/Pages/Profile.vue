<template>
    <l-app>
        <div class="w-full py-6 mx-auto mt-6 sm:px-4 max-w-7xl">
            <div class="pl-safe-left pr-safe-right">
                <div
                    class="flex items-center justify-between px-4 space-x-6  sm:px-0"
                >
                    <div class="flex items-center space-x-6">
                        <img
                            class="object-cover transform border-4 border-gray-100 rounded-full  w-28 h-28 dark:border-gray-800"
                            :src="`${profile.profile_photo_url}`"
                            :alt="profile.name"
                        />

                        <div>
                            <h1
                                class="text-4xl font-semibold leading-tight text-gray-900  dark:text-gray-100"
                            >
                                {{ profile.name }}
                            </h1>

                            <p
                                class="text-2xl font-medium leading-tight text-gray-500 "
                            >
                                <inertia-link
                                    class=" hover:underline focus:outline-none focus:ring-2 focus:ring-primary-500"
                                    :href="
                                        route('profile.show', { user: profile })
                                    "
                                    >@{{ profile.username }}</inertia-link
                                >
                            </p>
                        </div>
                    </div>

                    <x-button
                        v-if="profile.id === page.props.value.user?.id"
                        class="-right-2 sm:-right-3"
                        :href="route('settings.profile.show')"
                    >
                        <svg
                            class="
                                -mx-1.5
                                my-0.5
                                inline-block
                                w-5
                                h-5
                                sm:hidden
                            "
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                            />
                        </svg>

                        <span class="hidden sm:inline">Edit Profile</span>
                    </x-button>
                </div>
            </div>
        </div>

        <div class="w-full">
            <header
                class="sticky z-10 bg-white bg-opacity-75 border-b border-gray-100  dark:bg-gray-900 dark:bg-opacity-75 backdrop-filter-blur dark:border-gray-800"
                style="top: calc(3.125rem + env(safe-area-inset-top))"
            >
                <div class="w-full mx-auto sm:px-4 max-w-7xl">
                    <div
                        class="grid grid-cols-1 gap-6  pl-safe-left pr-safe-right md:grid-cols-3 lg:grid-cols-4"
                    >
                        <nav
                            class="flex items-center col-span-1 px-4 -mb-px space-x-4  md:col-span-2 lg:col-span-3 sm:px-0"
                        >
                            <template
                                v-for="(visibility, key) in {
                                    '': 'Public',
                                    unlisted: 'Unlisted',
                                    private: 'Private',
                                }"
                            >
                                <inertia-link
                                    v-if="
                                        key === '' ||
                                        profile.id === page.props.value.user?.id
                                    "
                                    :key="key"
                                    class="flex items-center py-4 border-b-2  focus:outline-none"
                                    :class="[
                                        route().current('profile.show', {
                                            visibility: key,
                                        })
                                            ? 'border-primary-500 text-gray-900 dark:text-gray-200'
                                            : 'border-transparent text-gray-500 hover:text-gray-600 dark:hover:text-gray-400 focus:text-gray-600 dark:focus:text-gray-400',
                                    ]"
                                    :href="
                                        route('profile.show', {
                                            user: profile,
                                            visibility: key,
                                        })
                                    "
                                >
                                    {{ visibility }}

                                    <span
                                        class="
                                            inline-block
                                            px-2.5
                                            py-0.5
                                            ml-3
                                            bg-gray-100
                                            dark:bg-gray-800
                                            rounded-full
                                            text-2xs
                                        "
                                    >
                                        {{ counts[key ? key : "public"] }}
                                    </span>
                                </inertia-link>
                            </template>
                        </nav>

                        <div class="hidden md:block">
                            <h3
                                class="flex items-center py-4 -mb-px text-gray-900 border-b-2 border-transparent  focus:outline-none dark:text-gray-200"
                            >
                                Recent Activity
                            </h3>
                        </div>
                    </div>
                </div>
            </header>

            <div class="w-full px-0 mx-auto sm:px-4 max-w-7xl">
                <div
                    class="grid grid-cols-1 gap-6  md:grid-cols-3 lg:grid-cols-4 pl-safe-left pr-safe-right"
                >
                    <section class="col-span-1 md:col-span-2 lg:col-span-3">
                        <div
                            v-if="pens.length"
                            class="grid grid-cols-1 divide-y divide-gray-100  dark:divide-gray-800 sm:gap-6 sm:mt-6 md:grid-cols-2 lg:grid-cols-3"
                        >
                            <inertia-link
                                v-for="pen in pens"
                                class="flex flex-col overflow-hidden transition ease-in-out transform bg-white  hover:bg-gray-100 dark:hover:bg-gray-800 focus:bg-gray-100 dark:focus:bg-gray-800 sm:focus:bg-white sm:dark:focus:bg-gray-900 sm:hover:bg-white sm:dark:hover:bg-gray-900 sm:border-gray-100 duration-250 sm:border sm:dark:border-gray-800 dark:bg-gray-900 sm:rounded-lg sm:hover:-translate-y-2 sm:focus:translate-y-0 sm:hover:shadow sm:focus:shadow focus:outline-none sm:focus:ring-2 sm:focus:ring-primary-500 sm:focus:ring-offset-2 sm:focus:ring-offset-white sm:dark:focus:ring-offset-gray-900"
                                :href="route('pen.show', pen)"
                                :key="pen.id"
                            >
                                <div class="p-4 sm:p-6">
                                    <h3
                                        class="text-2xl font-semibold text-gray-700  dark:text-gray-300"
                                    >
                                        {{ pen.title }}
                                    </h3>

                                    <p class="text-gray-500 line-clamp-4">
                                        {{ pen.description }}
                                    </p>
                                </div>

                                <footer
                                    class="flex items-center w-full p-4 mt-auto space-x-2  sm:bg-gray-100 sm:py-3 sm:px-6 sm:dark:bg-gray-800"
                                >
                                    <svg
                                        class="flex-shrink-0 w-5 h-5 text-gray-400  dark:text-gray-600"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        />
                                    </svg>

                                    <time class="flex-1 text-gray-500">{{
                                        pen.updated_at
                                    }}</time>
                                </footer>
                            </inertia-link>
                        </div>

                        <div
                            v-else
                            class="flex items-center justify-center py-16 space-x-3 "
                        >
                            <svg
                                class="w-16 h-16 text-gray-300  dark:text-gray-700"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
                                />
                            </svg>

                            <p
                                class="text-2xl font-medium text-left text-gray-500 "
                            >
                                Nothing to be<br />seen here.
                            </p>
                        </div>
                    </section>

                    <aside class="hidden col-span-1 md:block">
                        <div
                            v-if="activity.length"
                            class="pl-6 mx-6 mt-6 border-l border-gray-100  dark:border-gray-800 sm:ml-3 sm:mr-0"
                        >
                            <div
                                v-for="action in activity"
                                :key="action.id"
                                class="flex items-center py-3"
                            >
                                <span
                                    class="absolute inline-flex items-center justify-center w-8 h-8 bg-gray-200 border-4 border-white rounded-full  dark:bg-gray-700 dark:border-gray-900"
                                    style="left: -40px"
                                >
                                    <svg
                                        class="w-4 h-4 text-white  dark:text-gray-900"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            v-if="action.method === 'Updated'"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                                        />
                                        <path
                                            v-else
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                                        />
                                    </svg>
                                </span>

                                <p
                                    class="text-sm text-gray-600  dark:text-gray-400"
                                >
                                    {{ action.method }}

                                    {{ action.subject.visibility }}
                                    {{ action.type }}

                                    <inertia-link
                                        class="font-semibold text-gray-700  dark:text-gray-300 focus:outline-none hover:underline focus:ring-2 focus:ring-primary-500"
                                        :href="
                                            route(
                                                'pen.show',
                                                action.subject.slug
                                            )
                                        "
                                    >
                                        {{ action.subject.title }}
                                    </inertia-link>

                                    &mdash; <time>{{ action.at }}</time>
                                </p>
                            </div>
                        </div>

                        <div v-else class="py-16 mt-6">
                            <p
                                class="text-sm text-center text-gray-600  dark:text-gray-400"
                            >
                                No recent activity.
                            </p>
                        </div>
                    </aside>
                </div>
            </div>
        </div>

        <div class="block w-full mt-6 md:hidden">
            <header
                class="
                    sticky
                    z-10
                    top-12.5
                    bg-white
                    dark:bg-gray-900
                    bg-opacity-75
                    dark:bg-opacity-75
                    backdrop-filter-blur
                    px-4
                    border-b border-gray-100
                    dark:border-gray-800
                "
            >
                <h3
                    class="flex items-center py-4 -mb-px text-gray-900 border-b-2 border-transparent  focus:outline-none dark:text-gray-200"
                >
                    Recent Activity
                </h3>
            </header>

            <aside class="col-span-1">
                <div
                    v-if="activity.length"
                    class="pl-6 mx-6 mt-6 border-l border-gray-100  dark:border-gray-800"
                >
                    <div
                        v-for="action in activity"
                        :key="action.id"
                        class="flex items-center py-3"
                    >
                        <span
                            class="absolute inline-flex items-center justify-center w-8 h-8 bg-gray-200 border-4 border-white rounded-full  dark:bg-gray-700 dark:border-gray-900"
                            style="left: -40px"
                        >
                            <svg
                                class="w-4 h-4 text-white dark:text-gray-900"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    v-if="action.method === 'Updated'"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                                />
                                <path
                                    v-else
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                                />
                            </svg>
                        </span>

                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ action.method }}

                            {{ action.subject.visibility }} {{ action.type }}

                            <inertia-link
                                class="font-semibold text-gray-700  dark:text-gray-300 focus:outline-none hover:underline focus:ring-2 focus:ring-primary-500"
                                :href="route('pen.show', action.subject.slug)"
                            >
                                {{ action.subject.title }}
                            </inertia-link>

                            &mdash; <time>{{ action.at }}</time>
                        </p>
                    </div>
                </div>

                <div v-else class="py-16 mt-6">
                    <p
                        class="text-sm text-center text-gray-600  dark:text-gray-400"
                    >
                        No recent activity.
                    </p>
                </div>
            </aside>
        </div>
    </l-app>
</template>

<script>
import LApp from "@/Layouts/App";
import XButton from "@/Components/Button";
import FormSectionBorder from "@/Components/Form/SectionBorder";
import { usePage } from "@inertiajs/inertia-vue3";
import { useHead } from "@vueuse/head";
import { computed } from "vue";

export default {
    props: ["activity", "counts", "profile", "pens"],
    components: {
        LApp,
        XButton,
        FormSectionBorder,
    },
    setup(props) {
        const page = usePage();

        useHead({
            title: computed(() =>
                props.profile ? `${props.profile?.name} — Pytho` : "Pytho"
            ),
        });

        return { page };
    },
};
</script>
