<template>
    <div>
        <!-- Generate API Token -->
        <form-section @submitted="createApiToken">
            <template #title>
                Create API Token
            </template>

            <template #description>
                API tokens allow third-party services to authenticate with our application on your behalf.
            </template>

            <template #form>
                <!-- Token Name -->
                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="name" value="Name" />
                    <jet-input id="name" type="text" class="block w-full mt-1" v-model="createApiTokenForm.name" autofocus />
                    <form-input-error :message="createApiTokenForm.errors.name" class="mt-2" />
                </div>

                <!-- Token Permissions -->
                <div class="col-span-6" v-if="availablePermissions.length > 0">
                    <jet-label for="permissions" value="Permissions" />

                    <div class="grid grid-cols-1 gap-4 mt-2 md:grid-cols-2">
                        <div v-for="permission in availablePermissions" :key="permission">
                            <label class="flex items-center">
                                <app-checkbox :value="permission" v-model="createApiTokenForm.permissions"/>
                                <span class="ml-2 text-sm text-gray-600">{{ permission }}</span>
                            </label>
                        </div>
                    </div>
                </div>
            </template>

            <template #actions>
                <form-action-message :on="createApiTokenForm.recentlySuccessful" class="mr-3">
                    Created.
                </form-action-message>

                <app-button :class="{ 'opacity-25': createApiTokenForm.processing }" :disabled="createApiTokenForm.processing">
                    Create
                </app-button>
            </template>
        </form-section>

        <div v-if="tokens.length > 0">
            <form-section-border />

            <!-- Manage API Tokens -->
            <div class="mt-10 sm:mt-0">
                <form-action-section>
                    <template #title>
                        Manage API Tokens
                    </template>

                    <template #description>
                        You may delete any of your existing tokens if they are no longer needed.
                    </template>

                    <!-- API Token List -->
                    <template #content>
                        <div class="space-y-6">
                            <div class="flex items-center justify-between" v-for="token in tokens" :key="token.id">
                                <div>
                                    {{ token.name }}
                                </div>

                                <div class="flex items-center">
                                    <div class="text-sm text-gray-400" v-if="token.last_used_ago">
                                        Last used {{ token.last_used_ago }}
                                    </div>

                                    <button class="ml-6 text-sm text-gray-400 underline cursor-pointer"
                                        @click="manageApiTokenPermissions(token)"
                                        v-if="availablePermissions.length > 0"
                                    >
                                        Permissions
                                    </button>

                                    <button class="ml-6 text-sm text-red-500 cursor-pointer" @click="confirmApiTokenDeletion(token)">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </form-action-section>
            </div>
        </div>

        <!-- Token Value Modal -->
        <jet-dialog-modal :show="displayingToken" @close="displayingToken = false">
            <template #title>
                API Token
            </template>

            <template #content>
                <div>
                    Please copy your new API token. For your security, it won't be shown again.
                </div>

                <div class="px-4 py-2 mt-4 font-mono text-sm text-gray-500 bg-gray-100 rounded" v-if="page.props.value.jetstream.flash.token">
                    {{ page.props.value.jetstream.flash.token }}
                </div>
            </template>

            <template #footer>
                <jet-secondary-button @click.native="displayingToken = false">
                    Close
                </jet-secondary-button>
            </template>
        </jet-dialog-modal>

        <!-- API Token Permissions Modal -->
        <app-modal :show="managingPermissionsFor" @close="managingPermissionsFor = null">
            <template #title>
                API Token Permissions
            </template>

            <template #content>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div v-for="permission in availablePermissions" :key="permission">
                        <label class="flex items-center">
                            <form-checkbox
                                :value="permission"
                                v-model="updateApiTokenForm.permissions"
                            />
                            <span class="ml-2 text-sm text-gray-600">{{ permission }}</span>
                        </label>
                    </div>
                </div>
            </template>

            <template #actions>
                <jet-secondary-button @click.native="managingPermissionsFor = null">
                    Nevermind
                </jet-secondary-button>

                <app-button class="ml-2" @click.native="updateApiToken" :class="{ 'opacity-25': updateApiTokenForm.processing }" :disabled="updateApiTokenForm.processing">
                    Save
                </app-button>
            </template>
        </app-modal>

        <!-- Delete Token Confirmation Modal -->
        <app-modal :show="apiTokenBeingDeleted" @close="apiTokenBeingDeleted = null">
            <template #title>
                Delete API Token
            </template>

            <template #content>
                Are you sure you would like to delete this API token?
            </template>

            <template #actions>
                <app-secondary-button @click.native="apiTokenBeingDeleted = null">
                    Nevermind
                </app-secondary-button>

                <app-danger-button class="ml-2" @click.native="deleteApiToken" :class="{ 'opacity-25': deleteApiTokenForm.processing }" :disabled="deleteApiTokenForm.processing">
                    Delete
                </app-danger-button>
            </template>
        </app-modal>
    </div>
</template>

<script>
    import AppButton from '@/Components/Button'
    import AppDangerButton from '@/Components/DangerButton'
    import AppSecondaryButton from '@/Components/SecondaryButton'
    import AppModal from '@/Components/Modal'
    import FormCheckbox from '@/Components/Form/Checkbox'
    import FormActionMessage from '@/Components/Form/ActionMessage'
    import FormInputError from '@/Components/Form/InputError'
    import FormSection from '@/Components/Form/Section'
    import FormSectionBorder from '@/Components/Form/SectionBorder'
    import JetInput from '@/Jetstream/Input'
    import { inject, ref } from 'vue'
    import { useForm, usePage } from '@inertiajs/inertia-vue3'

    export default {
        components: {
            AppButton,
            AppDangerButton,
            AppSecondaryButton,
            AppModal,
            FormActionMessage,
            FormCheckbox,
            FormSection,
            FormSectionBorder,
            JetInput,
            JetInputError,
        },
        props: [
            'tokens',
            'availablePermissions',
            'defaultPermissions',
        ],
        setup(props) {
            const page = usePage()
            const createApiTokenForm = useForm({
                name: '',
                permissions: props.defaultPermissions,
            })
            const deleteApiTokenForm = useForm()
            const updateApiTokenForm = useForm({ permissions: [] })
            const apiTokenBeingDeleted = ref(null)
            const displayingToken = ref(false)
            const managingPermissionsFor = ref(null)
            const createApiToken = () => {
                createApiTokenForm.value.post(route('api-tokens.store'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        displayingToken.value = true,
                        createApiTokenForm.reset()
                    }
                })
            }
            const deleteApiToken = () => {
                deleteApiTokenForm.value.delete(route('api-tokens.destroy', apiTokenBeingDeleted.value), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => (apiTokenBeingDeleted.value = null),
                })
            }
            const manageApiTokenPermissions = token => {
                updateApiTokenForm.value.permissions = token.abilities
                managingPermissionsFor.value = token
            }
            const updateApiToken = () => {
                updateApiTokenForm.value.put(route('api-tokens.update', managingPermissionsFor.value), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => (managingPermissionsFor.value = null),
                })
            }
            const confirmApiTokenDeletion = token => apiTokenBeingDeleted.value = token

            return {
                page,
                createApiTokenForm,
                deleteApiTokenForm,
                updateApiTokenForm,
                apiTokenBeingDeleted,
                displayingToken,
                managingPermissionsFor,
                createApiToken,
                deleteApiToken,
                manageApiTokenPermissions,
                updateApiToken,
                confirmApiTokenDeletion,
            }
        },
    }
</script>
