<template>
    <f-action-section>
        <template #title>
            Delete Account
        </template>

        <template #description>
            Permanently delete your account.
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
                Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
            </div>

            <!-- Delete Account Confirmation Modal -->
            <x-modal
                :show="confirmingUserDeletion"
                @close="closeModal"
            >
                <template #icon>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </template>

                <template #title>
                    Delete Account
                </template>

                <template #content>
                    <div class="text-sm text-gray-500">
                        Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.
                    </div>

                    <div class="mt-3 space-y-1">
                        <f-input
                            label="Password"
                            type="password"
                            ref="password"
                            v-model="form.password"
                            @keyup.enter.native="deleteUser"
                        />

                        <f-input-error :message="form.errors.password" />
                    </div>
                </template>

                <template #actions>
                    <x-secondary-button @click.native="closeModal">
                        Close
                    </x-secondary-button>

                    <x-danger-button @click.native="deleteUser" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Delete Account
                    </x-danger-button>
                </template>
            </x-modal>
        </template>

        <template #actions>
            <x-danger-button @click.native="confirmUserDeletion">
                Delete Account
            </x-danger-button>
        </template>
    </f-action-section>
</template>

<script>
    import FActionSection from '@/Components/Form/ActionSection'
    import FInput from '@/Components/Form/Input'
    import FInputError from '@/Components/Form/InputError'
    import XDangerButton from '@/Components/DangerButton'
    import XSecondaryButton from '@/Components/SecondaryButton'
    import XModal from '@/Components/Modal'
    import { ref } from 'vue'
    import { useForm } from '@inertiajs/inertia-vue3'

    export default {
        components: {
            FActionSection,
            FInput,
            FInputError,
            XDangerButton,
            XSecondaryButton,
            XModal,
        },
        setup() {
            const form = useForm({ password: '' })
            const confirmingUserDeletion = ref(false)
            const password = ref(null)
            const confirmUserDeletion = () => {
                confirmingUserDeletion.value = true
                setTimeout(() => password.value.focus(), 250)
            }
            const deleteUser = () => {
                form.value.delete(route('current-user.destroy'), {
                    preserveScroll: true,
                    onSuccess: () => closeModal(),
                    onError: () => password.value.focus(),
                    onFinish: () => form.value.reset(),
                })
            }
            const closeModal = () => {
                confirmingUserDeletion.value = false
                form.value.reset()
            }

            return {
                closeModal,
                confirmUserDeletion,
                confirmingUserDeletion,
                deleteUser,
                form,
                password,
            }
        },
    }
</script>
