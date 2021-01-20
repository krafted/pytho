<template>
    <app-authentication-card>
        <template #logo>
            <app-logo class="10.5 h-10.5 text-lg sm:w-12 sm:h-12 sm:text-2xl" />
        </template>

        <form @submit.prevent="submit">
            <div class="grid grid-cols-1 gap-3 p-4 sm:p-6">
                <div class="text-sm text-gray-500">
                    This is a secure area of the application. Please confirm your password before continuing.
                </div>

                <form-validation-errors />

                <form-input
                    label="Password"
                    autocomplete="current-password"
                    autofocus
                    required
                    type="password"
                    v-model="form.password"
                />
            </div>

            <div class="flex flex-col p-4 space-y-1 bg-gray-100 sm:rounded-b-lg sm:space-x-3 sm:px-6 sm:py-3 dark:bg-gray-800 sm:flex-row-reverse">
                <app-button
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Confirm
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
        components: {
            AppAuthenticationCard,
            AppButton,
            AppLogo,
            FormInput,
            FormValidationErrors,
        },
        setup() {
            const form = useForm({ password: '' })
            const submit = () => {
                form.value.post(route('password.confirm'), {
                    onFinish: () => form.value.reset(),
                })
            }

            return {
                form,
                submit,
            }
        },
    }
</script>
