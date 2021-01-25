<template>
    <form-section @submitted="updatePassword">
        <template #title>
            Update Password
        </template>

        <template #description>
            Ensure your account is using a long, random password to stay secure.
        </template>

        <template #form>
            <div class="col-span-6 space-y-1 sm:col-span-4">
                <form-input
                    label="Current Password"
                    autocomplete="current-password"
                    ref="currentPassword"
                    type="password"
                    v-model="form.current_password"
                />

                <form-input-error :message="form.errors.current_password" />
            </div>

            <div class="col-span-6 space-y-1 sm:col-span-4">
                <form-input
                    label="New Password"
                    autocomplete="new-password"
                    ref="password"
                    type="password"
                    v-model="form.password"
                />

                <form-input-error :message="form.errors.password" />
            </div>

            <div class="col-span-6 space-y-1 sm:col-span-4">
                <form-input
                    label="Confirm Password"
                    autocomplete="new-password"
                    type="password"
                    v-model="form.password_confirmation"
                />

                <form-input-error :message="form.errors.password_confirmation" />
            </div>
        </template>

        <template #actions>
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
    import { ref } from 'vue'
    import { useForm } from '@inertiajs/inertia-vue3'

    export default {
        components: {
            AppButton,
            FormActionMessage,
            FormInput,
            FormInputError,
            FormSection,
        },
        setup() {
            const form = useForm({
                current_password: '',
                password: '',
                password_confirmation: '',
            })
            const password = ref(null)
            const currentPassword = ref(null)
            const updatePassword = () => {
                form.value.put(route('user-password.update'), {
                    errorBag: 'updatePassword',
                    preserveScroll: true,
                    onSuccess: () => form.value.reset(),
                    onError: () => {
                        if (form.value.errors.password) {
                            form.value.reset('password', 'password_confirmation')
                            password.value.focus()
                        }
                        if (form.value.errors.current_password) {
                            form.value.reset('current_password')
                            currentPassword.value.focus()
                        }
                    }
                })
            }

            return {
                form,
                password,
                updatePassword,
                currentPassword,
            }
        },
    }
</script>
