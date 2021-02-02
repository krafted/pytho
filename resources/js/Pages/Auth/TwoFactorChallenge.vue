<template>
    <l-auth>
        <template #logo>
            <x-logo class="w-10.5 h-10.5 text-lg sm:w-12 sm:h-12 sm:text-2xl" />
        </template>

        <form @submit.prevent="submit">
            <div class="grid grid-cols-1 gap-3 p-4 sm:p-6">
                <div class="text-sm text-gray-500">
                    <template v-if="!recovery">
                        Please confirm access to your account by entering the authentication code provided by your authenticator application.
                    </template>

                    <template v-else>
                        Please confirm access to your account by entering one of your emergency recovery codes.
                    </template>
                </div>

                <div class="border-t border-gray-100 dark:border-gray-800" />

                <f-validation-errors />

                <f-input
                    v-if="!recovery"
                    label="Code"
                    autocomplete="one-time-code"
                    autofocus
                    inputmode="numeric"
                    ref="code"
                    type="text"
                    v-model="form.code"
                />

                <f-input
                    v-else
                    label="Recovery Code"
                    autocomplete="one-time-code"
                    autofocus
                    ref="recoveryCode"
                    type="text"
                    v-model="form.recovery_code"
                />
            </div>

            <div class="flex items-center justify-end p-4 space-x-3 bg-gray-100 sm:rounded-b-lg sm:px-6 sm:py-3 dark:bg-gray-800">
                <x-secondary-button
                    type="button"
                    @click.prevent="toggleRecovery"
                >
                    <template v-if="!recovery">
                        Use recovery code
                    </template>

                    <template v-else>
                        Use authentication code
                    </template>
                </x-secondary-button>

                <x-button
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Login
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
    import XSecondaryButton from '@/Components/SecondaryButton'
    import XLogo from '@/Components/Logo'
    import { nextTick, ref } from 'vue'
    import { useForm } from '@inertiajs/inertia-vue3'

    export default {
        components: {
            FInput,
            FValidationErrors,
            LAuth,
            XButton,
            XSecondaryButton,
            XLogo,
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
