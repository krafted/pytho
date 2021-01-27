<template>
    <div class="flex flex-col h-screen pt-12.5 mt-safe-top">
        <app-header>
            <template #header-left-actions><slot name="header-left-actions" /></template>
            <template #header-right-actions><slot name="header-right-actions" /></template>
        </app-header>

        <slot />

        <app-banner />
    </div>
</template>

<script>
    import AppBanner from '@/Components/Banner'
    import AppHeader from '@/Components/Header'
    import { provide, ref } from 'vue'

    export default {
        props: ['appUrl', 'errorBags', 'errors', 'jetstream'],
        components: {
            AppBanner,
            AppHeader,
        },
        setup(props, context) {
            const showPreferences = ref(false)

            provide('showPreferences', showPreferences)
        }
    }
</script>
