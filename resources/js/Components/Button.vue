<template>
    <component
        :is="element"
        :class="['inline-flex justify-center appearance-none items-center px-4 py-2 text-sm font-semibold tracking-wide border rounded-md uppercase', classes]"
        :href="href"
        :type="type"
    >
        <slot />
    </component>
</template>

<script>
    import { computed } from 'vue'

    export default {
        props: {
            classes: {
                type: String,
                default: 'text-gray-600 bg-white border-white dark:text-gray-400 dark:border-gray-900 dark:bg-gray-900 hover:bg-gray-200 dark:hover:bg-gray-1000 focus:bg-gray-200 dark:focus:bg-gray-1000 focus:border-gray-300 dark:focus:border-gray-600 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-900 dark:hover:text-gray-200 focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 dark:focus:ring-offset-gray-800 focus:ring-primary-500 focus:outline-none',
            },
            href: {
                type: String,
            },
            type: {
                type: String,
                default: 'submit',
            },
        },
        setup(props) {
            const element = computed(() => props.href ? 'a' : 'button')

            return { element }
        }
    }
</script>
