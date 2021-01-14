<template>
    <jet-authentication-card>
        <template #logo>
            <jet-authentication-card-logo />
        </template>

        <div class="mb-4 text-sm text-gray-600">
            Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
        </div>

        <div class="mb-4 text-sm font-medium text-green-600" v-if="verificationLinkSent" >
            A new verification link has been sent to the email address you provided during registration.
        </div>

        <form @submit.prevent="submit">
            <div class="flex items-center justify-between mt-4">
                <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Resend Verification Email
                </jet-button>

                <inertia-link :href="route('logout')" method="post" as="button" class="text-sm text-gray-600 underline hover:text-gray-900">Logout</inertia-link>
            </div>
        </form>
    </jet-authentication-card>
</template>

<script>
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo'
    import JetButton from '@/Jetstream/Button'
    import { computed, inject } from 'vue'
    import { useForm } from '@inertiajs/inertia-vue3'

    export default {
        props: { status: String },
        components: {
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
        },
        setup(props) {
            const form = useForm()
            const submit = () => form.value.post(route('verification.send'))
            const verificationLinkSent = computed(() => props.status === 'verification-link-sent')

            return {
                form,
                submit,
            }
        },
    }
</script>
