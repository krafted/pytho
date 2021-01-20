<template>
    <app-authentication-card>
        <template #logo>
            <app-logo class="w-10.5 h-10.5 text-lg sm:w-12 sm:h-12 sm:text-2xl" />
        </template>

        <form @submit.prevent="submit">
            <div class="grid grid-cols-1 gap-3 p-4 sm:p-6">
                <div class="text-sm text-gray-500">
                    Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
                </div>

                <div v-if="status" class="text-sm font-medium text-green-600 dark:text-green-400">
                    {{ status }}
                </div>

                <div class="border-t border-gray-100 dark:border-gray-800" />

                <form-validation-errors />

                <form-input
                    label="Email"
                    autofocus 
                    required
                    type="email"
                    v-model="form.email"
                />
            </div>

            <div class="flex items-center justify-end p-4 space-x-3 bg-gray-100 sm:rounded-b-lg sm:px-6 sm:py-3 dark:bg-gray-800">
                <app-button
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Email Password Reset Link
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
        props: { status: String },
        components: {
            AppAuthenticationCard,
            AppButton,
            AppLogo,
            FormInput,
            FormValidationErrors,
        },
        setup() {
            const form = useForm({ email: '' })
            const submit = () => form.value.post(route('password.email'))

            return {
                form,
                submit,
            }
        },
    }
</script>
