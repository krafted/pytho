<template>
    <app-authentication-card>
        <template #logo>
            <app-logo class="w-10 h-10 text-lg sm:w-12 sm:h-12 sm:text-2xl" />
        </template>

        <form @submit.prevent="submit">
            <div class="grid grid-cols-1 gap-3 p-6">
                <div class="text-sm text-gray-500">
                    <template v-if="!recovery">
                        Please confirm access to your account by entering the authentication code provided by your authenticator application.
                    </template>

                    <template v-else>
                        Please confirm access to your account by entering one of your emergency recovery codes.
                    </template>
                </div>

                <div class="border-t border-gray-100 dark:border-gray-800" />

                <form-validation-errors />

                <form-input
                    v-if="!recovery"
                    label="Code"
                    autocomplete="one-time-code"
                    autofocus
                    inputmode="numeric"
                    ref="code"
                    type="text"
                    v-model="form.code"
                />

                <form-input
                    v-else
                    label="Recovery Code"
                    autocomplete="one-time-code"
                    autofocus
                    ref="recoveryCode"
                    type="text"
                    v-model="form.recovery_code"
                />
            </div>

            <div class="flex items-center justify-end px-6 py-3 bg-gray-100 dark:bg-gray-800">
                <app-secondary-button
                    type="button"
                    @click.prevent="toggleRecovery"
                >
                    <template v-if="!recovery">
                        Use recovery code
                    </template>

                    <template v-else>
                        Use authentication code
                    </template>
                </app-secondary-button>

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
    import AppSecondaryButton from '@/Components/SecondaryButton'
    import AppLogo from '@/Components/Logo'
    import FormInput from '@/Components/Form/Input'
    import FormValidationErrors from '@/Components/Form/ValidationErrors'
    import { inject, nextTick, onMounted, ref } from 'vue'
    import { useForm } from '@inertiajs/inertia-vue3'

    export default {
        components: {
            AppAuthenticationCard,
            AppButton,
            AppSecondaryButton,
            AppLogo,
            FormInput,
            FormValidationErrors,
        },
        setup() {
            const form = useForm({ code: '', recovery_code: '' })
            const recovery = ref(false)
            const code = ref(null)
            const recoveryCode = ref(null)
            const submit = () => form.value.post(route('two-factor.login'))
            const toggleRecovery = async () => {
                recovery.value ^= true
                await nextTick()
                if (recovery.value) {
                    recoveryCode.value.focus()
                    form.value.code = ''
                } else {
                    code.value.focus()
                    form.value.recovery_code = ''
                }
            }

            return{
                form,
                recovery,
                code,
                recoveryCode,
                submit,
                toggleRecovery,
            }
        },
    }
</script>
