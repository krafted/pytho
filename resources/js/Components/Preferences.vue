<template>
    <x-modal
        :show="show"
        @close="show = false"
    >
        <template #icon>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
        </template>

        <template #title>
            Preferences
        </template>

        <template #content>
            <div class="grid grid-cols-1 gap-3">
                <div class="grid grid-cols-2 gap-3">
                    <f-button-group
                        label="Layout"
                        :value="preferences.layout"
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
                        @update:value="updatePreference('layout', $event)"
                    />

                    <f-button-group
                        label="Theme"
                        :value="preferences.theme"
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
                        @update:value="updatePreference('theme', $event), updateTheme($event)"
                    />
                </div>

                <f-input
                    label="Font Size"
                    :model-value="preferences.fontSize.toString()"
                    @update:model-value="updatePreference('fontSize', $event)"
                >
                    <f-number-input
                        max="26"
                        min="10"
                        step="1"
                        increments
                    />
                </f-input>

                <f-input
                    label="Indent Size"
                    :model-value="preferences.indentUnit.toString()"
                    @update:model-value="updatePreference('indentUnit', $event)"
                >
                    <f-number-input
                        max="8"
                        min="1"
                        step="1"
                        increments
                    />
                </f-input>

                <f-listbox
                    v-if="!isMobile"
                    label="Keymap"
                    :model-value="preferences.keyMap"
                    :options="keyMapOptions"
                    position="top"
                    @update:model-value="updatePreference('keyMap', $event)"
                />

                <f-input
                    label="Line Height"
                    :model-value="preferences.lineHeight.toString()"
                    @update:model-value="updatePreference('lineHeight', $event)"
                >
                    <f-number-input
                        max="2.5"
                        min="0.75"
                        step="0.25"
                        type="float"
                        increments
                    />
                </f-input>
            </div>
        </template>

        <template #actions>
            <x-button
                type="button"
                @click="show = false"
            >
                Close
            </x-button>
        </template>
    </x-modal>
</template>

<script>
    import { inject, onMounted, onUnmounted } from 'vue'
    import { updateTheme } from '@/Utils/theme'
    import FButtonGroup from '@/Components/Form/ButtonGroup.vue'
    import FInput from '@/Components/Form/Input.vue'
    import FListbox from '@/Components/Form/Listbox.vue'
    import FNumberInput from '@/Components/Form/NumberInput.vue'
    import XButton from '@/Components/Button'
    import XModal from '@/Components/Modal'
    import hotkeys from 'hotkeys-js'

    export default {
        components: {
            FButtonGroup,
            FInput,
            FListbox,
            FNumberInput,
            XButton,
            XModal,
        },
        setup() {
            const preferences = inject('preferences')
            const isMac = inject('isMac')
            const isMobile = inject('isMobile')
            const keyMapOptions = [
                { value: 'default', label: 'Default' },
                { value: 'emacs', label: 'Emacs' },
                { value: 'sublime', label: 'Sublime Text' },
                { value: 'vim', label: 'Vim' },
            ]
            const show = inject('showPreferences')
            const updatePreference = inject('updatePreference')

            onMounted(() => {
                hotkeys(isMac.value ? 'cmd+,' : 'ctrl+,', (event) => {
                    show.value = true
                    event.preventDefault()
                })
            })
            onUnmounted(() => hotkeys.unbind(isMac.value ? 'cmd+,' : 'ctrl+,'))

            return {
                preferences,
                isMobile,
                keyMapOptions,
                show,
                updatePreference,
                updateTheme,
            }
        }
    }
</script>
