<template>
    <l-auth>
        <template #logo>
            <x-logo class="w-10.5 h-10.5 text-lg sm:w-12 sm:h-12 sm:text-2xl" />
        </template>

        <form @submit.prevent="submit">
            <div class="grid grid-cols-1 gap-3 p-4 sm:p-6">
                <f-validation-errors />

                <f-input
                    label="Email"
                    readonly
                    required
                    type="email"
                    v-model="form.email"
                />

                <f-input
                    label="Password"
                    autocomplete="new-password"
                    autofocus
                    required
                    type="password"
                    v-model="form.password"
                />

                <f-input
                    label="Confirm Password"
                    autocomplete="new-password"
                    required
                    type="password"
                    v-model="form.password_confirmation"
                />
            </div>

            <div class="flex items-center justify-end p-4 space-x-3 bg-gray-100 sm:rounded-b-lg sm:px-6 sm:py-3 dark:bg-gray-800">
                <x-button
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Reset Password
                </x-button>
            </div>
        </form>
    </l-auth>
</template>

<script>
    import FInput from '@/Components/Form/Input'
    import FValidationErrors from '@/Components/Form/ValidationErrors'
    import LAuth from '@/Layouts/Auth'
    import XButton from '@/Components/Button'
    import XLogo from '@/Components/Logo'
    import { useForm } from '@inertiajs/inertia-vue3'

    export default {
        props: {
            email: String,
            token: String,
        },
        components: {
            FInput,
            FValidationErrors,
            LAuth,
            XButton,
            XLogo,
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
