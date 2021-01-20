<template>
    <label class="flex items-center px-4 pt-4 pb-2 bg-gray-100 border border-gray-100 rounded-md dark:border-gray-800 focus-within:border-gray-200 dark:focus-within:border-gray-700 dark:bg-gray-800 focus-within:bg-white dark:focus-within:bg-gray-900 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-white dark:focus-within:ring-offset-gray-900 focus-within:ring-primary-500">
        <span
            v-if="label"
            class="absolute inset-x-0 block px-4 font-semibold tracking-wide text-gray-500 uppercase transition-all duration-200 ease-in-out transform top-4"
            :class="{
                'text-2xs -translate-y-1.5': modelValue || focused,
                'text-xs translate-y-1': !modelValue && !focused,
            }"
        >
            {{ label }}
        </span>

        <textarea
            :autocomplete="autocomplete"
            :autofocus="autofocus"
            class="block w-full pr-4 mt-2 text-gray-900 bg-transparent dark:text-white focus:outline-none focus:ring-0 min-h-6"
            :disabled="disabled"
            :readonly="readonly"
            ref="textarea"
            :required="required"
            :value="modelValue"
            @input="handleInput($event.target.value)"
            @focus="focused = true"
            @blur="focused = false"
        />
    </label>
</template>

<script>
    import { provide, ref, toRefs } from 'vue'

    export default {
        emits: ['update:modelValue'],
        props: {
            autocomplete: {
                type: String,
            },
            autofocus: {
                type: Boolean,
            },
            disabled: {
                type: Boolean,
            },
            label: {
                type: String,
            },
            modelValue: {
                type: String,
            },
            readonly: {
                type: Boolean,
            },
            required: {
                type: Boolean,
            },
        },
        setup(props, { emit }) {
            const { modelValue } = toRefs(props)
            const focused = ref(false)
            const textarea = ref(null)
            const handleInput = (v) => emit('update:modelValue', v)
            const focus = () => textarea.value.focus()

            provide('handleInput', handleInput)
            provide('focused', focused)
            provide('modelValue', modelValue)

            return {
                focus,
                focused,
                handleInput,
                textarea,
            }
        },
    }
</script>
