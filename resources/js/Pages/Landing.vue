<template>
    <div class="bg-gray-100 dark:bg-gray-900">
        <header class="px-16 pt-safe-top">
            <div class="flex items-center justify-between w-full max-w-5xl py-16 mx-auto pl-safe-left pr-safe-right">
                <div class="flex items-center space-x-12">
                    <app-logo class="-ml-2 text-3xl -top-0.5 w-14 h-14" />

                    <button
                        v-if="route().has('learn')"
                        class="flex items-center space-x-2 font-semibold text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-primary-500"
                    >
                        <span>Learn</span>

                        <svg class="w-3 h-3 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </div>

                <div class="space-x-6">
                    <inertia-link
                        class="inline-flex font-semibold text-gray-700 hover:underline dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-primary-500"
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
                        <svg class="absolute right-0 w-full h-auto max-w-xs transform opacity-25 md:-scale-x-100 md:opacity-100 md:max-w-xl md:relative" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 731 900">
                            <linearGradient id="backgroundBracketGradient1" gradientUnits="userSpaceOnUse" x1="793.388" y1="-34.896" x2="546.709" y2="392.636" gradientTransform="translate(0 108)">
                                <stop class="text-gray-500" offset="0" stop-color="currentColor" />
                                <stop class="text-gray-500" offset="1" stop-color="currentColor" stop-opacity="0" />
                            </linearGradient>
                            <path d="M730.5 452.5c-12.7-7.4-21.9-7.6-27.6-.6-5.7 6.9-8.5 18.6-8.5 35.1v88.9c0 16.9-1.6 30.9-4.7 42-3.1 11.5-8.4 19.7-15.7 24.5-7.1 4.9-16.7 6.2-28.9 3.9-11.9-2.2-26.8-8.4-44.6-18.7l-8.5-4.9v-70l10.6 6.1c12.7 7.4 21.2 8.3 25.5 2.9 4.5-5.2 6.8-16.1 6.8-32.6v-78.3c0-20.4 2-36.5 6-48.4s11.9-19.4 23.8-22.8c-11.9-17.1-19.8-33.8-23.8-50.2-4-16.4-5.9-34.8-5.9-55.2v-78.3c0-16.5-2.3-29.9-6.8-40.4-4.2-10.3-12.7-19.1-25.5-26.5l-10.6-6.1v-70l8.5 4.9c17.8 10.3 32.7 21.2 44.6 32.8 12.2 11.7 21.8 24.2 28.9 37.3 7.4 13.3 12.6 27.5 15.7 42.6 3.1 14.7 4.7 30.6 4.7 47.4v88.9c0 16.5 2.8 31.5 8.5 44.9 5.7 13.5 14.9 23.9 27.6 31.2l-.1 69.6z" opacity=".07" fill="url(#backgroundBracketGradient1)" />
                            <linearGradient id="backgroundBracketGradient2" gradientUnits="userSpaceOnUse" x1="674.801" y1="-105.168" x2="428.165" y2="322.289" gradientTransform="translate(0 108)">
                                <stop class="text-gray-500" offset="0" stop-color="currentColor" />
                                <stop class="text-gray-500" offset="1" stop-color="currentColor" stop-opacity="0" />
                            </linearGradient>
                            <path d="M408 195c12.7 7.4 21.9 7.6 27.6.6 5.7-6.9 8.5-18.6 8.5-35.1V71.6c0-16.9 1.6-30.9 4.7-42 3.1-11.5 8.2-19.8 15.3-24.7 7.4-4.8 17-6.1 28.9-3.9 12.2 2.3 27.2 8.6 45 18.9l8.5 4.9v70l-10.6-6.1c-12.7-7.4-21.4-8.4-25.9-3.2-4.2 5.4-6.4 16.3-6.4 32.8v78.3c0 20.4-2 36.5-6 48.4-4 11.8-11.9 19.4-23.8 22.8 11.9 17.1 19.8 33.8 23.8 50.2 4 16.4 5.9 34.8 5.9 55.2v78.3c0 16.5 2.1 29.9 6.4 40.2 4.5 10.5 13.2 19.4 25.9 26.7l10.6 6.1v70l-8.5-4.9c-17.8-10.3-32.8-21.3-45-33-11.9-11.6-21.5-24-28.9-37.3-7.1-13.1-12.2-27.2-15.3-42.4-3.1-14.7-4.7-30.6-4.7-47.4v-88.9c0-16.5-2.8-31.5-8.5-44.9-5.7-13.5-14.9-23.9-27.6-31.2l.1-69.5z" opacity=".07" fill="url(#backgroundBracketGradient2)" />
                            <linearGradient id="foregroundBracketGradient1" gradientUnits="userSpaceOnUse" x1="753.388" y1="-4.896" x2="506.709" y2="422.636" gradientTransform="translate(0 108)">
                                <stop class="text-gray-500" offset="0" stop-color="currentColor" />
                                <stop class="text-gray-500" offset="1" stop-color="currentColor" stop-opacity="0" />
                            </linearGradient>
                            <path d="M690.5 482.5c-12.7-7.4-21.9-7.6-27.6-.6-5.7 6.9-8.5 18.6-8.5 35.1v88.9c0 16.9-1.6 30.9-4.7 42-3.1 11.5-8.4 19.7-15.7 24.5-7.1 4.9-16.7 6.2-28.9 3.9-11.9-2.2-26.8-8.4-44.6-18.7l-8.5-4.9v-70l10.6 6.1c12.7 7.4 21.2 8.3 25.5 2.9 4.5-5.2 6.8-16.1 6.8-32.6v-78.3c0-20.4 2-36.5 6-48.4s11.9-19.4 23.8-22.8c-11.9-17.1-19.8-33.8-23.8-50.2-4-16.4-5.9-34.8-5.9-55.2v-78.3c0-16.5-2.3-29.9-6.8-40.4-4.2-10.3-12.7-19.1-25.5-26.5l-10.6-6.1v-70l8.5 4.9c17.8 10.3 32.7 21.2 44.6 32.8 12.2 11.7 21.8 24.2 28.9 37.3 7.4 13.3 12.6 27.5 15.7 42.6 3.1 14.7 4.7 30.6 4.7 47.4v88.9c0 16.5 2.8 31.5 8.5 44.9 5.7 13.5 14.9 23.9 27.6 31.2l-.1 69.6z" opacity=".4" fill="url(#foregroundBracketGradient1)" />
                            <linearGradient id="foregroundBracketGradient2" gradientUnits="userSpaceOnUse" x1="634.801" y1="-75.168" x2="388.165" y2="352.289" gradientTransform="translate(0 108)">
                                <stop class="text-gray-500" offset="0" stop-color="currentColor" />
                                <stop class="text-gray-500" offset="1" stop-color="currentColor" stop-opacity="0" />
                            </linearGradient>
                            <path d="M368 225c12.7 7.4 21.9 7.6 27.6.6 5.7-6.9 8.5-18.6 8.5-35.1v-88.9c0-16.9 1.6-30.9 4.7-42 3.1-11.5 8.2-19.8 15.3-24.7 7.4-4.8 17-6.1 28.9-3.9 12.2 2.3 27.2 8.6 45 18.9l8.5 4.9v70l-10.6-6.1c-12.7-7.4-21.4-8.4-25.9-3.2-4.2 5.4-6.4 16.3-6.4 32.8v78.3c0 20.4-2 36.5-6 48.4-4 11.8-11.9 19.4-23.8 22.8 11.9 17.1 19.8 33.8 23.8 50.2 4 16.4 5.9 34.8 5.9 55.2v78.3c0 16.5 2.1 29.9 6.4 40.2 4.5 10.5 13.2 19.4 25.9 26.7l10.6 6.1v70l-8.5-4.9c-17.8-10.3-32.8-21.3-45-33-11.9-11.6-21.5-24-28.9-37.3-7.1-13.1-12.2-27.2-15.3-42.4-3.1-14.7-4.7-30.6-4.7-47.4v-88.9c0-16.5-2.8-31.5-8.5-44.9-5.7-13.5-14.9-23.9-27.6-31.2l.1-69.5z" opacity=".4" fill="url(#foregroundBracketGradient2)"/>
                            <linearGradient id="windowGradient1" gradientUnits="userSpaceOnUse" x1="320.029" y1="4.649" x2="156.761" y2="287.513" gradientTransform="translate(0 108)">
                                <stop class="text-gray-500" offset="0" stop-color="currentColor" />
                                <stop class="text-gray-500" offset="1" stop-color="currentColor" stop-opacity="0" />
                            </linearGradient>
                            <path d="M146 12.2l170.9 98.7-.1 409.3-170.9-98.7.1-409.3z" opacity=".15" fill="url(#windowGradient1)" />
                            <path class="text-primary-500" fill="currentColor" d="M113.9 75.1l135.9 78.5v37.7l-135.9-78.5V75.1z" />
                            <path class="text-gray-500 opacity-20" fill="currentColor" d="M167.1 238.7l130.6 75.4v58.6l-130.6-75.4v-58.6zM167 167.8l130.8 75.5v13.6L167 181.5v-13.7zM167 194.4l113.1 65.3v13.6L167 208v-13.6z" />
                            <linearGradient id="titleBarGradient1" gradientUnits="userSpaceOnUse" x1="204.656" y1="-94.971" x2="256.669" y2="52.506" gradientTransform="translate(0 108)">
                                <stop class="text-gray-500" offset="0" stop-color="currentColor" />
                                <stop class="text-gray-500" offset="1" stop-color="currentColor" stop-opacity="0" />
                            </linearGradient>
                            <path d="M146 12.2l170.9 98.7v54.9L146 67.1V12.2z" opacity=".2" fill="url(#titleBarGradient1)" />
                            <path class="text-gray-500 opacity-20" fill="currentColor" d="M188.7 64.6c0 8.3-4.9 12.2-10.9 8.8-6-3.5-10.8-13-10.8-21.3s4.9-12.2 10.9-8.8c5.9 3.5 10.8 13 10.8 21.3z" />
                            <linearGradient id="windowGradient2" gradientUnits="userSpaceOnUse" x1="530.029" y1="384.149" x2="366.761" y2="667.013" gradientTransform="translate(0 108)">
                                <stop class="text-gray-500" offset="0" stop-color="currentColor" />
                                <stop class="text-gray-500" offset="1" stop-color="currentColor" stop-opacity="0" />
                            </linearGradient>
                            <path d="M356 391.7l170.9 98.7-.1 409.3L355.9 801l.1-409.3z" opacity=".15" fill="url(#windowGradient2)" />
                            <path class="text-primary-500" fill="currentColor" d="M421.1 510.8L557 589.2v37.6l-136-78.4.1-37.6z" />
                            <path class="text-gray-500 opacity-20" fill="currentColor" d="M377.1 549.7l130.7 75.5v58.5l-130.7-75.5v-58.5zM376.9 633.3l130.8 75.5v13.6L376.9 647v-13.7zM376.9 657.9L490 723.2v13.6l-113.1-65.3v-13.6z"/>
                            <linearGradient id="titleBarGradient2" gradientUnits="userSpaceOnUse" x1="414.663" y1="284.549" x2="466.676" y2="432.026" gradientTransform="translate(0 108)">
                                <stop class="text-gray-500" offset="0" stop-color="currentColor" />
                                <stop class="text-gray-500" offset="1" stop-color="currentColor" stop-opacity="0" />
                            </linearGradient>
                            <path d="M356 391.7l170.9 98.7v54.9L356 446.6v-54.9z" opacity=".2" fill="url(#titleBarGradient2)" />
                            <path class="text-gray-500 opacity-20" fill="currentColor" d="M398.7 444.2c0 8.3-4.9 12.2-10.9 8.8-6-3.5-10.8-13-10.8-21.3s4.9-12.2 10.9-8.8c5.9 3.4 10.8 13 10.8 21.3z" />
                            <linearGradient id="commentGradient" gradientUnits="userSpaceOnUse" x1="261.566" y1="278.375" x2="107.915" y2="398.679" gradientTransform="translate(0 108)">
                                <stop class="text-gray-500" offset="0" stop-color="currentColor" />
                                <stop class="text-gray-500" offset="1" stop-color="currentColor" stop-opacity="0" />
                            </linearGradient>
                            <path d="M326.4 448.4L28.9 276.7l.1 155.1 271.3 156.6 26.3 38.9-.2-178.9z" opacity=".3" fill="url(#commentGradient)" />
                            <path class="text-gray-500 opacity-20" fill="currentColor" d="M249.9 442l-65.2-37.6V418l65.2 37.6V442zM249.9 469.3L88.5 376.1v13.6L250 482.9l-.1-13.6zM250 496.6L55.1 384.1v13.6L250 510.2v-13.6z" />
                            <path class="text-primary-500" fill="currentColor" d="M266 465.5c0 12.8 7.6 27.5 16.9 32.9s16.9-.6 16.9-13.4-7.6-27.5-16.9-32.9c-9.4-5.4-16.9.6-16.9 13.4z" />
                            <path class="text-gray-500 opacity-20" fill="currentColor" d="M58.3 167.8L18.9 145v-13.3l39.4 22.8c3.2 1.9 7.9 5.6 11.9 11.4 4.3 6.2 7.4 14 7.4 22.5 0 9.4-2.4 14.7-6.9 16.3-4.3 1.4-9.3-1-12.4-2.8l-16.2-9.4-.1-.1c-1.4-.8-3.6-1.6-5.3-1.1-1.4.4-3.1 1.9-3.1 7.1 0 5.2 1.6 8.4 3 10.3 1.7 2.4 3.9 4.1 5.3 4.8l.2.1 49.6 28.6v13.3L42.4 227c-3.4-1.8-8.3-5.5-12.5-11.4-4.6-6.5-7.8-14.7-7.8-23.9 0-9.1 3.2-13.8 7.7-15.1 4.2-1.2 9.1.6 12.5 2.6l16.1 9.3c2.3 1.3 4.1 1.9 5.2 1.5.9-.3 2.5-1.6 2.5-8.3 0-4.4-1.4-7.2-2.8-9.2-1.6-2.2-3.7-4-5-4.7z" />
                            <path class="text-primary-500" fill="currentColor" d="M30.6 146.4c0 11.4-6.7 16.7-14.9 12S.8 140.6.8 129.2s6.7-16.7 14.9-12c8.2 4.8 14.9 17.9 14.9 29.2zM109.6 256.4c0 11.4-6.7 16.7-14.9 12s-14.9-17.8-14.9-29.2 6.7-16.7 14.9-12c8.2 4.8 14.9 17.9 14.9 29.2z" />
                            <linearGradient id="plus" gradientUnits="userSpaceOnUse" x1="236.825" y1="535.146" x2="184.453" y2="576.451" gradientTransform="translate(0 108)">
                                <stop class="text-gray-500" offset="0" stop-color="currentColor" />
                                <stop class="text-gray-500" offset="1" stop-color="currentColor" stop-opacity="0" />
                            </linearGradient>
                            <path d="M215.9 604.1c6 3.5 10.8 11.8 10.8 18.8v30.5l20.2 11.6c6 3.5 10.8 11.8 10.8 18.8 0 6.9-4.9 9.7-10.8 6.3l-20.2-11.6V709c0 6.9-4.9 9.7-10.8 6.3-6-3.5-10.8-11.8-10.8-18.8V666l-20.2-11.6c-6-3.5-10.8-11.8-10.8-18.8 0-6.9 4.9-9.7 10.8-6.3l20.2 11.6v-30.5c0-7 4.8-9.8 10.8-6.3z" opacity=".2" fill="url(#plus)" />
                        </svg>

                        <div class="flex-shrink-0 md:ml-24 lg:ml-32">
                            <h1 class="text-2xl font-bold leading-snug text-gray-700 sm:text-3xl md:text-4xl lg:text-5xl dark:text-gray-300">
                                Write, review, and share
                                <br />
                                your Python code
                                <br />
                                <span class="text-primary-500">in the browser</span>
                            </h1>

                            <div class="flex items-center mt-16 space-x-6">
                                <inertia-link
                                    class="inline-flex px-4 py-3 font-semibold text-gray-700 transition ease-in-out transform bg-white rounded-md shadow focus:translate-y-0 hover:-translate-y-1 dark:bg-gray-1000 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-primary-500 hover:opacity-60 hover:shadow-md focus:opacity-100 duration-250"
                                    :href="route('register')"
                                >
                                    Get started for free
                                </inertia-link>

                                <inertia-link
                                    class="inline-flex font-semibold text-gray-700 hover:underline dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-primary-500"
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

        <div class="px-16 mt-40 bg-white dark:bg-gray-1000">
            <div class="absolute inset-x-0 py-10 transform skew-y-3 bg-white dark:bg-gray-1000 -top-10 md:-skew-y-3" />

            <div class="w-full max-w-5xl py-24 mx-auto md:py-40 pl-safe-left pr-safe-right">
                <h3 class="text-xl font-semibold text-gray-600 dark:text-gray-400">
                    What's so great about Py?
                </h3>
                <h2 class="mt-4 text-3xl font-bold text-gray-700 dark:text-gray-300">
                    A fast, cross-device, shareable, and annotatable Python editor
                </h2>

                <div class="grid justify-center grid-cols-1 gap-6 mt-16 md:grid-cols-2 lg:grid-cols-4">
                    <div class="flex items-start space-x-6 md:space-x-0 md:space-y-3 md:block">
                        <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 rounded-lg bg-primary-200 text-primary-700 dark:bg-primary-500 dark:text-primary-900">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                        </div>

                        <div>
                            <h3 class="my-2.5 text-xl font-semibold text-gray-700 dark:text-gray-300">Write</h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                Compose and run your Python 3 code with fast output in a split-pane, mobile-friendly layout.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-6 md:space-x-0 md:space-y-3 md:block">
                        <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 rounded-lg bg-primary-200 text-primary-700 dark:bg-primary-500 dark:text-primary-900">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                        </div>

                        <div>
                            <h3 class="my-2.5 text-xl font-semibold text-gray-700 dark:text-gray-300">Review</h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                Leave comments on pieces of code for your peers to or comment on your own code to keep track of it.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-6 md:space-x-0 md:space-y-3 md:block">
                        <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 rounded-lg bg-primary-200 text-primary-700 dark:bg-primary-500 dark:text-primary-900">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                            </svg>
                        </div>

                        <div>
                            <h3 class="my-2.5 text-xl font-semibold text-gray-700 dark:text-gray-300">Share</h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                Make your code private to keep it to yourself, or make it unlisted or public to share it with the world.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-6 md:space-x-0 md:space-y-3 md:block">
                        <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 rounded-lg bg-primary-200 text-primary-700 dark:bg-primary-500 dark:text-primary-900">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                            </svg>
                        </div>

                        <div>
                            <h3 class="my-2.5 text-xl font-semibold text-gray-700 dark:text-gray-300">More</h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                Enjoy other features, like editor preferences and your profile, with your recent activity and pens
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="absolute inset-x-0 py-10 transform skew-y-3 bg-white dark:bg-gray-1000 -bottom-10 md:-skew-y-3" />
        </div>

        <div class="px-16 pt-6 pb-24 mt-40">
            <div class="w-full max-w-5xl mx-auto">
                <div class="flex items-center justify-between">
                    <p class="font-medium text-gray-500">
                        &copy; <inertia-link class="hover:underline focus:ring-2 focus:outline-none focus:ring-primary-500" :href="route('pen.show')">Py</inertia-link>
                    </p>

                    <p class="space-x-3 font-medium text-right text-gray-500">
                        <inertia-link class="hover:underline focus:ring-2 focus:outline-none focus:ring-primary-500" :href="route('terms.show')">Terms</inertia-link>
                        <inertia-link class="hover:underline focus:ring-2 focus:outline-none focus:ring-primary-500" :href="route('privacy.show')">Privacy</inertia-link>
                    </p>
                </div>

                <p class="flex items-center justify-center mt-12 text-gray-500">
                    Made with&nbsp;
                    <svg class="flex-shrink-0 w-4 h-4 text-primary-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                    </svg>
                    &nbsp;by&nbsp;<a class="font-medium hover:underline focus:ring-2 focus:outline-none focus:ring-primary-500" href="https://krafted.dev" target="_blank" rel="noopener">Krafted</a>
                </p>
            </div>
        </div>

        <app-preferences />
    </div>
</template>

<script>
    import AppButton from '@/Components/Button'
    import AppLogo from '@/Components/Logo'
    import AppPreferences from '@/Components/Preferences'
    import { provide, ref } from 'vue'

    export default {
        props: ['appUrl', 'errorBags', 'errors', 'jetstream', 'socialstream', 'user'],
        components: {
            AppButton,
            AppLogo,
            AppPreferences,
        },
        setup() {
            const showPreferences = ref(false)

            provide('showPreferences', showPreferences)
        },
    }
</script>
