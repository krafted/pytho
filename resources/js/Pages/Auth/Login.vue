<template>
    <app-authentication-card>
        <template #logo>
            <app-logo class="w-12 h-12 text-2xl" />
        </template>

        <form @submit.prevent="submit">
            <div class="grid grid-cols-1 gap-3 p-6">
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

                <label class="flex items-center">
                    <form-checkbox
                        class="w-6 h-6"
                        name="remember"
                        v-model="form.remember"
                    />
                    <span class="ml-4 text-xs font-semibold tracking-wide text-gray-500 uppercase">Remember me</span>
                </label>
            </div>

            <div class="flex items-center justify-end px-6 py-3 bg-gray-100 dark:bg-gray-800">
                <inertia-link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="text-sm text-gray-500 hover:underline focus:outline-none focus:ring focus:ring-primary-500"
                >
                    Forgot your password?
                </inertia-link>

                <app-button
                    class="ml-3"
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
