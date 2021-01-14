<template>
    <input class="border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" ref="input">
</template>

<script>
    import { ref } from 'vue'

    export default {
        emits: ['update:modelValue'],
        props: ['modelValue'],
        setup() {
            const input = ref(null)
            const focus = () => input.value.focus()

            return { focus, input }
        },
    }
</script>

