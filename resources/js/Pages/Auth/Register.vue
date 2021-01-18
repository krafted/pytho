<template>
    <app-authentication-card>
        <template #logo>
            <app-logo class="w-10 h-10 text-lg sm:w-12 sm:h-12 sm:text-2xl" />
        </template>

        <form @submit.prevent="submit">
            <div class="grid grid-cols-1 gap-3 p-6">
                <form-validation-errors />

                <form-input
                    label="Name"
                    autocomplete="name"
                    autofocus
                    required
                    v-model="form.name"
                />

                <form-input
                    label="Email"
                    required
                    type="email" 
                    v-model="form.email"
                />

                <form-input
                    label="Password"
                    autocomplete="new-password"
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

                <label
                    class="flex items-center"
                    v-if="page.props.value.jetstream.hasTermsAndPrivacyPolicyFeature"
                >
                    <form-checkbox
                        id="terms"
                        name="terms"
                        class="w-6 h-6"
                        v-model="form.terms"
                    />

                    <span class="ml-3 text-sm text-gray-500">
                        I agree to the <a target="_blank" :href="route('terms.show')" class="text-gray-400 focus:ring focus:outline-none focus:ring-primary-500 hover:underline">Terms</a> and <a target="_blank" :href="route('policy.show')" class="text-gray-400 focus:outline-none focus:ring focus:ring-primary-500 hover:underline">Privacy Policy</a>
                    </span>
                </label>
            </div>

            <div class="flex items-center justify-end px-6 py-3 bg-gray-100 dark:bg-gray-800">
                <inertia-link
                    :href="route('login')"
                    class="text-sm text-gray-500 hover:underline focus:outline-none focus:ring focus:ring-primary-500"
                >
                    Already registered?
                </inertia-link>

                <app-button
                    class="ml-3"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Register
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
    import { useForm, usePage } from '@inertiajs/inertia-vue3'

    export default {
        components: {
            AppAuthenticationCard,
            AppButton,
            AppLogo,
            FormCheckbox,
            FormInput,
            FormValidationErrors,
        },
        setup() {
            const page = usePage()
            const form = useForm({
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                terms: false,
            })
            const submit = () => {
                form.value.post(route('register'), {
                    onFinish: () => form.value.reset('password', 'password_confirmation'),
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
