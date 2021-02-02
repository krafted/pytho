<template>
    <l-app>
        <template #header-right-actions>
            <f-action-message
                :on="form.recentlySuccessful"
                class="mr-2 font-semibold"
                type="success"
            >
                {{ message }}
            </f-action-message>

            <button
                class="flex items-center justify-center p-2.5 text-gray-600 dark:text-gray-400 border border-white bg-white dark:bg-gray-900 dark:border-gray-900 rounded-md group hover:w-auto hover:bg-gray-200 dark:hover:bg-gray-1000 focus:bg-gray-200 dark:focus:bg-gray-1000 focus:border-gray-300 dark:focus:border-gray-600 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-900 dark:hover:text-gray-200 focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-200 dark:focus:ring-offset-gray-900 focus:ring-primary-500 focus:outline-none focus:w-auto"
                @click="create"
            >
                <span class="sr-only">Create</span>

                <span
                    v-if="!isMobile"
                    class="flex-shrink-0 hidden mr-2 text-sm group-hover:inline group-focus:inline"
                >
                    Create
                </span>

                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>

            <button
                class="flex items-center justify-center p-2.5 text-gray-600 dark:text-gray-400 border border-white bg-white dark:bg-gray-900 dark:border-gray-900 rounded-md group hover:w-auto hover:bg-gray-200 dark:hover:bg-gray-1000 focus:bg-gray-200 dark:focus:bg-gray-1000 focus:border-gray-300 dark:focus:border-gray-600 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-900 dark:hover:text-gray-200 focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-200 dark:focus:ring-offset-gray-900 focus:ring-primary-500 focus:outline-none focus:w-auto"
                :title="isMac ? '⌘ + ↩︎' : '⌃ + ↩︎'"
                @click="run"
            >
                <span class="sr-only">Run</span>

                <span
                    v-if="!isMobile"
                    class="flex-shrink-0 hidden mr-2 text-sm group-hover:inline group-focus:inline"
                >
                    Run
                </span>

                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>

            <x-save
                ref="saveRef"
                :is-creator="isCreator"
                :pen="pen"
                :slug="slug"
                @created="typeof navigator.clipboard !== 'undefined' ? message = 'Copied' : message = 'Created'"
                @saved="message = 'Saved'"
            />

            <x-details
                v-if="!isCreator && pen"
                :pen="pen"
            />
        </template>

        <div class="flex flex-col flex-1">
            <x-tab-bar  />

            <splitpanes
                class="mt-px overflow-hidden"
                :horizontal="preferences.layout === 'horizontal'"
            >
                <pane
                    v-if="activeTab === 'editor' || isMd"
                    class="flex flex-col w-full h-full overflow-hidden"
                    min-size="33.333"
                >
                    <div class="flex flex-1 mt-12.5">
                        <x-editor
                            :comments="comments"
                            :pen="pen"
                            @saved="save"
                        />
                    </div>
                </pane>

                <pane
                    v-if="activeTab === 'output' || isMd"
                    class="flex flex-col w-full h-full overflow-hidden"
                    min-size="33.333"
                >
                    <div class="relative flex flex-col flex-1">
                        <header
                            class="absolute inset-x-0 top-0 items-center hidden p-4 border-gray-100 dark:border-gray-800 pr-safe-right md:flex"
                            :class="{ 'border-b border-gray-100 dark:border-gray-800 z-30': preferences.layout === 'horizontal' }"
                        >
                            <h3
                                class="mt-px font-mono text-xs font-semibold tracking-wide text-gray-500 uppercase border-b-2 border-transparent select-none"
                                :class="{ 'ml-safe-left': preferences.layout === 'horizontal' }"
                            >
                                Output
                            </h3>
                        </header>

                        <div class="flex flex-1 mt-12.5">
                            <x-output />
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
    </l-app>
</template>

