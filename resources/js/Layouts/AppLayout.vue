<template>
    <div class="flex flex-col h-screen">
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
