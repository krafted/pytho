<template>
    <form-section @submitted="updateTeamName">
        <template #title>
            Team Name
        </template>

        <template #description>
            The team's name and owner information.
        </template>

        <template #form>
            <!-- Team Owner Information -->
            <div class="col-span-6 px-4 py-3 bg-gray-100 rounded-md dark:bg-gray-800 sm:col-span-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                    Team Owner
                </h3>

                <div class="flex items-center mt-2">
                    <img
                        class="object-cover w-12 h-12 rounded-full"
                        :src="team.owner.profile_photo_url"
                        :alt="team.owner.name"
                    />

                    <div class="ml-3 leading-tight">
                        <div class="text-base font-medium text-gray-600 dark:text-gray-400">{{ team.owner.name }}</div>
                        <div class="text-sm text-gray-500">{{ team.owner.email }}</div>
                    </div>
                </div>
            </div>

            <!-- Team Name -->
            <div class="col-span-6 space-y-1 sm:col-span-4">
                <form-input
                    label="Team Name"
                    :disabled="!permissions.canUpdateTeam"
                    v-model="form.name"
                />

                <form-input-error :message="form.errors.name" />
            </div>
        </template>

        <template #actions v-if="permissions.canUpdateTeam">
            <form-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved
            </form-action-message>

            <app-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </app-button>
        </template>
    </form-section>
</template>

<script>
    import AppButton from '@/Components/Button'
    import FormActionMessage from '@/Components/Form/ActionMessage'
    import FormInput from '@/Components/Form/Input'
    import FormInputError from '@/Components/Form/InputError'
    import FormSection from '@/Components/Form/Section'
    import { useForm } from '@inertiajs/inertia-vue3'

    export default {
        props: ['team', 'permissions'],
        components: {
            AppButton,
            FormActionMessage,
            FormInput,
            FormInputError,
            FormSection,
        },
        setup(props) {
            const form = useForm({ name: props.team.name })
            const updateTeamName = () => {
                form.value.put(route('teams.update', props.team), {
                    errorBag: 'updateTeamName',
                    preserveScroll: true,
                })
            }

            return {
                form,
                updateTeamName,
            }
        },
    }
</script>
