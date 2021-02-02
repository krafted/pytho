<template>
    <div>
        <!-- Generate API Token -->
        <f-section @submitted="createApiToken">
            <template #title>
                Create API Token
            </template>

            <template #description>
                API tokens allow third-party services to authenticate with our application on your behalf.
            </template>

            <template #form>
                <!-- Token Name -->
                <div class="col-span-6 space-y-1 sm:col-span-4">
                    <f-input
                        label="Name"
                        autofocus
                        v-model="createApiTokenForm.name"
                    />

                    <f-input-error :message="createApiTokenForm.errors.name" />
                </div>

                <!-- Token Permissions -->
                <div class="col-span-6" v-if="availablePermissions.length > 0">
                    <span v-text="'Permissions'" />

                    <div class="grid grid-cols-1 gap-4 mt-2 md:grid-cols-2">
                        <div v-for="permission in availablePermissions" :key="permission">
                            <label class="flex items-center">
                                <x-checkbox :value="permission" v-model="createApiTokenForm.permissions"/>
                                <span class="ml-2 text-sm text-gray-600">{{ permission }}</span>
                            </label>
                        </div>
                    </div>
                </div>
            </template>

            <template #actions>
                <f-action-message :on="createApiTokenForm.recentlySuccessful" class="mr-3">
                    Created.
                </f-action-message>

                <x-button :class="{ 'opacity-25': createApiTokenForm.processing }" :disabled="createApiTokenForm.processing">
                    Create
                </x-button>
            </template>
        </f-section>

        <div v-if="tokens.length > 0">
            <f-section-border />

            <!-- Manage API Tokens -->
            <div class="mt-10 sm:mt-0">
                <f-action-section>
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
                </f-action-section>
            </div>
        </div>

        <!-- Token Value Modal -->
        <x-modal
            :show="displayingToken"
            @close="displayingToken = false"
        >
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
                <x-secondary-button @click.native="displayingToken = false">
                    Close
                </x-secondary-button>
            </template>
        </x-modal>

        <!-- API Token Permissions Modal -->
        <x-modal
            :show="managingPermissionsFor"
            @close="managingPermissionsFor = null"
        >
            <template #title>
                API Token Permissions
            </template>

            <template #content>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div v-for="permission in availablePermissions" :key="permission">
                        <label class="flex items-center">
                            <f-checkbox
                                :value="permission"
                                v-model="updateApiTokenForm.permissions"
                            />
                            <span class="ml-2 text-sm text-gray-600">{{ permission }}</span>
                        </label>
                    </div>
                </div>
            </template>

            <template #actions>
                <x-secondary-button @click.native="managingPermissionsFor = null">
                    Close
                </x-secondary-button>

                <x-button class="ml-2" @click.native="updateApiToken" :class="{ 'opacity-25': updateApiTokenForm.processing }" :disabled="updateApiTokenForm.processing">
                    Save
                </x-button>
            </template>
        </x-modal>

        <!-- Delete Token Confirmation Modal -->
        <x-modal
            :show="apiTokenBeingDeleted"
            @close="apiTokenBeingDeleted = null"
        >
            <template #title>
                Delete API Token
            </template>

            <template #content>
                Are you sure you would like to delete this API token?
            </template>

            <template #actions>
                <x-secondary-button @click.native="apiTokenBeingDeleted = null">
                    Close
                </x-secondary-button>

                <x-danger-button class="ml-2" @click.native="deleteApiToken" :class="{ 'opacity-25': deleteApiTokenForm.processing }" :disabled="deleteApiTokenForm.processing">
                    Delete
                </x-danger-button>
            </template>
        </x-modal>
    </div>
</template>

<script>
    import FActionMessage from '@/Components/Form/ActionMessage'
    import FCheckbox from '@/Components/Form/Checkbox'
    import FInput from '@/Components/Form/Input'
    import FInputError from '@/Components/Form/InputError'
    import FSection from '@/Components/Form/Section'
    import FSectionBorder from '@/Components/Form/SectionBorder'
    import XButton from '@/Components/Button'
    import XDangerButton from '@/Components/DangerButton'
    import XSecondaryButton from '@/Components/SecondaryButton'
    import XModal from '@/Components/Modal'
    import { ref } from 'vue'
    import { useForm, usePage } from '@inertiajs/inertia-vue3'

    export default {
        components: {
            FActionMessage,
            FCheckbox,
            FInput,
            FInputError,
            FSection,
            FSectionBorder,
            XButton,
            XDangerButton,
            XSecondaryButton,
            XModal,
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
