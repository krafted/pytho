<template>
    <jet-authentication-card>
        <template #logo>
            <jet-authentication-card-logo />
        </template>

        <jet-validation-errors class="mb-4" />

        <form @submit.prevent="submit">
            <div>
                <jet-label for="email" value="Email" />
                <jet-input id="email" type="email" class="block w-full mt-1" v-model="form.email" required autofocus />
            </div>

            <div class="mt-4">
                <jet-label for="password" value="Password" />
                <jet-input id="password" type="password" class="block w-full mt-1" v-model="form.password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <jet-label for="password_confirmation" value="Confirm Password" />
                <jet-input id="password_confirmation" type="password" class="block w-full mt-1" v-model="form.password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Reset Password
                </jet-button>
            </div>
        </form>
    </jet-authentication-card>
</template>

<script>
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo'
    import JetButton from '@/Jetstream/Button'
    import JetInput from '@/Jetstream/Input'
    import JetLabel from '@/Jetstream/Label'
    import JetValidationErrors from '@/Jetstream/ValidationErrors'
    import { inject } from 'vue'
    import { useForm } from '@inertiajs/inertia-vue3'

    export default {
        props: {
            email: String,
            token: String,
        },
        components: {
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetLabel,
            JetValidationErrors
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
