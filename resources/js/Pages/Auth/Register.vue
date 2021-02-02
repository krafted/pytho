<template>
    <l-auth>
        <template #logo>
            <x-logo class="w-10.5 h-10.5 text-lg sm:w-12 sm:h-12 sm:text-2xl" />
        </template>

        <form @submit.prevent="submit">
            <div class="grid grid-cols-1 gap-3 p-4 sm:p-6">
                <f-validation-errors />

                <f-input
                    label="Name"
                    autocomplete="name"
                    autofocus
                    required
                    v-model="form.name"
                />

                <f-input
                    label="Username"
                    autocomplete="username"
                    required
                    v-model="form.username"
                />

                <f-input
                    label="Email"
                    required
                    type="email" 
                    v-model="form.email"
                />

                <f-input
                    label="Password"
                    autocomplete="new-password"
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

                <label
                    class="flex items-center"
                    v-if="page.props.value.jetstream.hasTermsAndPrivacyPolicyFeature"
                >
                    <f-checkbox
                        id="terms"
                        name="terms"
                        class="w-6 h-6"
                        v-model="form.terms"
                    />

                    <span class="ml-3 text-sm text-gray-500">
                        I agree to the <a target="_blank" :href="route('terms.show')" class="font-medium text-gray-600 dark:text-gray-400 focus:ring focus:outline-none focus:ring-primary-500 hover:underline">Terms</a> and <a target="_blank" :href="route('privacy.show')" class="font-medium text-gray-600 dark:text-gray-400 focus:outline-none focus:ring focus:ring-primary-500 hover:underline">Privacy Policy</a>
                    </span>
                </label>
            </div>

            <div class="p-4 bg-gray-100 sm:rounded-b-lg sm:px-6 sm:py-3 dark:bg-gray-800">
                <x-button
                    class="w-full"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Register
                </x-button>

                <x-providers v-if="page.props.value.socialstream.show" method="Register" />
            </div>
        </form>

        <template #additional-links>
            <div class="flex items-center justify-center w-full mt-3 space-x-3 text-gray-800">
                <inertia-link
                    :href="route('login')"
                    class="text-sm text-gray-500 hover:underline focus:outline-none focus:ring focus:ring-primary-500"
                >
                    Already have an account?
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
                name: '',
                username: '',
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
