<template>
    <div class="bg-gray-100 dark:bg-gray-900">
        <header class="px-16 pt-safe-top">
            <div
                class="flex items-center justify-between w-full max-w-5xl py-16 mx-auto  md:grid md:grid-cols-3 md:gap-3 pl-safe-left pr-safe-right"
            >
                <div class="flex items-center space-x-12">
                    <x-logo class="-ml-2 text-3xl -top-0.5 px-3 h-14" />

                    <button
                        v-if="route().has('learn')"
                        class="flex items-center space-x-2 font-semibold text-gray-700  dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-primary-500"
                    >
                        <span>Learn</span>

                        <svg
                            class="w-3 h-3 text-gray-500"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 9l-7 7-7-7"
                            />
                        </svg>
                    </button>
                </div>

                <x-search
                    additional-classes="bg-white dark:bg-gray-800 border-white dark:border-gray-800 shadow"
                    placeholder="Search for anything"
                />

                <div class="flex items-center justify-end space-x-6">
                    <button
                        id="searchButton"
                        class="inline-flex font-semibold text-gray-700  md:hidden hover:underline dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-primary-500"
                        @click="showSearch = true"
                    >
                        Search
                    </button>

                    <inertia-link
                        class="inline-flex font-semibold text-gray-700  hover:underline dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-primary-500"
                        :href="route('login')"
                    >
                        Login
                    </inertia-link>
                </div>
            </div>
        </header>

        <div class="px-16 mt-16">
            <div class="w-full max-w-5xl mx-auto">
                <div class="pl-safe-left pr-safe-right">
                    <div class="flex items-center justify-between">
                        <x-landing-illustration />

                        <div class="flex-shrink-0 md:ml-24 lg:ml-32">
                            <h1
                                class="text-2xl font-bold leading-snug text-gray-700  sm:text-3xl md:text-4xl lg:text-5xl dark:text-gray-300"
                            >
                                Write, review, and share
                                <br />
                                your Python code
                                <br />
                                <span class="text-primary-500"
                                    >in the browser</span
                                >
                            </h1>

                            <div class="flex items-center mt-16 space-x-6">
                                <inertia-link
                                    class="inline-flex px-4 py-3 font-semibold text-gray-700 transition ease-in-out transform bg-white rounded-md shadow  focus:translate-y-0 hover:-translate-y-1 dark:bg-gray-1000 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-primary-500 hover:opacity-60 hover:shadow-md focus:opacity-100 duration-250"
                                    :href="route('register')"
                                >
                                    Get started for free
                                </inertia-link>

                                <inertia-link
                                    class="inline-flex font-semibold text-gray-700  hover:underline dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-primary-500"
                                    :href="`${route('pen.show')}/?try`"
                                    :preserve-state="false"
                                >
                                    Try it out
                                </inertia-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-16 mt-64 bg-white dark:bg-gray-1000">
            <div
                class="absolute inset-x-0 top-0 py-24 transform -translate-y-1/2 skew-y-3 bg-white  md:-skew-y-3 dark:bg-gray-1000"
            />

            <div
                class="w-full max-w-5xl py-24 mx-auto  md:py-40 pl-safe-left pr-safe-right"
            >
                <h3
                    class="text-xl font-semibold text-gray-600  dark:text-gray-400"
                >
                    What's so great about Pytho?
                </h3>
                <h2
                    class="mt-4 text-3xl font-bold text-gray-700  dark:text-gray-300"
                >
                    A fast, cross-device, shareable, and annotatable Python
                    editor
                </h2>

                <div
                    class="grid justify-center grid-cols-1 gap-6 mt-16  md:grid-cols-2 lg:grid-cols-4"
                >
                    <div
                        class="flex items-start space-x-6  md:space-x-0 md:space-y-3 md:block"
                    >
                        <div
                            class="flex items-center justify-center flex-shrink-0 w-12 h-12 rounded-lg  bg-primary-200 text-primary-700 dark:bg-primary-500 dark:text-primary-900"
                        >
                            <svg
                                class="w-6 h-6"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"
                                />
                            </svg>
                        </div>

                        <div>
                            <h3
                                class="
                                    my-2.5
                                    text-xl
                                    font-semibold
                                    text-gray-700
                                    dark:text-gray-300
                                "
                            >
                                Write
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                Compose and run your Python 3 code with fast
                                output in a split-pane, mobile-friendly layout.
                            </p>
                        </div>
                    </div>
                    <div
                        class="flex items-start space-x-6  md:space-x-0 md:space-y-3 md:block"
                    >
                        <div
                            class="flex items-center justify-center flex-shrink-0 w-12 h-12 rounded-lg  bg-primary-200 text-primary-700 dark:bg-primary-500 dark:text-primary-900"
                        >
                            <svg
                                class="w-6 h-6"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"
                                />
                            </svg>
                        </div>

                        <div>
                            <h3
                                class="
                                    my-2.5
                                    text-xl
                                    font-semibold
                                    text-gray-700
                                    dark:text-gray-300
                                "
                            >
                                Review
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                Leave comments on pieces of code for your peers
                                to or comment on your own code to keep track of
                                it.
                            </p>
                        </div>
                    </div>
                    <div
                        class="flex items-start space-x-6  md:space-x-0 md:space-y-3 md:block"
                    >
                        <div
                            class="flex items-center justify-center flex-shrink-0 w-12 h-12 rounded-lg  bg-primary-200 text-primary-700 dark:bg-primary-500 dark:text-primary-900"
                        >
                            <svg
                                class="w-6 h-6"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"
                                />
                            </svg>
                        </div>

                        <div>
                            <h3
                                class="
                                    my-2.5
                                    text-xl
                                    font-semibold
                                    text-gray-700
                                    dark:text-gray-300
                                "
                            >
                                Share
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                Make your code private to keep it to yourself,
                                or make it unlisted or public to share it with
                                the world.
                            </p>
                        </div>
                    </div>
                    <div
                        class="flex items-start space-x-6  md:space-x-0 md:space-y-3 md:block"
                    >
                        <div
                            class="flex items-center justify-center flex-shrink-0 w-12 h-12 rounded-lg  bg-primary-200 text-primary-700 dark:bg-primary-500 dark:text-primary-900"
                        >
                            <svg
                                class="w-6 h-6"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"
                                />
                            </svg>
                        </div>

                        <div>
                            <h3
                                class="
                                    my-2.5
                                    text-xl
                                    font-semibold
                                    text-gray-700
                                    dark:text-gray-300
                                "
                            >
                                More
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                Enjoy other features, like editor preferences
                                and your profile, with your recent activity and
                                pens
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="absolute inset-x-0 bottom-0 py-24 transform translate-y-1/2 skew-y-3 bg-white  md:-skew-y-3 dark:bg-gray-1000"
            />
        </div>

        <div class="px-16 pt-6 pb-24 mt-64">
            <div class="w-full max-w-5xl mx-auto pl-safe-left pr-safe-right">
                <div class="grid grid-cols-3 gap-3">
                    <p class="font-medium text-gray-500">
                        &copy;
                        <inertia-link
                            class=" hover:underline focus:ring-2 focus:outline-none focus:ring-primary-500"
                            :href="route('pen.show')"
                            >Pytho</inertia-link
                        >
                    </p>

                    <p
                        class="flex items-center justify-center invisible w-0 h-0 text-gray-500 opacity-0  md:visible md:opacity-100 md:w-auto md:h-auto"
                    >
                        Made with&nbsp;
                        <svg
                            class="flex-shrink-0 w-4 h-4  text-primary-500 animate-beat"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                clip-rule="evenodd"
                            />
                        </svg>
                        &nbsp;by&nbsp;<a
                            class="font-medium  hover:underline focus:ring-2 focus:outline-none focus:ring-primary-500"
                            href="https://krafted.dev"
                            target="_blank"
                            rel="noopener"
                            >Krafted</a
                        >
                    </p>

                    <p class="space-x-3 font-medium text-right text-gray-500">
                        <inertia-link
                            class=" hover:underline focus:ring-2 focus:outline-none focus:ring-primary-500"
                            :href="route('terms.show')"
                            >Terms</inertia-link
                        >
                        <inertia-link
                            class=" hover:underline focus:ring-2 focus:outline-none focus:ring-primary-500"
                            :href="route('privacy.show')"
                            >Privacy</inertia-link
                        >
                    </p>
                </div>

                <p
                    class="flex items-center justify-center mt-6 text-gray-500  md:hidden"
                >
                    Made with&nbsp;
                    <svg
                        class="flex-shrink-0 w-4 h-4  text-primary-500 animate-beat"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                            clip-rule="evenodd"
                        />
                    </svg>
                    &nbsp;by&nbsp;<a
                        class="font-medium  hover:underline focus:ring-2 focus:outline-none focus:ring-primary-500"
                        href="https://krafted.dev"
                        target="_blank"
                        rel="noopener"
                        >Krafted</a
                    >
                </p>
            </div>
        </div>

        <x-preferences />
    </div>
</template>

<script>
import XLandingIllustration from "@/Components/LandingIllustration";
import XLogo from "@/Components/Logo";
import XPreferences from "@/Components/Preferences";
import XSearch from "@/Components/Search";
import { provide, ref } from "vue";

export default {
    props: [
        "appUrl",
        "errorBags",
        "errors",
        "jetstream",
        "socialstream",
        "user",
    ],
    components: {
        XLandingIllustration,
        XLogo,
        XPreferences,
        XSearch,
    },
    setup() {
        const showPreferences = ref(false);
        const showSearch = ref(false);

        provide("showPreferences", showPreferences);
        provide("showSearch", showSearch);

        return { showSearch };
    },
};
</script>
