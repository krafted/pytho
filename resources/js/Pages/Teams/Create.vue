<template>
    <l-app>
        <div class="w-full py-6 mx-auto sm:px-4 max-w-7xl">
            <h1 class="px-4 mt-6 text-4xl font-semibold leading-tight text-gray-900 sm:px-0 dark:text-gray-100">
                Create Team
            </h1>

            <f-section-border />

            <create-team-form />
        </div>
    </l-app>
</template>

<script>
    import CreateTeamForm from '@/Pages/Teams/CreateTeamForm'
    import FSectionBorder from '@/Components/Form/SectionBorder'
    import LApp from '@/Layouts/App'

    export default {
        components: {
            CreateTeamForm,
            FSectionBorder,
            LApp,
        },
    }
</script>
