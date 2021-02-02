<template>
    <l-app>
        <div class="w-full max-w-2xl px-4 pt-6 pb-12 mx-auto">
            <h1 class="mt-6 text-4xl font-semibold leading-tight text-gray-900 dark:text-gray-100">
                Privacy Policy
            </h1>

            <f-section-border />

            <div v-html="policy" class="w-full mt-6 prose sm:mt-0 dark:prose-dark" />
        </div>
    </l-app>
</template>

<script>
    import FSectionBorder from '@/Components/Form/SectionBorder'
    import LApp from '@/Layouts/App'
    import XLogo from '@/Components/Logo'
    import { useHead } from '@vueuse/head'

    export default {
        props: ['policy'],
        components: {
            FSectionBorder,
            LApp,
            XLogo,
        },
        setup() {
            useHead({ title: 'Privacy Policy — Py' })
        },
    }
</script>
