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
                default: 'text-gray-600 border-transparent dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-black focus:bg-gray-200 dark:focus:bg-black focus:border-gray-300 dark:focus:border-gray-600 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-900 dark:hover:text-gray-200 focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 dark:focus:ring-offset-gray-800 focus:ring-primary-500 focus:outline-none',
            },
            type: {
                type: String,
                default: 'submit',
            },
        }
    }
</script>
