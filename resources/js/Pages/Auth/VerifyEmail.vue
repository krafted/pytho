<template>
    <app-authentication-card>
        <template #logo>
            <app-logo class="w-10 h-10 text-lg sm:w-12 sm:h-12 sm:text-2xl" />
        </template>

        <form @submit.prevent="submit">
            <div class="grid grid-cols-1 gap-3 p-6">
                <div class="text-sm text-gray-500">
                    Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
                </div>

                <div class="text-sm font-medium text-green-600 dark:text-green-400" v-if="verificationLinkSent" >
                    A new verification link has been sent to the email address you provided during registration.
                </div>
            </div>

            <div class="flex items-center justify-end px-6 py-3 bg-gray-100 dark:bg-gray-800">
                <inertia-link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="text-sm font-semibold tracking-wide text-gray-500 uppercase hover:underline focus:outline-none focus:ring focus:ring-primary-500"
                >
                    Logout
                </inertia-link>
                
                <app-button
                    class="ml-3"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Resend Verification Email
                </app-button>
            </div>
        </form>
    </app-authentication-card>
</template>

<script>
    import AppAuthenticationCard from '@/Components/AuthenticationCard'
    import AppButton from '@/Components/Button'
    import AppLogo from '@/Components/Logo'
    import { computed, inject } from 'vue'
    import { useForm } from '@inertiajs/inertia-vue3'

    export default {
        props: { status: String },
        components: {
            AppAuthenticationCard,
            AppButton,
            AppLogo,
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
