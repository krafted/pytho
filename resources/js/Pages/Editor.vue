<template>
    <app-layout>
        <div class="flex flex-col flex-1 border-t border-gray-100 dark:border-gray-800">
            <app-tab-bar  />

            <splitpanes
                class="overflow-hidden"
                :horizontal="state.settings.layout === 'horizontal'"
            >
                <pane
                    v-if="state.activeTab === 'editor' || isMd"
                    class="flex flex-col w-full h-full overflow-hidden mt-10.5"
                    min-size="33.333"
                >
                    <div class="flex flex-1">
                        <app-editor />
                    </div>
                </pane>

                <pane
                    v-if="state.activeTab === 'output' || isMd"
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
    import DEFAULT_SETTINGS from '@/Config/settings'
    import defaultContent from '@/Config/defaultContent'
    import { Splitpanes, Pane } from 'splitpanes'
    import { nextTick, onMounted, onUnmounted, provide, reactive, ref, watchEffect } from 'vue'
    import isMobile from 'is-mobile'
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
            const state = reactive({
                activeTab: 'editor',
                settings: DEFAULT_SETTINGS,
            })
            const content = ref(defaultContent)
            const output = ref('')
            const editor = ref(null)
            const loading = ref(true)
            const dirty = ref(false)
            const error = ref(false)
            const isMac = ref(navigator.userAgent.indexOf('Mac') !== -1)
            const isMd = useMedia('(min-width: 768px)')
            const showCanvas = ref(false)
            const showSettings = ref(false)
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

            provide('state', state)
            provide('editor', editor)
            provide('content', content)
            provide('output', output)
            provide('loading', loading)
            provide('dirty', dirty)
            provide('error', error)
            provide('isMac', isMac)
            provide('isMd', isMd)
            provide('isMobile', isMobile())
            provide('run', run)
            provide('showSettings', showSettings)
            provide('showCanvas', showCanvas)
            provide('closeCanvas', closeCanvas)

            return {
                editor,
                state,
                loading,
                dirty,
                error,
                isMd,
                showCanvas,
            }
        },
    }
</script>
