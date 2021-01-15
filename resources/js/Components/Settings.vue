<template>
    <app-modal>
        <template #icon>
            <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-gray-100 rounded-full dark:bg-black sm:mx-0 sm:h-10 sm:w-10">
                <svg class="w-6 h-6 text-gray-600 dark:text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
        </template>

        <template #title>
            Settings
        </template>

        <template #content>
            <div class="grid grid-cols-1 gap-3">
                <div class="grid grid-cols-2 gap-3">
                    <form-button-group
                        label="Layout"
                        :value="state.settings.layout"
                        :options="[
                            {
                                label: 'Vertical',
                                icon: `<svg class='w-5 h-5' fill='currentColor' stroke='currentColor' viewBox='0 0 24 24' stroke-width='1.5'><rect x='2.75' y='4.75' width='18.5' height='14.5' rx='1.25' fill='none' /><path d='M2.75 6c0-.69.56-1.25 1.25-1.25h7.25v14.5H4c-.69 0-1.25-.56-1.25-1.25V6z' /></svg>`,
                                value: 'vertical',
                            },
                            {
                                label: 'Horizontal',
                                icon: `<svg class='w-5 h-5' fill='currentColor' stroke='currentColor' viewBox='0 0 24 24' stroke-width='1.5'><rect x='21.25' y='19.25' width='18.5' height='14.5' rx='1.25' transform='rotate(-180 21.25 19.25)' fill='none' /><path d='M21.25 11.25H2.75V6c0-.69.56-1.25 1.25-1.25h16c.69 0 1.25.56 1.25 1.25v5.25z' /></svg>`,
                                value: 'horizontal',
                            }
                        ]"
                        @update:value="updateSetting('layout', $event, false)"
                    />

                    <form-button-group
                        label="Theme"
                        :value="state.settings.theme"
                        :options="[
                            {
                                label: 'Light',
                                icon: `<svg class='w-5 h-5' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z' /></svg>`,
                                value: 'light',
                            },
                            {
                                label: 'Dark',
                                icon: `<svg class='w-5 h-5' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z' /></svg>`,
                                value: 'dark',
                            }
                        ]"
                        @update:value="updateSetting('theme', $event, false), updateTheme($event)"
                    />
                </div>

                <form-input
                    label="Font Size"
                    :model-value="state.settings.fontSize.toString()"
                    @update:model-value="updateSetting('fontSize', $event)"
                >
                    <form-number-input
                        max="26"
                        min="10"
                        step="1"
                        increments
                    />
                </form-input>

                <form-input
                    label="Indent Size"
                    :model-value="state.settings.indentUnit.toString()"
                    @update:model-value="updateSetting('indentUnit', $event)"
                >
                    <form-number-input
                        max="8"
                        min="1"
                        step="1"
                        increments
                    />
                </form-input>

                <form-listbox
                    v-if="!isMobile"
                    label="Keymap"
                    :options="keyMapOptions"
                    :model-value="state.settings.keyMap"
                    @update:model-value="updateSetting('keyMap', $event)"
                />

                <form-input
                    label="Line Height"
                    :model-value="state.settings.lineHeight.toString()"
                    @update:model-value="updateSetting('lineHeight', $event)"
                >
                    <form-number-input
                        max="2.5"
                        min="0.75"
                        step="0.25"
                        type="float"
                        increments
                    />
                </form-input>
            </div>
        </template>

        <template #actions>
            <app-button
                type="button"
                class="w-full sm:w-auto"
                @click="show = false"
            >
                Close
            </app-button>
        </template>
    </app-modal>
</template>

<script>
    import { inject, onMounted, onUnmounted, provide, watchEffect } from 'vue'
    import { updateTheme } from '@/Utils/theme'
    import AppButton from '@/Components/Button'
    import AppModal from '@/Components/Modal'
    import FormButtonGroup from '@/Components/Form/ButtonGroup.vue'
    import FormInput from '@/Components/Form/Input.vue'
    import FormListbox from '@/Components/Form/Listbox.vue'
    import FormNumberInput from '@/Components/Form/NumberInput.vue'
    import hotkeys from 'hotkeys-js'

    export default {
        emits: ['update:setting'],
        components: {
            AppButton,
            AppModal,
            FormButtonGroup,
            FormInput,
            FormListbox,
            FormNumberInput,
        },
        setup(_, { emit }) {
            const state = inject('state')
            const isMac = inject('isMac')
            const isMobile = inject('isMobile')
            const keyMapOptions = [
                { value: 'default', label: 'Default' },
                { value: 'emacs', label: 'Emacs' },
                { value: 'sublime', label: 'Sublime Text' },
                { value: 'vim', label: 'Vim' },
            ]
            const show = inject('showSettings')
            const updateSetting = (key, value, editor = true) => emit('update:setting', { key, value, editor })

            watchEffect(() => show.value && document.activeElement.blur())

            onMounted(() => {
                hotkeys(isMac.value ? 'cmd+,' : 'ctrl+,', (event) => {
                    show.value = true
                    event.preventDefault()
                })
            })
            onUnmounted(() => hotkeys.unbind(isMac.value ? 'cmd+,' : 'ctrl+,'))

            provide('show', show)

            return {
                state,
                isMobile,
                keyMapOptions,
                show,
                updateSetting,
                updateTheme,
            }
        }
    }
</script>
