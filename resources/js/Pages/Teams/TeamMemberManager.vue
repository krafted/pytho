<template>
    <div>
        <div v-if="userPermissions.canAddTeamMembers">
            <f-section-border />

            <!-- Add Team Member -->
            <f-section @submitted="addTeamMember">
                <template #title>
                    Add Team Member
                </template>

                <template #description>
                    Add a new team member to your team, allowing them to collaborate with you.
                </template>

                <template #form>
                    <div class="col-span-6 space-y-1 sm:col-span-4">
                        <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
                            Please provide the email address of the person you would like to add to this team.
                        </div>
                    </div>

                    <!-- Member Email -->
                    <div class="col-span-6 space-y-1 sm:col-span-4">
                        <f-input
                            label="Email"
                            v-model="addTeamMemberForm.email"
                        />

                        <f-input-error :message="addTeamMemberForm.errors.email" />
                    </div>

                    <!-- Role -->
                    <div class="col-span-6 space-y-1 sm:col-span-4" v-if="availableRoles.length > 0">
                        <f-listbox
                            label="Role"
                            :options="availableRoles.map(role => ({
                                label: role.name,
                                value: role.key,
                                description: role.description
                            }))"
                            position="top"
                            v-model="addTeamMemberForm.role"
                        >
                            <template #option="{ option }">
                                <div class="text-left">
                                    <!-- Role Name -->
                                    <div class="flex items-center">
                                        <div class="text-sm font-semibold">
                                            {{ option.label }}
                                        </div>
                                    </div>

                                    <!-- Role Description -->
                                    <div class="mt-1 text-xs">
                                        {{ option.description }}
                                    </div>
                                </div>
                            </template>
                        </f-listbox>

                        <f-input-error :message="addTeamMemberForm.errors.role" />
                    </div>
                </template>

                <template #actions>
                    <f-action-message :on="addTeamMemberForm.recentlySuccessful" class="mr-3">
                        Added
                    </f-action-message>

                    <x-button :class="{ 'opacity-25': addTeamMemberForm.processing }" :disabled="addTeamMemberForm.processing">
                        Add
                    </x-button>
                </template>
            </f-section>
        </div>

        <div v-if="team.team_invitations.length > 0 && userPermissions.canAddTeamMembers">
            <f-section-border />

            <!-- Team Member Invitations -->
            <f-action-section class="mt-6 sm:mt-0">
                <template #title>
                    Pending Team Invitations
                </template>

                <template #description>
                    These people have been invited to your team and have been sent an invitation email. They may join the team by accepting the email invitation.
                </template>

                <!-- Pending Team Member Invitation List -->
                <template #content>
                    <div class="-m-6 divide-y divide-gray-100 dark:divide-gray-800">
                        <div class="flex items-center justify-between p-6" v-for="invitation in team.team_invitations" :key="invitation.id">
                            <div class="text-gray-600 dark:text-gray-400">{{ invitation.email }}</div>

                            <div class="flex items-center">
                                <!-- Cancel Team Invitation -->
                                <button
                                    v-if="userPermissions.canRemoveTeamMembers"
                                    class="text-sm font-semibold tracking-wide text-red-500 uppercase focus:outline-none focus:ring-2 focus:ring-red-500"
                                    @click="cancelTeamInvitation(invitation)"
                                >
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </f-action-section>
        </div>

        <div v-if="team.users.length > 0">
            <f-section-border />

            <!-- Manage Team Members -->
            <f-action-section class="mt-6 sm:mt-0">
                <template #title>
                    Team Members
                </template>

                <template #description>
                    All of the people that are part of this team.
                </template>

                <!-- Team Member List -->
                <template #content>
                    <div class="-m-6 divide-y divide-gray-100 dark:divide-gray-800">
                        <div class="flex items-center justify-between p-6" v-for="user in team.users" :key="user.id">
                            <div class="flex items-center">
                                <img
                                    class="object-cover w-12 h-12 rounded-full"
                                    :src="user.profile_photo_url"
                                    :alt="user.name"
                                />

                                <div class="ml-3 leading-tight text-gray-600 dark:text-gray-400">
                                    <div class="text-base font-medium text-gray-600 dark:text-gray-400">{{ user.name }}</div>
                                    <div class="text-sm text-gray-500">{{ user.email }}</div>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <!-- Manage Team Member Role -->
                                <button
                                    v-if="userPermissions.canAddTeamMembers && availableRoles.length"
                                    class="ml-3 text-sm font-semibold tracking-wide text-gray-500 uppercase focus:outline-none focus:ring-2 focus:ring-primary-500"
                                    @click="manageRole(user)"
                                >
                                    {{ displayableRole(user.membership.role) }}
                                </button>

                                <div
                                    v-else-if="availableRoles.length"
                                    class="ml-3 text-sm font-semibold tracking-wide text-gray-500 uppercase"
                                >
                                    {{ displayableRole(user.membership.role) }}
                                </div>

                                <!-- Leave Team -->
                                <button
                                    v-if="page.props.value.user.id === user.id"
                                    class="ml-3 text-sm font-semibold tracking-wide text-red-500 uppercase focus:outline-none focus:ring-2 focus:ring-red-500"
                                    @click="confirmLeavingTeam"
                                >
                                    Leave
                                </button>

                                <!-- Remove Team Member -->
                                <button
                                    v-if="userPermissions.canRemoveTeamMembers"
                                    class="ml-3 text-sm font-semibold tracking-wide text-red-500 uppercase focus:outline-none focus:ring-2 focus:ring-red-500"
                                    @click="confirmTeamMemberRemoval(user)"
                                >
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </f-action-section>
        </div>

        <!-- Role Management Modal -->
        <x-modal
            :show="currentlyManagingRole"
            @close="currentlyManagingRole = false"
        >
            <template #icon>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </template>

            <template #title>
                Manage Role
            </template>

            <template #content>
                <div v-if="managingRoleFor">
                    <div class="text-sm text-gray-500">
                        Update the role in this team for <span class="font-semibold">{{ managingRoleFor.name }}</span>
                    </div>

                    <f-listbox
                        class="mt-1"
                        label="Role"
                        :options="availableRoles.map(role => ({
                            label: role.name,
                            value: role.key,
                            description: role.description
                        }))"
                        v-model="updateRoleForm.role"
                    >
                        <template #option="{ option }">
                            <div>
                                <!-- Role Name -->
                                <div class="flex items-center">
                                    <div class="text-sm font-semibold">
                                        {{ option.label }}
                                    </div>
                                </div>

                                <!-- Role Description -->
                                <div class="mt-1 text-xs">
                                    {{ option.description }}
                                </div>
                            </div>
                        </template>
                    </f-listbox>

                    <f-input-error :message="updateRoleForm.errors.role" />
                </div>
            </template>

            <template #actions>
                <x-secondary-button @click.native="currentlyManagingRole = false">
                    Close
                </x-secondary-button>

                <x-button @click.native="updateRole" :class="{ 'opacity-25': updateRoleForm.processing }" :disabled="updateRoleForm.processing">
                    Save
                </x-button>
            </template>
        </x-modal>

        <!-- Leave Team Confirmation Modal -->
        <x-modal
            :show="confirmingLeavingTeam"
            @close="confirmingLeavingTeam = false"
        >
            <template #icon>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </template>

            <template #title>
                Leave Team
            </template>

            <template #content>
                <div class="text-sm text-gray-500">
                    Are you sure you would like to leave this team?
                </div>
            </template>

            <template #actions>
                <x-secondary-button @click.native="confirmingLeavingTeam = false">
                    Close
                </x-secondary-button>

                <x-danger-button @click.native="leaveTeam" :class="{ 'opacity-25': leaveTeamForm.processing }" :disabled="leaveTeamForm.processing">
                    Leave
                </x-danger-button>
            </template>
        </x-modal>

        <!-- Remove Team Member Confirmation Modal -->
        <x-modal
            :show="teamMemberBeingRemoved"
            @close="teamMemberBeingRemoved = null"
        >
            <template #icon>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6" />
            </template>

            <template #title>
                Remove Team Member
            </template>

            <template #content>
                <div class="text-sm text-gray-500">
                    Are you sure you would like to remove this person from the team?
                </div>
            </template>

            <template #actions>
                <x-secondary-button @click.native="teamMemberBeingRemoved = null">
                    Close
                </x-secondary-button>

                <x-danger-button @click.native="removeTeamMember" :class="{ 'opacity-25': removeTeamMemberForm.processing }" :disabled="removeTeamMemberForm.processing">
                    Remove
                </x-danger-button>
            </template>
        </x-modal>
    </div>
