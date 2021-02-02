<template>
    <div class="flex flex-col h-screen pt-12.5 mt-safe-top">
        <x-header>
            <template #header-left-actions><slot name="header-left-actions" /></template>
            <template #header-right-actions><slot name="header-right-actions" /></template>
        </x-header>

        <slot />

        <x-banner />
    </div>
</template>

<script>
    import XBanner from '@/Components/Banner'
    import XHeader from '@/Components/Header'
    import { provide, ref } from 'vue'

    export default {
        props: ['appUrl', 'errorBags', 'errors', 'jetstream', 'socialstream', 'user'],
        components: {
            XBanner,
            XHeader,
        },
        setup(props, context) {
            const showPreferences = ref(false)

            provide('showPreferences', showPreferences)
        }
    }
</script>
