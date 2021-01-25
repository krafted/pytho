<template>
    <header class="absolute z-10 flex items-center justify-between w-full px-4 border-b border-gray-100 dark:border-gray-800">
        <h3 class="hidden py-4 -mb-px font-mono text-xs font-semibold tracking-wide text-gray-500 uppercase border-t border-b-2 border-transparent select-none dark:text-gray-700 md:block pl-safe-left">Editor</h3>

        <div class="flex items-center justify-between w-full -mb-px space-x-4 border-transparent md:hidden pl-safe-left pr-safe-right">
            <div class="flex items-center mt-px space-x-4">
                <button
                    class="flex py-4 border-b-2 focus:outline-none"
                    :class="{
                        'border-primary-500 text-gray-900 dark:text-gray-200': !isMd && activeTab === 'editor',
                        'border-transparent text-gray-500 dark:text-gray-700 hover:text-gray-700 dark:hover:text-gray-400 focus:text-gray-700 dark:focus:text-gray-400': isMd || activeTab !== 'editor',
                    }"
                    @click="activeTab = 'editor'"
                >
                    <h3 class="font-mono text-xs font-semibold tracking-wide uppercase select-none">Editor</h3>
                </button>

                <button
                    v-if="!isMd"
                    class="flex py-4 border-b-2 focus:outline-none"
                    :class="{
                        'border-primary-500 text-gray-900 dark:text-gray-200': activeTab === 'output',
                        'border-transparent text-gray-500 dark:text-gray-700 hover:text-gray-700 dark:hover:text-gray-400 focus:text-gray-700 dark:focus:text-gray-400': activeTab !== 'output',
                    }"
                    @click="activeTab = 'output', run()"
                >
                    <h3 class="font-mono text-xs font-semibold tracking-wide uppercase select-none">Output</h3>
                </button>
            </div>
        </div>

        <h-switch-group
            as="div"
            title="Auto-Run"
        >
            <span class="sr-only">
                Auto-Run
            </span>

            <h-switch
                as="button"
                class="flex items-center justify-center p-2.5 -mt-px -mr-2 text-gray-500 border border-transparent rounded-md dark:text-gray-700 group hover:w-auto hover:bg-gray-200 dark:hover:bg-black focus:bg-gray-200 dark:focus:bg-black focus:border-gray-300 dark:focus:border-gray-800 hover:border-gray-300 dark:hover:border-gray-800 hover:text-gray-900 dark:hover:text-gray-400 focus:text-gray-900 dark:focus:text-gray-400 focus:outline-none focus:w-auto"
                :model-value="settings.autoRun"
                v-slot="{ checked }"
                @update:model-value="updateAutoRun"
            >
                <svg
                    class="w-5 h-5 transition-all duration-200 ease-in-out"
                    :class="settings.autoRun ? 'text-primary-500' : 'text-gray-500 dark:text-gray-700'"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </h-switch>
        </h-switch-group>
    </header>
</template>

<script>
    import { inject, watchEffect } from 'vue'
    import { SwitchGroup as HSwitchGroup, Switch as HSwitch } from '@headlessui/vue'

    export default {
        props: ['width'],
        components: {
            HSwitchGroup,
            HSwitch,
        },
        setup() {
            const settings = inject('settings')
            const updateSetting = inject('updateSetting')
            const editor = inject('editor')
            const activeTab = inject('activeTab')
            const error = inject('error')
            const isMd = inject('isMd')
            const run = inject('run')
            const updateAutoRun = (event) => {
                updateSetting('autoRun', event)
            }

            watchEffect(() => isMd.value && (activeTab.value = 'editor'))

            return {
                settings,
                activeTab,
                error,
                isMd,
                run,
                updateAutoRun,
            }
        }
    }
</script>
