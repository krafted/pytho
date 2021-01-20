<template>
    <app-layout>
        <div class="w-full py-6 mx-auto sm:px-4 max-w-7xl">
            <h1 class="px-4 mt-6 text-4xl font-semibold leading-tight text-gray-900 sm:px-0 dark:text-gray-100">
                Create Team
            </h1>

            <form-section-border />

            <create-team-form />
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import CreateTeamForm from '@/Pages/Teams/CreateTeamForm'
    import FormSectionBorder from '@/Components/Form/SectionBorder'

    export default {
        components: {
            AppLayout,
            CreateTeamForm,
            FormSectionBorder,
        },
    }
</script>
