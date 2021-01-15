<template>
    <div class="flex flex-col items-center min-h-screen py-6 bg-white sm:justify-center sm:pt-0 dark:bg-gray-900">
        <div class="flex w-full px-4 sm:max-w-sm">
            <slot name="logo" />
        </div>

        <div class="w-full mt-2 overflow-hidden bg-white border border-gray-100 shadow-lg dark:border-gray-800 dark:bg-gray-900 sm:max-w-sm sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>

<script>
    import { onMounted } from 'vue'
    import { updateTheme } from '@/Utils/theme'

    export default {
        setup() {
            onMounted(() => {
                if (localStorage.settings) updateTheme(JSON.parse(localStorage.settings)?.theme)
            })
        }
    }
</script>
