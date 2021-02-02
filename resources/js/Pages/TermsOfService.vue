<template>
    <l-app>
        <div class="w-full max-w-2xl px-4 pt-6 pb-12 mx-auto">
            <h1 class="mt-6 text-4xl font-semibold leading-tight text-gray-900 dark:text-gray-100">
                Terms of Service
            </h1>

            <f-section-border />

            <div v-html="terms" class="w-full mt-6 prose sm:mt-0 dark:prose-dark" />
        </div>
    </l-app>
</template>

<script>
    import FSectionBorder from '@/Components/Form/SectionBorder'
    import LApp from '@/Layouts/App'
    import XLogo from '@/Components/Logo'
    import { useHead } from '@vueuse/head'

    export default {
        props: ['terms'],
        components: {
            FSectionBorder,
            LApp,
            XLogo,
        },
        setup() {
            useHead({ title: 'Terms of Service — Py' })
        },
    }
</script>
