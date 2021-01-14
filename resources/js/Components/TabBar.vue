<template>
    <header class="absolute z-10 flex items-center justify-between w-full px-4 border-b border-gray-100 dark:border-gray-800 md:py-3">
        <h3 class="hidden -mb-px font-mono text-xs font-semibold tracking-wide text-gray-500 uppercase border-b-2 border-transparent select-none dark:text-gray-700 md:block pl-safe-left">Editor</h3>

        <div class="flex items-center justify-between w-full -mb-px space-x-4 border-transparent md:hidden pl-safe-left pr-safe-right">
            <div class="flex items-center space-x-4">
                <button
                    class="flex py-3 border-b-2 border-transparent focus:outline-none"
                    :class="{
                        'border-primary-500 text-gray-900 dark:text-gray-200': !isMd && state.activeTab === 'editor',
                        'border-transparent text-gray-500 dark:text-gray-700 hover:text-gray-700 dark:hover:text-gray-400 focus:text-gray-700 dark:focus:text-gray-400': isMd || state.activeTab !== 'editor',
                    }"
                    @click="state.activeTab = 'editor'"
                >
                    <h3 class="font-mono text-xs font-semibold tracking-wide uppercase select-none">Editor</h3>
                </button>

                <button
                    v-if="!isMd"
                    class="flex items-center py-3 border-b-2 focus:outline-none"
                    :class="{
                        'border-primary-500 text-gray-900 dark:text-gray-200': state.activeTab === 'output',
                        'border-transparent text-gray-500 dark:text-gray-700 hover:text-gray-700 dark:hover:text-gray-400 focus:text-gray-700 dark:focus:text-gray-400': state.activeTab !== 'output',
                    }"
                    @click="state.activeTab = 'output', run(), dirty = false"
                >
                    <h3 class="font-mono text-xs font-semibold tracking-wide uppercase select-none">Output</h3>

                    <transition
                        enter-active-class="duration-300 ease-out"
                        enter-from-class="opacity-0"
                        enter-to-class="opacity-100"
                    >
                        <span
                            v-if="dirty || error"
                            class="absolute w-1 h-1 transition-opacity rounded-full -right-3"
                            :class="error ? 'bg-red-500' : 'bg-primary-500'"
                        />
                    </transition>
                </button>
            </div>
        </div>
    </header>
</template>

<script>
    import { inject } from 'vue'

    export default {
        setup() {
            const state = inject('state')
            const dirty = inject('dirty')
            const error = inject('error')
            const isMd = inject('isMd')
            const run = inject('run')

            return {
                state,
                dirty,
                error,
                isMd,
                run,
            }
        }
    }
</script>
