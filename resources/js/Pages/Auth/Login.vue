<template>
    <app-authentication-card>
        <template #logo>
            <app-logo class="w-10.5 h-10.5 text-lg sm:w-12 sm:h-12 sm:text-2xl" />
        </template>

        <form @submit.prevent="submit">
            <div class="grid grid-cols-1 gap-3 p-4 sm:p-6">
                <div v-if="status" class="text-sm font-medium text-green-600 dark:text-green-400">
                    {{ status }}
                </div>

                <form-validation-errors />

                <form-input
                    label="Email"
                    autofocus
                    required
                    type="email"
                    v-model="form.email"
                />

                <form-input
                    label="Password"
                    autocomplete="current-password"
                    required
                    type="password"
                    v-model="form.password"
                />

                <div class="flex items-center justify-between">
                    <label class="flex items-center cursor-pointer">
                        <form-checkbox
                            class="w-6 h-6"
                            name="remember"
                            v-model="form.remember"
                        />
                        <span class="ml-4 text-xs font-semibold tracking-wide text-gray-500 uppercase">Remember me</span>
                    </label>

                    <inertia-link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="text-sm text-gray-500 hover:underline focus:outline-none focus:ring focus:ring-primary-500"
                    >
                        Forgot your password?
                    </inertia-link>
                </div>
            </div>

            <div class="flex items-center justify-end p-4 space-x-3 bg-gray-100 sm:rounded-b-lg sm:px-6 sm:py-3 dark:bg-gray-800">
                <inertia-link
                    v-if="route().has('register')"
                    :href="route('register')"
                    class="text-sm text-center text-gray-500 hover:underline focus:outline-none focus:ring focus:ring-primary-500"
                >
                    Need an account?
                </inertia-link>

                <app-button
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Login
                </app-button>
            </div>
        </form>
    </app-authentication-card>
</template>

<script>
    import AppAuthenticationCard from '@/Components/AuthenticationCard'
    import AppButton from '@/Components/Button'
    import AppLogo from '@/Components/Logo'
    import FormCheckbox from '@/Components/Form/Checkbox'
    import FormInput from '@/Components/Form/Input'
    import FormValidationErrors from '@/Components/Form/ValidationErrors'
    import { inject } from 'vue'
    import { useForm } from '@inertiajs/inertia-vue3'

    export default {
        props: {
            canResetPassword: Boolean,
            status: String
        },
        components: {
            AppAuthenticationCard,
            AppButton,
            AppLogo,
            FormCheckbox,
            FormInput,
            FormValidationErrors,
        },
        setup() {
            const form = useForm({
                email: '',
                password: '',
                remember: false,
            })
            const submit = () => {
                form.value
                    .transform(data => ({
                        ...data,
                        remember: form.value.remember ? 'on' : '',
                    }))
                    .post(route('login'), {
                        onFinish: () => form.value.reset('password'),
                    })
            }

            return {
                form,
                submit,
            }
        },
    }
</script>
