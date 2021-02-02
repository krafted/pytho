<template>
    <l-auth>
        <template #logo>
            <x-logo class="w-10.5 h-10.5 text-lg sm:w-12 sm:h-12 sm:text-2xl" />
        </template>

        <form @submit.prevent="submit">
            <div class="grid grid-cols-1 gap-3 p-4 sm:p-6">
                <div v-if="status" class="text-sm font-medium text-green-600 dark:text-green-400">
                    {{ status }}
                </div>

                <f-validation-errors />

                <f-input
                    label="Username"
                    autofocus
                    required
                    title="Username or Email"
                    v-model="form.username"
                />

                <f-input
                    label="Password"
                    autocomplete="current-password"
                    required
                    type="password"
                    v-model="form.password"
                />

                <div class="flex items-center justify-between">
                    <label class="flex items-center cursor-pointer">
                        <f-checkbox
                            class="w-6 h-6"
                            name="remember"
                            v-model="form.remember"
                        />
                        <span class="ml-4 text-xs font-semibold tracking-wide text-gray-500 uppercase">Remember me</span>
                    </label>
                </div>
            </div>

            <div class="p-4 bg-gray-100 sm:rounded-b-lg sm:px-6 sm:py-3 dark:bg-gray-800">
                <x-button
                    class="w-full"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Login
                </x-button>

                <x-providers v-if="page.props.value.socialstream.show" method="Login" />
            </div>
        </form>

        <template #additional-links>
            <div class="flex items-center justify-center w-full mt-3 space-x-3 text-gray-800">
                <inertia-link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="text-sm text-gray-500 hover:underline focus:outline-none focus:ring focus:ring-primary-500"
                >
                    Forgot your password?
                </inertia-link>

                <span>&mdash;</span>

                <inertia-link
                    v-if="route().has('register')"
                    :href="route('register')"
                    class="text-sm text-center text-gray-500 hover:underline focus:outline-none focus:ring focus:ring-primary-500"
                >
                    Need an account?
                </inertia-link>
            </div>
        </template>
    </l-auth>
</template>

<script>
    import FCheckbox from '@/Components/Form/Checkbox'
    import FInput from '@/Components/Form/Input'
    import FValidationErrors from '@/Components/Form/ValidationErrors'
    import LAuth from '@/Layouts/Auth'
    import XButton from '@/Components/Button'
    import XLogo from '@/Components/Logo'
    import XProviders from '@/Components/Providers'
    import { useForm, usePage } from '@inertiajs/inertia-vue3'

    export default {
        props: {
            canResetPassword: Boolean,
            status: String
        },
        components: {
            FCheckbox,
            FInput,
            FValidationErrors,
            LAuth,
            XButton,
            XLogo,
            XProviders,
        },
        setup() {
            const page = usePage()
            const form = useForm({
                username: '',
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
                page,
                form,
                submit,
            }
        },
    }
</script>
