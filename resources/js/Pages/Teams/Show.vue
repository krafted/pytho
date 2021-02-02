<template>
    <l-app>
        <div class="w-full py-6 mx-auto sm:px-4 max-w-7xl">
            <h1 class="px-4 mt-6 text-4xl font-semibold leading-tight text-gray-900 sm:px-0 dark:text-gray-100">
                Team Settings
            </h1>

            <f-section-border />

            <update-team-name-form
                :team="team"
                :permissions="permissions"
            />

            <team-member-manager
                class="mt-6 sm:mt-0"
                :team="team"
                :available-roles="availableRoles"
                :user-permissions="permissions"
            />

            <template v-if="permissions.canDeleteTeam && !team.personal_team">
                <f-section-border />

                <delete-team-form class="mt-6 sm:mt-0" :team="team" />
            </template>
        </div>
    </l-app>
</template>

<script>
    import FSectionBorder from '@/Components/Form/SectionBorder'
    import DeleteTeamForm from '@/Pages/Teams/DeleteTeamForm'
    import LApp from '@/Layouts/App'
    import TeamMemberManager from '@/Pages/Teams/TeamMemberManager'
    import UpdateTeamNameForm from '@/Pages/Teams/UpdateTeamNameForm'

    export default {
        props: [
            'team',
            'availableRoles',
            'permissions',
        ],
        components: {
            DeleteTeamForm,
            FSectionBorder,
            LApp,
            TeamMemberManager,
            UpdateTeamNameForm,
        },
    }
</script>
