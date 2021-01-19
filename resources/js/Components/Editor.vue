<template>
    <div
        ref="editorContainer"
        class="flex-1 ml-safe-left"
        :style="{
            fontSize: `${settings.fontSize}px`,
            lineHeight: `${settings.lineHeight}rem`,
        }"
    >
    </div>
</template>

<script>
    import { inject, onMounted, readonly, ref } from 'vue'
    import debounce from 'debounce'
    import CodeMirror from 'codemirror'

    import 'codemirror/mode/python/python'
    import 'codemirror/addon/selection/active-line'
    import 'codemirror/keymap/emacs'
    import 'codemirror/keymap/sublime'
    import 'codemirror/keymap/vim'

    export default {
        setup() {
            const settings = inject('settings')
            const editorContainer = ref(null)
            const editor = inject('editor')
            const content = inject('content')
            const isMac = inject('isMac')
            const isMobile = inject('isMobile')
            const showSettings = inject('showSettings')
            const run = inject('run')

            onMounted(() => {
                editor.value = CodeMirror(editorContainer.value, {
                    autofocus: true,
                    extraKeys: {
                        'Shift-Tab': 'indentLess',
                        [isMac.value ? 'Cmd-/' : 'Ctrl-/']: 'toggleComment',
                        [isMac.value ? 'Cmd-,' : 'Ctrl-,']: () => showSettings.value = true,
                        [isMac.value ? 'Cmd-Enter' : 'Ctrl-Enter']: run,
                        'Tab': editor => {
                            var spaces = Array(editor.getOption('indentUnit') + 1).join(' ')
                            editor.replaceSelection(spaces)
                        }
                    },
                    gutters: ["CodeMirror-linenumbers"],
                    indentUnit: parseInt(settings.value.indentUnit),
                    keyMap: isMobile.value ? 'default' : settings.value.keyMap,
                    lineNumbers: true,
                    lineWrapping: true,
                    mode: 'text/x-python',
                    styleActiveLine: true,
                    theme: 'custom',
                    value: content.value,
                })

                editor.value.on('change', debounce(e => {
                    content.value = e.getValue()
                    run()
                }))
            })

            return {
                settings,
                editor,
                editorContainer,
            }
        }
    }
</script>
