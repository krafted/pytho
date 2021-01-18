<template>
    <input
        v-model="proxyChecked"
        :class="['rounded focus:ring focus:ring-primary-500 cursor-pointer', classes]"
        :value="value"
        type="checkbox"
    />
</template>

<script>
    import { computed } from 'vue'

    export default {
        emits: ["update:modelValue"],
        props: {
            classes: {
                type: String,
                default: 'bg-gray-100 border-gray-100 dark:bg-gray-800 dark:border-gray-800 focus:bg-gray-100 hover:bg-gray-100 dark:hover:bg-gray-800 hover:border-gray-100 dark:hover:border-gray-800 dark:focus:bg-gray-800 focus:ring-offset-white dark:focus:ring-offset-gray-800 focus:border-gray-200 dark:focus:border-gray-700'
            },
            modelValue: {
                type: [Array, Boolean],
                default: false,
            },
            value: {
                default: null,
            },
        },
        setup(props, { emit }) {
            const proxyChecked = computed({
                get: () => props.modelValue,
                set: val => emit('update:modelValue', val)
            })

            return { proxyChecked }
        },
    }
</script>

