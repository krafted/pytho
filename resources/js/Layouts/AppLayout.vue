<template>
    <div class="flex flex-col h-screen pt-12.5 mt-safe-top">
        <app-banner />

        <app-header>
            <template #header-actions><slot name="header-actions" /></template>
        </app-header>

        <slot />
    </div>
</template>

<script>
    import AppBanner from '@/Components/Banner'
    import AppHeader from '@/Components/Header'
    import { provide, ref } from 'vue'

    export default {
        components: {
            AppBanner,
            AppHeader,
        },
        setup(props, context) {
            provide('showSettings', ref(false))
        }
    }
</script>
