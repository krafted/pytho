<template>
    <header class="px-4 pt-safe-top">
        <div class="flex items-center justify-between py-1 pl-safe-left pr-safe-right">
            <h1>
                <a
                    class="flex items-center justify-center w-10 h-10 -ml-2 font-mono text-lg font-semibold text-gray-500 border border-transparent rounded-md select-none dark:text-gray-700 hover:bg-gray-200 dark:hover:bg-black focus:bg-gray-200 dark:focus:bg-black focus:border-gray-300 dark:focus:border-gray-800 hover:border-gray-300 dark:hover:border-gray-800 hover:text-gray-900 dark:hover:text-gray-400 focus:text-gray-900 dark:focus:text-gray-400 focus:outline-none"
                    href="/"
                >
                    Py
                </a>
            </h1>

            <div class="flex items-center justify-end -mr-2 space-x-2">
                <button
                    v-if="route().current('editor')"
                    class="flex items-center justify-center p-2.5 text-gray-500 dark:text-gray-700 border border-transparent rounded-md group hover:w-auto hover:bg-gray-200 dark:hover:bg-black focus:bg-gray-200 dark:focus:bg-black focus:border-gray-300 dark:focus:border-gray-800 hover:border-gray-300 dark:hover:border-gray-800 hover:text-gray-900 dark:hover:text-gray-400 focus:text-gray-900 dark:focus:text-gray-400 focus:outline-none focus:w-auto"
                    @click="run"
                >
                    <span
                        v-if="!isMobile"
                        class="flex-shrink-0 hidden mr-2 font-mono text-sm group-hover:inline group-focus:inline"
                        v-text="'Run'"
                    />

                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </button>

                <button
                    class="flex items-center justify-center p-2.5 text-gray-500 dark:text-gray-700 border border-transparent rounded-md group hover:w-auto hover:bg-gray-200 dark:hover:bg-black focus:bg-gray-200 dark:focus:bg-black focus:border-gray-300 dark:focus:border-gray-800 hover:border-gray-300 dark:hover:border-gray-800 hover:text-gray-900 dark:hover:text-gray-400 focus:text-gray-900 dark:focus:text-gray-400 focus:outline-none focus:w-auto"
                    @click="showSettings = true"
                >
                    <span class="sr-only">Settings</span>

                    <span
                        v-if="!isMobile"
                        class="flex-shrink-0 hidden mr-2 font-mono text-sm group-hover:inline group-focus:inline"
                        v-text="isMac ? '⌘,' : '^,'"
                    />

                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
            </div>
        </div>
    </header>
</template>

<script>
    import { inject } from 'vue'

    export default {
        setup() {
            const isMac = inject('isMac')
            const isMd = inject('isMd')
            const isMobile = inject('isMobile')
            const run = inject('run')
            const showSettings = inject('showSettings')

            return {
                isMac,
                isMd,
                isMobile,
                run,
                showSettings,
            }
        }
    }
</script>
