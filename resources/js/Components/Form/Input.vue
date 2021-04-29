<template>
    <label class="flex items-center px-4 pt-4 pb-2 bg-gray-100 border border-gray-100 rounded-md dark:border-gray-800 focus-within:border-gray-300 dark:focus-within:border-gray-600 dark:bg-gray-800 focus-within:bg-white dark:focus-within:bg-gray-900 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-white dark:focus-within:ring-offset-gray-900 focus-within:ring-primary-500">
        <span
            v-if="label"
            class="absolute inset-x-0 block px-4 font-semibold tracking-wide text-gray-500 uppercase transition-all duration-200 ease-in-out transform"
            :class="{
                'text-2xs -translate-y-4': modelValue || focused,
                'text-xs -translate-y-1': !modelValue && !focused,
            }"
        >
            {{ label }}
        </span>

        <slot
            :autocomplete="autocomplete"
            :autofocus="autofocus"
            :disabled="disabled"
            :focused="focused"
            :handleInput="handleInput"
            :readonly="readonly"
            :required="required"
            :inputRef="input"
            :value="modelValue"
        >
            <input
                :autocomplete="autocomplete"
                :autofocus="autofocus"
                class="block w-full mt-2 text-gray-900 bg-transparent dark:text-white focus:outline-none focus:ring-0"
                :disabled="disabled"
                :readonly="readonly"
                ref="input"
                :required="required"
                :type="type"
                :value="modelValue"
                @input="handleInput($event.target.value)"
                @focus="focused = true"
                @blur="focused = false"
            />
        </slot>
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
            type: {
                type: String,
                default: 'text',
            },
        },
        setup(props, { emit }) {
            const { modelValue } = toRefs(props)
            const focused = ref(false)
            const input = ref(null)
            const handleInput = (v) => emit('update:modelValue', v)
            const focus = () => input.value.focus()

            provide('handleInput', handleInput)
            provide('focused', focused)
            provide('modelValue', modelValue)

            return {
                focus,
                focused,
                handleInput,
                input,
            }
        },
    }
</script>
