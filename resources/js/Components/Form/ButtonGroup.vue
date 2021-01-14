<template>
    <div class="px-4 pt-2 pb-2 bg-gray-100 border border-gray-100 rounded-md dark:border-gray-800 dark:bg-gray-800 focus-within:bg-white dark:focus-within:bg-gray-900 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-white dark:focus-within:ring-offset-gray-900 focus-within:ring-primary-500">
        <span
            class="block font-semibold tracking-wide text-gray-500 uppercase transition-all duration-200 ease-in-out transform text-2xs"
            v-text="label"
        />

        <div class="flex items-center w-full mt-1 overflow-hidden bg-gray-200 rounded-md dark:bg-gray-900">
            <button
                v-for="option in options"
                :key="option.value"
                class="inline-flex items-center justify-center flex-1 h-8 focus:outline-none"
                :class="[option.value === value ? 'bg-white dark:bg-black text-gray-900 dark:text-white' : 'text-gray-500 hover:bg-white dark:hover:bg-black hover:text-gray-900 dark:hover:text-white focus:bg-white dark:focus:bg-black focus:text-gray-900 dark:focus:text-white']"
                @click="handleInput(option.value)"
            >
                <template v-if="option.icon">
                    <span class="sr-only">{{ option.label }}</span>

                    <span v-html="option.icon" />
                </template>

                <template v-else>
                    <span>{{ option.label }}</span>
                </template>
            </button>
        </div>
    </div>
</template>

<script>
    import { provide, ref, toRefs } from 'vue'

    export default {
        emits: ['update:value'],
        props: ['label', 'options', 'value'],
        setup(props, { emit }) {
            const { value } = toRefs(props)
            const focused = ref(false)
            const handleInput = (value) => emit('update:value', value)

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
