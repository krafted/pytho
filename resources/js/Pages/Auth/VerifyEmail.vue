<template>
    <l-auth>
        <template #logo>
            <x-logo class="w-10.5 h-10.5 text-lg sm:w-12 sm:h-12 sm:text-2xl" />
        </template>

        <form @submit.prevent="submit">
            <div class="grid grid-cols-1 gap-3 p-4 sm:p-6">
                <div class="text-sm text-gray-500">
                    Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
                </div>

                <div class="text-sm font-medium text-green-600 dark:text-green-400" v-if="verificationLinkSent" >
                    A new verification link has been sent to the email address you provided during registration.
                </div>
            </div>

            <div class="flex p-4 space-x-3 bg-gray-100 sm:rounded-b-lg sm:px-6 sm:py-3 dark:bg-gray-800">
                <x-button
                    class="w-full"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Resend Verification Email
                </x-button>
            </div>
        </form>

        <template #additional-links>
            <div class="flex items-center justify-center w-full mt-3 space-x-3 text-gray-800">
                <inertia-link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="text-sm text-gray-500 hover:underline focus:outline-none focus:ring focus:ring-primary-500"
                >
                    Logout?
                </inertia-link>
            </div>
        </template>
    </l-auth>
</template>

<script>
    import LAuth from '@/Layouts/Auth'
    import XButton from '@/Components/Button'
    import XLogo from '@/Components/Logo'
    import { computed } from 'vue'
    import { useForm } from '@inertiajs/inertia-vue3'

    export default {
        props: { status: String },
        components: {
            LAuth,
            XButton,
            XLogo,
        },
        setup(props) {
            const form = useForm()
            const submit = () => form.value.post(route('verification.send'))
            const verificationLinkSent = computed(() => props.status === 'verification-link-sent')

            return {
                form,
                submit,
                verificationLinkSent,
            }
        },
    }
</script>
