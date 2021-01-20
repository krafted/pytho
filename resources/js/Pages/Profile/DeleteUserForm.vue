<template>
    <form-action-section>
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
            <app-modal
                :show="confirmingUserDeletion"
                @close="closeModal"
            >
                <template #icon>
                    <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-gray-100 rounded-full dark:bg-black sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="w-6 h-6 text-gray-600 dark:text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </template>

                <template #title>
                    Delete Account
                </template>

                <template #content>
                    <div class="text-sm text-gray-500">
                        Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.
                    </div>

                    <div class="mt-3 space-y-1">
                        <form-input
                            label="Password"
                            type="password"
                            ref="password"
                            v-model="form.password"
                            @keyup.enter.native="deleteUser"
                        />

                        <form-input-error :message="form.errors.password" />
                    </div>
                </template>

                <template #actions>
                    <app-secondary-button @click.native="closeModal">
                        Close
                    </app-secondary-button>

                    <app-danger-button @click.native="deleteUser" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Delete Account
                    </app-danger-button>
                </template>
            </app-modal>
        </template>

        <template #actions>
            <app-danger-button @click.native="confirmUserDeletion">
                Delete Account
            </app-danger-button>
        </template>
    </form-action-section>
</template>

<script>
    import AppDangerButton from '@/Components/DangerButton'
    import AppSecondaryButton from '@/Components/SecondaryButton'
    import AppModal from '@/Components/Modal'
    import FormActionSection from '@/Components/Form/ActionSection'
    import FormInput from '@/Components/Form/Input'
    import FormInputError from '@/Components/Form/InputError'
    import { inject, provide, ref } from 'vue'
    import { useForm } from '@inertiajs/inertia-vue3'

    export default {
        components: {
            AppDangerButton,
            AppSecondaryButton,
            AppModal,
            FormActionSection,
            FormInput,
            FormInputError,
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