</template>

<script>
    import FActionMessage from '@/Components/Form/ActionMessage'
    import FActionSection from '@/Components/Form/ActionSection'
    import FInput from '@/Components/Form/Input'
    import FInputError from '@/Components/Form/InputError'
    import FListbox from '@/Components/Form/Listbox'
    import FSection from '@/Components/Form/Section'
    import FSectionBorder from '@/Components/Form/SectionBorder'
    import XButton from '@/Components/Button'
    import XDangerButton from '@/Components/DangerButton'
    import XModal from '@/Components/Modal'
    import XSecondaryButton from '@/Components/SecondaryButton'
    import { Inertia } from '@inertiajs/inertia'
    import { useForm, usePage } from '@inertiajs/inertia-vue3'
    import { ref } from 'vue'

    export default {
        props: ['team', 'availableRoles', 'userPermissions'],
        components: {
            FActionMessage,
            FActionSection,
            FInput,
            FInputError,
            FListbox,
            FSection,
            FSectionBorder,
            XButton,
            XDangerButton,
            XModal,
            XSecondaryButton,
        },
        setup(props) {
            const page = usePage()
            const addTeamMemberForm = useForm({ email: '', role: null })
            const updateRoleForm = useForm({ role: null })
            const leaveTeamForm = useForm()
            const removeTeamMemberForm = useForm()
            const currentlyManagingRole = ref(false)
            const managingRoleFor = ref(null)
            const confirmingLeavingTeam = ref(false)
            const teamMemberBeingRemoved = ref(null)
            const addTeamMember = () => {
                addTeamMemberForm.value.post(route('team-members.store', props.team), {
                    errorBag: 'addTeamMember',
                    preserveScroll: true,
                    onSuccess: () => addTeamMemberForm.value.reset(),
                })
            }
            const cancelTeamInvitation = invitation => {
                Inertia.delete(route('team-invitations.destroy', invitation), {
                    preserveScroll: true
                })
            }
            const manageRole = teamMember => {
                managingRoleFor.value = teamMember
                updateRoleForm.value.role = teamMember.membership.role
                currentlyManagingRole.value = true
            }
            const updateRole = () => {
                updateRoleForm.value.put(route('team-members.update', [props.team, managingRoleFor.value]), {
                    preserveScroll: true,
                    onSuccess: () => (currentlyManagingRole.value = false),
                })
            }
            const confirmLeavingTeam = () => confirmingLeavingTeam.value = true
            const leaveTeam = () => leaveTeamForm.value.delete(route('team-members.destroy', [props.team, page.props.value.user]))
            const confirmTeamMemberRemoval = teamMember => teamMemberBeingRemoved.value = teamMember
            const removeTeamMember = () => {
                removeTeamMemberForm.value.delete(route('team-members.destroy', [props.team, teamMemberBeingRemoved.value]), {
                    errorBag: 'removeTeamMember',
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => (teamMemberBeingRemoved.value = null),
                })
            }
            const displayableRole = role => props.availableRoles.find(r => r.key === role).name

            return {
                page,
                addTeamMember,
                addTeamMemberForm,
                cancelTeamInvitation,
                confirmLeavingTeam,
                confirmingLeavingTeam,
                confirmTeamMemberRemoval,
                currentlyManagingRole,
                displayableRole,
                leaveTeam,
                leaveTeamForm,
                manageRole,
                managingRoleFor,
                removeTeamMember,
                removeTeamMemberForm,
                teamMemberBeingRemoved,
                updateRole,
                updateRoleForm,
            }
        },
    }
</script>
