<template>
    <div
        ref="editorContainer"
        class="flex-1 ml-safe-left"
        :style="{
            fontSize: `${preferences.fontSize}px`,
            lineHeight: `${preferences.lineHeight}rem`,
        }"
    />

    <app-modal
        :show="showCommentForm"
        type="form"
        @close="showCommentForm = false"
        @submitted="saveComment"
    >
        <template #icon>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
        </template>

        <template #title>
            Leave a Reply
        </template>

        <template #content>
            <form-textarea
                label="Body"
                v-model="commentForm.body"
            />
            <form-input-error :message="commentForm.errors.text" />
        </template>

        <template #actions>
            <app-secondary-button
                type="button"
                @click="showCommentForm = false"
            >
                Close
            </app-secondary-button>

            <app-button
                :class="{ 'opacity-25': commentForm.processing }"
                :disabled="commentForm.processing"
            >
                Comment
            </app-button>
        </template>
    </app-modal>
</template>

<script>
    import { inject, onMounted, onUnmounted, ref } from 'vue'
    import { useForm } from '@inertiajs/inertia-vue3'
    import { createPopper } from '@popperjs/core'
    import debounce from 'debounce'
    import CodeMirror from 'codemirror'
    import AppButton from '@/Components/Button'
    import AppModal from '@/Components/Modal'
    import AppSecondaryButton from '@/Components/SecondaryButton'
    import FormInputError from '@/Components/Form/InputError'
    import FormTextarea from '@/Components/Form/Textarea'

    import 'codemirror/mode/python/python'
    import 'codemirror/addon/selection/active-line'
    import 'codemirror/addon/selection/mark-selection'
    import 'codemirror/keymap/emacs'
    import 'codemirror/keymap/sublime'
    import 'codemirror/keymap/vim'

    export default {
        emits: ['saved'],
        props: ['comments', 'pen'],
        components: {
            AppButton,
            AppModal,
            AppSecondaryButton,
            FormInputError,
            FormTextarea,
        },
        setup(props, { emit }) {
            const preferences = inject('preferences')
            const form = inject('form')
            const commentForm = useForm({
                body: '',
                properties: {
                    coords: [],
                },
            })
            const editorContainer = ref(null)
            const editor = inject('editor')
            const dirty = inject('dirty')
            const isMac = inject('isMac')
            const isMobile = inject('isMobile')
            const showCommentForm = ref(false)
            const showPreferences = inject('showPreferences')
            const run = inject('run')
            const showComment = () => {
                commentForm.value.properties.coords = [editor.value.getCursor(true), editor.value.getCursor(false)]
                showCommentForm.value = true
            }
            const showCommentList = list => {
                console.log(list)
            }
            const onCursorActivity = async (e) => {
                if (!props.pen) return
                if (!e.somethingSelected()) {
                    document.querySelectorAll('.comment-button').forEach(el => el.remove())
                    return
                }

                setTimeout(() => {
                    let parent = document.querySelector('.CodeMirror')
                    let selected = document.querySelector('.CodeMirror-selectedtext')
                    let button = document.querySelector('.comment-button')

                    if (!button) {
                        button = document.createElement('button')
                        button.onclick = showComment
                        button.innerHTML = `<svg class="w-5 h-5 text-gray-700 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" /></svg>`
                        button.className = 'comment-button uppercase tracking-wide shadow font-semibold text-sm rounded-md absolute z-10 p-2.5 bg-white dark:bg-gray-1000 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500'
                        parent.appendChild(button)
                    }

                    if (selected) createPopper(selected, button, { placement: 'top' })
                }, 0)
            }
            const saveComment = () => {
                if (!props.pen) return

                commentForm.value.post(route('pen.comments.store', props.pen), { preserveState: false })
            }

            onMounted(() => {
                editor.value = CodeMirror(editorContainer.value, {
                    autofocus: true,
                    extraKeys: {
                        'Shift-Tab': 'indentLess',
                        [isMac.value ? 'Cmd-/' : 'Ctrl-/']: 'toggleComment',
                        [isMac.value ? 'Cmd-,' : 'Ctrl-,']: () => showPreferences.value = true,
                        [isMac.value ? 'Cmd-S' : 'Ctrl-S']: () => emit('saved'),
                        [isMac.value ? 'Cmd-Enter' : 'Ctrl-Enter']: run,
                        'Tab': editor => {
                            var spaces = Array(editor.getOption('indentUnit') + 1).join(' ')
                            editor.replaceSelection(spaces)
                        }
                    },
                    gutters: ["CodeMirror-linenumbers"],
                    indentUnit: parseInt(preferences.value.indentUnit),
                    keyMap: isMobile.value ? 'default' : preferences.value.keyMap,
                    lineNumbers: true,
                    lineWrapping: true,
                    mode: 'text/x-python',
                    styleActiveLine: true,
                    styleSelectedText: true,
                    theme: 'custom',
                    value: form.value.content,
                })

                editor.value.on('change', debounce(async (e) => {
                    form.value.content = e.getValue()
                    dirty.value = true

                    if (preferences.value.autoRun) await run()
                }), 250)

                editor.value.on('cursorActivity', onCursorActivity)
            })

            onMounted(() => {
                if (!props.pen || !props.comments) return

                const lines = document.querySelectorAll('.CodeMirror-code > div')

                Object.entries(props.comments).forEach(line => {
                    const [n, list] = line
                    const button = document.createElement('button')
                    const div = document.createElement('div')
                    div.classList = 'z-10 absolute top-0 right-2 h-full flex items-center justify-center'
                    button.onclick = () => showCommentList(list)
                    button.classList= 'text-gray-400 dark:text-gray-600 hover:text-gray-600 dark:hover:text-gray-400'
                    button.innerHTML = `<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" /></svg>`
                    div.appendChild(button)
                    lines[parseInt(n) === 0 ? parseInt(n) : parseInt(n) - 1].appendChild(div)
                })
            })

            onUnmounted(() => document.querySelectorAll('.comment-button').forEach(el => el.remove()))

            return {
                commentForm,
                editor,
                editorContainer,
                preferences,
                saveComment,
                showCommentForm,
            }
        }
    }
</script>
