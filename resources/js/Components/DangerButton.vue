<template>
    <button
        :type="type"
        :class="['inline-flex justify-center items-center px-4 py-2 text-sm font-semibold tracking-wide border rounded-md uppercase', classes]"
    >
        <slot></slot>
    </button>
</template>

<script>
    export default {
        props: {
            classes: {
                type: String,
                default: 'text-white border-red-600 bg-red-600 hover:bg-red-700 focus:bg-red-700 hover:border-red-400 focus:border-red-400 focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 dark:focus:ring-offset-gray-800 focus:ring-red-600 focus:outline-none',
            },
            type: {
                type: String,
                default: 'button',
            },
        }
    }
</script>

