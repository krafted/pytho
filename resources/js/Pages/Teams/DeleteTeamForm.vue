<template>
    <f-action-section>
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
            <x-modal
                :show="confirmingTeamDeletion"
                @close="confirmingTeamDeletion = false"
            >
                <template #icon>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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
                    <x-secondary-button @click.native="confirmingTeamDeletion = false">
                        Close
                    </x-secondary-button>

                    <x-danger-button @click.native="deleteTeam" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Delete Team
                    </x-danger-button>
                </template>
            </x-modal>
        </template>

        <template #actions>
            <x-danger-button @click.native="confirmTeamDeletion">
                Delete Team
            </x-danger-button>
        </template>
    </f-action-section>
</template>

<script>
    import FActionSection from '@/Components/Form/ActionSection'
    import XDangerButton from '@/Components/DangerButton'
    import XModal from '@/Components/Modal'
    import XSecondaryButton from '@/Components/SecondaryButton'
    import { ref } from 'vue'
    import { useForm } from '@inertiajs/inertia-vue3'

    export default {
        props: ['team'],
        components: {
            FActionSection,
            XDangerButton,
            XModal,
            XSecondaryButton,
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