<script>
    import FActionMessage from '@/Components/Form/ActionMessage'
    import LApp from '@/Layouts/App'
    import XDetails from '@/Components/Details'
    import XEditor from '@/Components/Editor'
    import XOutput from '@/Components/Output'
    import XSave from '@/Components/Save'
    import XTabBar from '@/Components/TabBar'
    import useMedia from '@/Hooks/useMedia'
    import defaultContent from '@/Config/Content'
    import { loadEngine, runCode, setOptions } from '@/Utils/interpreter'
    import { Splitpanes, Pane } from 'splitpanes'
    import { computed, inject, nextTick, onMounted, onUnmounted, provide, ref, watch } from 'vue'
    import { useForm, usePage } from '@inertiajs/inertia-vue3'
    import { useHead } from '@vueuse/head'

    export default {
        props: {
            comments: {
                type: Object,
            },
            isCreator: {
                type: Boolean,
            },
            pen: {
                type: Object,
            },
            slug: {
                type: String,
            },
        },
        components: {
            FActionMessage,
            LApp,
            XDetails,
            XEditor,
            XOutput,
            XSave,
            XTabBar,
            Pane,
            Splitpanes,
        },
        setup(props) {
            const preferences = inject('preferences')
            const page = usePage()
            const form = useForm({
                'slug': props.isCreator ? props.pen?.slug || props.slug : props.slug,
                'title': props.pen?.title || 'Untitled',
                'content': props.pen?.content || defaultContent,
                'description': props.pen?.description,
                'visibility': props.pen?.visibility || 'public',
            })
            const activeTab = ref('editor')
            const editor = inject('editor')
            const output = ref('')
            const loading = ref(true)
            const dirty = ref(false)
            const error = ref(false)
            const isMac = inject('isMac')
            const isMd = useMedia('(min-width: 768px)')
            const isMobile = inject('isMobile')
            const showCanvas = ref(false)
            const saveRef = ref(null)
            const paneWidth = ref(null)
            const message = ref('')
            const closeCanvas = () => form.value.content.includes('exitonclick') && (showCanvas.value = false)
            const run = async () => {
                output.value = ''
                error.value = false

                if (['import turtle', 'from turtle import'].some(s => form.value.content.includes(s))) {
                    await loadEngine('skulpt')
                    showCanvas.value = true
                    await nextTick()
                    output.value = 'Re-run to view the output'
                    await runCode(form.value.content, { use: 'skulpt', canvas: 'canvas' })

                    return
                }

                showCanvas.value = false
                await runCode(form.value.content, { use: 'pyodide' })
            }
            const save = () => {
                const canSave = props.isCreator && props.pen

                if (canSave) saveRef.value.save()
                else saveRef.value.show = true
            }
            const create = () => {
                form.value.slug = props.slug
                form.value.title = 'Untitled'
                form.value.description = null
                form.value.content = `# Let's write some code`
                form.value.visibility = 'public'

                form.value.post(route('pen.store'), {
                    preserveState: false,
                    onSuccess: async () => {
                        const canCopy = typeof navigator.clipboard !== 'undefined'

                        if (canCopy) navigator.clipboard.writeText(`${page.props.value.appUrl}/${form.value.slug}`)

                        dirty.value = false
                        editor.value.execCommand('selectAll')
                    }
                })
            }

            useHead({ title: computed(() => props.pen ? `${props.pen?.title} — Py` : 'Py') })

            watch(isMd, async (value, oldValue) => {
                if (value !== oldValue && !loading.value) await run()
            })

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
                    storeStateBetweenRuns: false,
                    output: res => output.value += res,
                    error: err => (error.value = true, output.value += err.error?.message ?? err.error),
                })

                window.js_input = text => prompt(text || 'Input:')

                await runCode(`
                    from js import js_input
                    input = js_input
                    __builtins__.input = js_input
                `, { use: 'pyodide' })

                loading.value = false

                await run()
            })

            provide('pen', props.pen)
            provide('activeTab', activeTab)
            provide('form', form)
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
                preferences,
                page,
                form,
                activeTab,
                create,
                dirty,
                editor,
                error,
                isMac,
                isMd,
                isMobile,
                loading,
                message,
                paneWidth,
                run,
                saveRef,
                save,
                showCanvas,
                navigator,
            }
        },
    }
</script>
