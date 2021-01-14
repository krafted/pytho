<template>
    <jet-authentication-card>
        <template #logo>
            <jet-authentication-card-logo />
        </template>

        <div class="mb-4 text-sm text-gray-600">
            <template v-if="! recovery">
                Please confirm access to your account by entering the authentication code provided by your authenticator application.
            </template>

            <template v-else>
                Please confirm access to your account by entering one of your emergency recovery codes.
            </template>
        </div>

        <jet-validation-errors class="mb-4" />

        <form @submit.prevent="submit">
            <div v-if="! recovery">
                <jet-label for="code" value="Code" />
                <jet-input ref="code" id="code" type="text" inputmode="numeric" class="block w-full mt-1" v-model="form.code" autofocus autocomplete="one-time-code" />
            </div>

            <div v-else>
                <jet-label for="recovery_code" value="Recovery Code" />
                <jet-input ref="recovery_code" id="recovery_code" type="text" class="block w-full mt-1" v-model="form.recovery_code" autocomplete="one-time-code" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <button type="button" class="text-sm text-gray-600 underline cursor-pointer hover:text-gray-900" @click.prevent="toggleRecovery">
                    <template v-if="! recovery">
                        Use a recovery code
                    </template>

                    <template v-else>
                        Use an authentication code
                    </template>
                </button>

                <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Login
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
    import { inject, nextTick, ref } from 'vue'
    import { useForm } from '@inertiajs/inertia-vue3'

    export default {
        components: {
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetLabel,
            JetValidationErrors,
        },
        setup() {
            const form = useForm({ code: '', recovery_code: '' })
            const recovery = ref(false)
            const code = ref(null)
            const recovery_code = ref(null)
            const submit = () => form.value.post(route('two-factor.login'))
            const toggleRecovery = async () => {
                recovery.value = true
                await nextTick()
                if (recovery.value) {
                    recovery_code.value.focus()
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
                recovery_code,
                submit,
                toggleRecovery,
            }
        },
    }
</script>
