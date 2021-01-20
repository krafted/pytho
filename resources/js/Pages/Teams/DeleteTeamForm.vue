<template>
    <form-action-section>
        <template #title>
            Delete Team
        </template>

        <template #description>
            Permanently delete this team.
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
                Once a team is deleted, all of its resources and data will be permanently deleted. Before deleting this team, please download any data or information regarding this team that you wish to retain.
            </div>

            <!-- Delete Team Confirmation Modal -->
            <app-modal
                :show="confirmingTeamDeletion"
                @close="confirmingTeamDeletion = false"
            >
                <template #icon>
                    <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-gray-100 rounded-full dark:bg-black sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="w-6 h-6 text-gray-600 dark:text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>
                </template>

                <template #title>
                    Delete Team
                </template>

                <template #content>
                    <div class="text-sm text-gray-500">
                        Are you sure you want to delete this team? Once a team is deleted, all of its resources and data will be permanently deleted.
                    </div>
                </template>

                <template #actions>
                    <app-secondary-button @click.native="confirmingTeamDeletion = false">
                        Nevermind
                    </app-secondary-button>

                    <app-danger-button @click.native="deleteTeam" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Delete Team
                    </app-danger-button>
                </template>
            </app-modal>
        </template>

        <template #actions>
            <app-danger-button @click.native="confirmTeamDeletion">
                Delete Team
            </app-danger-button>
        </template>
    </form-action-section>
</template>

<script>
    import AppDangerButton from '@/Components/DangerButton'
    import AppModal from '@/Components/Modal'
    import AppSecondaryButton from '@/Components/SecondaryButton'
    import FormActionSection from '@/Components/Form/ActionSection'
    import { ref } from 'vue'
    import { useForm } from '@inertiajs/inertia-vue3'

    export default {
        props: ['team'],
        components: {
            AppDangerButton,
            AppModal,
            AppSecondaryButton,
            FormActionSection,
        },
        setup(props) {
            const form = useForm()
            const confirmingTeamDeletion = ref(false)
            const deleting = ref(false)
            const confirmTeamDeletion = () => confirmingTeamDeletion.value = true
            const deleteTeam = () => {
                form.value.delete(route('teams.destroy', props.team), {
                    errorBag: 'deleteTeam',
                })
            }

            return {
                form,
                confirmTeamDeletion,
                confirmingTeamDeletion,
                deleting,
                deleteTeam,
            }
        },
    }
</script>
