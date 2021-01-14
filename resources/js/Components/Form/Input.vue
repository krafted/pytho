<template>
    <label class="flex items-center px-4 pt-4 pb-2 bg-gray-100 border border-gray-100 rounded-md dark:border-gray-800 dark:bg-gray-800 focus-within:bg-white dark:focus-within:bg-gray-900 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-white dark:focus-within:ring-offset-gray-900 focus-within:ring-primary-500">
        <span
            v-if="label"
            class="absolute inset-x-0 block px-4 font-semibold tracking-wide text-gray-500 uppercase transition-all duration-200 ease-in-out transform"
            :class="{
                'text-2xs -translate-y-4': value || focused,
                'text-xs -translate-y-1': !value && !focused,
            }"
        >
            {{ label }}
        </span>

        <slot
            :focused="focused"
            :handleInput="handleInput"
            :value="value"
        >
            <input
                class="block w-full text-gray-900 bg-transparent dark:text-white focus:outline-none focus:ring-0"
                type="text"
                :value="value"
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
        emits: ['update:value'],
        props: ['label', 'value'],
        setup(props, { emit }) {
            const { value } = toRefs(props)
            const focused = ref(false)
            const handleInput = (v) => emit('update:value', v)

            provide('handleInput', handleInput)
            provide('focused', focused)
            provide('value', value)

            return {
                focused,
                handleInput,
            }
        },
    }
</script>
