<template>
    <app-layout>
        <template #header-actions>
            <button
                class="flex items-center justify-center p-2.5 text-gray-500 dark:text-gray-700 border border-transparent rounded-md group hover:w-auto hover:bg-gray-200 dark:hover:bg-black focus:bg-gray-200 dark:focus:bg-black focus:border-gray-300 dark:focus:border-gray-800 hover:border-gray-300 dark:hover:border-gray-800 hover:text-gray-900 dark:hover:text-gray-400 focus:text-gray-900 dark:focus:text-gray-400 focus:outline-none focus:w-auto"
                @click="run"
            >
                <span class="sr-only">Run</span>

                <span
                    v-if="!isMobile"
                    class="flex-shrink-0 hidden mr-2 font-mono text-sm group-hover:inline group-focus:inline"
                    v-text="isMac ? '⌘ + ↩︎' : '⌃ + ↩︎'"
                />

                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>
        </template>

        <div class="flex flex-col flex-1">
            <app-tab-bar  />

            <splitpanes
                class="overflow-hidden"
                :horizontal="state.settings.layout === 'horizontal'"
            >
                <pane
                    v-if="activeTab === 'editor' || isMd"
                    class="flex flex-col w-full h-full overflow-hidden mt-10.5"
                    min-size="33.333"
                >
                    <div class="flex flex-1">
                        <app-editor />
                    </div>
                </pane>

                <pane
                    v-if="activeTab === 'output' || isMd"
                    class="flex flex-col w-full h-full overflow-hidden"
                    min-size="33.333"
                >
                    <div class="relative flex flex-col flex-1">
                        <header class="absolute inset-x-0 top-0 items-center hidden px-4 py-3 border-gray-100 dark:border-gray-800 pr-safe-right md:flex">
                            <h3
                                class="font-mono text-xs font-semibold tracking-wide text-gray-500 uppercase border-b-2 border-transparent select-none dark:text-gray-700"
                                :class="{ 'ml-safe-left': state.settings.layout === 'horizontal' }"
                            >
                                Output
                            </h3>

                            <transition
                                enter-active-class="duration-300 ease-out"
                                enter-from-class="opacity-0"
                                enter-to-class="opacity-100"
                            >
                                <span
                                    v-if="dirty || error"
                                    class="w-1 h-1 ml-2 transition-opacity rounded-full"
                                    :class="error ? 'bg-red-500' : 'bg-primary-500'"
                                />
                            </transition>
                        </header>

                        <div class="flex flex-1 mt-10.5">
                            <app-output />
                        </div>
                    </div>
                </pane>
            </splitpanes>
        </div>

        <transition
            enter-active-class="duration-300 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="duration-200 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <p
                v-if="loading"
                class="fixed text-gray-500 transition-opacity bottom-4 right-4 md:mr-safe-right md:mb-safe-bottom"
            >
                <span class="sr-only">Loading</span>

                <svg fill="none" viewBox="0 0 24 24" class="w-6 h-6 animate-spin">
                    <circle
                        class="opacity-25"
                        cx="12"
                        cy="12"
                        r="10"
                        stroke="currentColor"
                        stroke-width="4"
                    />
                    <path
                        class="opacity-75"
                        fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                    />
                </svg>
            </p>
        </transition>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import AppEditor from '@/Components/Editor'
    import AppOutput from '@/Components/Output'
    import AppTabBar from '@/Components/TabBar'
    import useMedia from '@/Hooks/useMedia'
    import defaultContent from '@/Config/Content'
    import { Splitpanes, Pane } from 'splitpanes'
    import { inject, nextTick, onMounted, onUnmounted, provide, reactive, ref, watchEffect } from 'vue'
    import { loadEngine, runCode, setOptions } from 'client-side-python-runner'

    export default {
        components: {
            AppLayout,
            AppEditor,
            AppOutput,
            AppTabBar,
            Splitpanes,
            Pane,
        },
        setup() {
            const state = inject('state')
            const activeTab = ref('editor')
            const content = ref(defaultContent)
            const output = ref('')
            const editor = ref(null)
            const loading = ref(true)
            const dirty = ref(false)
            const error = ref(false)
            const isMac = inject('isMac')
            const isMd = useMedia('(min-width: 768px)')
            const isMobile = inject('isMobile')
            const showCanvas = ref(false)
            const closeCanvas = () => content.value.includes('exitonclick') && (showCanvas.value = false)
            const run = async () => {
                output.value = ''
                error.value = false

                if (content.value.includes('import turtle')) {
                    await loadEngine('skulpt')
                    showCanvas.value = true
                    await nextTick()
                    Sk.TurtleGraphics
                        ? Sk.TurtleGraphics.target = 'canvas'
                        : Sk.TurtleGraphics = { target: 'canvas' }
                    Sk.misceval.asyncToPromise(() => Sk.importMainWithBody("<stdin>", false, content.value, true))
                    output.value = 'Re-run to view the output'
                    dirty.value = true

                    return
                }

                showCanvas.value = false
                await runCode(content.value, { use: 'pyodide' })
                dirty.value = true
            }

            watchEffect(() => isMd && (showCanvas.value = false))

            onMounted(() => {
                hotkeys(isMac.value ? 'cmd+enter' : 'ctrl+enter', async (event) => {
                    await run()
                    event.preventDefault()
                })
            })
            onUnmounted(() => hotkeys.unbind(isMac.value ? 'cmd+enter' : 'ctrl+enter'))

            onMounted(async () => {
                await loadEngine('pyodide')

                setOptions({
                    output: (result) => output.value += result,
                    error: (error) => output.value += error.error.message
                })

                loading.value = false

                run()
            })

            provide('activeTab', activeTab)
            provide('editor', editor)
            provide('content', content)
            provide('output', output)
            provide('loading', loading)
            provide('dirty', dirty)
            provide('error', error)
            provide('isMac', isMac)
            provide('isMd', isMd)
            provide('run', run)
            provide('showCanvas', showCanvas)
            provide('closeCanvas', closeCanvas)

            return {
                state,
                activeTab,
                dirty,
                editor,
                error,
                isMac,
                isMd,
                isMobile,
                loading,
                run,
                showCanvas,
            }
        },
    }
</script>
