<template>
    <app-authentication-card>
        <template #logo>
            <app-logo class="w-10 h-10 text-lg sm:w-12 sm:h-12 sm:text-2xl" />
        </template>

        <form @submit.prevent="submit">
            <div class="grid grid-cols-1 gap-3 p-6">
                <form-validation-errors />

                <form-input
                    label="Email"
                    readonly
                    required
                    type="email"
                    v-model="form.email"
                />

                <form-input
                    label="Password"
                    autocomplete="new-password"
                    autofocus
                    required
                    type="password"
                    v-model="form.password"
                />

                <form-input
                    label="Confirm Password"
                    autocomplete="new-password"
                    required
                    type="password"
                    v-model="form.password_confirmation"
                />
            </div>

            <div class="flex items-center justify-end px-6 py-3 bg-gray-100 dark:bg-gray-800">
                <app-button
                    class="ml-3"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Reset Password
                </app-button>
            </div>
        </form>
    </app-authentication-card>
</template>

<script>
    import AppAuthenticationCard from '@/Components/AuthenticationCard'
    import AppButton from '@/Components/Button'
    import AppLogo from '@/Components/Logo'
    import FormInput from '@/Components/Form/Input'
    import FormValidationErrors from '@/Components/Form/ValidationErrors'
    import { inject } from 'vue'
    import { useForm } from '@inertiajs/inertia-vue3'

    export default {
        props: {
            email: String,
            token: String,
        },
        components: {
            AppAuthenticationCard,
            AppButton,
            AppLogo,
            FormInput,
            FormValidationErrors,
        },
        setup(props) {
            const form = useForm({
                token: props.token,
                email: props.email,
                password: '',
                password_confirmation: '',
            })
            const submit = () => {
                form.value.post(route('password.update'), {
                    onFinish: () => form.value.reset('password', 'password_confirmation'),
                })
            }

            return {
                form,
                submit,
            }
        },
    }
</script>
