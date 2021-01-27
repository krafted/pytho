<template>
    <app-layout>
        <div class="w-full max-w-2xl px-4 pt-6 pb-12 mx-auto">
            <h1 class="mt-6 text-4xl font-semibold leading-tight text-gray-900 dark:text-gray-100">
                Terms of Service
            </h1>

            <form-section-border />

            <div v-html="terms" class="w-full mt-6 prose sm:mt-0 dark:prose-dark" />
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/App'
    import AppLogo from '@/Components/Logo'
    import FormSectionBorder from '@/Components/Form/SectionBorder'

    export default {
        props: ['terms'],
        components: {
            AppLayout,
            AppLogo,
            FormSectionBorder,
        },
    }
</script>
