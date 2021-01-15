<template>
    <div v-if="hasErrors">
        <div class="font-medium text-red-600 dark:text-red-400">Whoops! Something went wrong.</div>

        <ul class="mt-2 text-sm text-red-600 dark:text-red-400">
            <li v-for="(error, key) in errors" :key="key">{{ error }}</li>
        </ul>
    </div>
</template>

<script>
    import { usePage } from '@inertiajs/inertia-vue3'
    import { computed } from 'vue'

    export default {
        setup() {
            const page = usePage()
            const errors = computed(() => page.props.value.errors)
            const hasErrors = computed(() => Object.keys(errors.value).length > 0)

            return {
                errors,
                hasErrors,
            }
        },
    }
</script>
