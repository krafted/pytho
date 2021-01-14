<template>
    <input type="checkbox" :value="value" v-model="proxyChecked"
           class="text-indigo-600 border-gray-300 rounded shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
</template>

<script>
    import { computed } from 'vue'

    export default {
        emits: ["update:modelValue"],
        props: {
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

