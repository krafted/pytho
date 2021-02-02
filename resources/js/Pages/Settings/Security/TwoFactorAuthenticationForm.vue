<template>
    <f-action-section>
        <template #title>
            Two Factor Authentication
        </template>

        <template #description>
            Add additional security to your account using two factor authentication.
        </template>

        <template #content>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200" v-if="twoFactorEnabled">
                You have enabled two factor authentication.
            </h3>

            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200" v-else>
                You have not enabled two factor authentication.
            </h3>

            <div class="max-w-xl mt-1 text-sm text-gray-600 dark:text-gray-400">
                <p>
                    When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone's Google Authenticator application.
                </p>
            </div>

            <div v-if="twoFactorEnabled">
                <div v-if="qrCode">
                    <div class="max-w-xl mt-3 text-sm text-gray-600 dark:text-gray-400">
                        <p class="font-semibold">
                            Two factor authentication is now enabled. Scan the following QR code using your phone's authenticator application.
                        </p>
                    </div>

                    <div class="w-56 p-4 mt-3 bg-gray-100 rounded-md dark:bg-gray-800" v-html="qrCode">
                    </div>
                </div>

                <div v-if="recoveryCodes.length > 0">
                    <div class="max-w-xl mt-4 text-sm text-gray-600 dark:text-gray-400">
                        <p class="font-semibold">
                            Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.
                        </p>
                    </div>

                    <div class="grid max-w-xl gap-1 px-4 py-3 mt-3 font-mono text-sm text-gray-900 bg-gray-100 rounded-md dark:bg-gray-800 dark:text-gray-300">
                        <div v-for="code in recoveryCodes" :key="code">
                            {{ code }}
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <template #actions>
            <div v-if="!twoFactorEnabled">
                <x-confirms-password @confirmed="enableTwoFactorAuthentication">
                    <x-button type="button" :class="{ 'opacity-25': enabling }" :disabled="enabling">
                        Enable
                    </x-button>
                </x-confirms-password>
            </div>

            <div v-else>
                <x-confirms-password @confirmed="regenerateRecoveryCodes">
                    <x-button
                        v-if="recoveryCodes.length > 0"
                        class="mr-3"
                    >
                        Regenerate Recovery Codes
                    </x-button>
                </x-confirms-password>

                <x-confirms-password @confirmed="showRecoveryCodes">
                    <x-button
                        v-if="recoveryCodes.length === 0"
                        class="mr-3"
                    >
                        Show Recovery Codes
                    </x-button>
                </x-confirms-password>

                <x-confirms-password @confirmed="disableTwoFactorAuthentication">
                    <x-danger-button
                        :class="{ 'opacity-25': disabling }"
                        :disabled="disabling"
                    >
                        Disable
                    </x-danger-button>
                </x-confirms-password>
            </div>
        </template>
    </f-action-section>
</template>

<script>
    import FActionSection from '@/Components/Form/ActionSection'
    import XButton from '@/Components/Button'
    import XConfirmsPassword from '@/Components/ConfirmsPassword'
    import XDangerButton from '@/Components/DangerButton'
    import { Inertia } from '@inertiajs/inertia'
    import { usePage } from '@inertiajs/inertia-vue3'
    import { computed, ref } from 'vue'

    export default {
        components: {
            FActionSection,
            XButton,
            XConfirmsPassword,
            XDangerButton,
        },
        setup() {
            const page = usePage()
            const enabling = ref(false)
            const disabling = ref(false)
            const qrCode = ref(null)
            const recoveryCodes = ref([])
            const twoFactorEnabled = computed(() => !enabling.value && page.props.value.user.two_factor_enabled)
            const enableTwoFactorAuthentication = () => {
                enabling.value = true

                Inertia.post('/user/two-factor-authentication', {}, {
                    preserveScroll: true,
                    onSuccess: () => Promise.all([showQrCode(), showRecoveryCodes()]),
                    onFinish: () => enabling.value = false,
                })
            }
            const showQrCode = () => axios.get('/user/two-factor-qr-code')
                .then(response => qrCode.value = response.data.svg)
            const showRecoveryCodes = () => axios.get('/user/two-factor-recovery-codes')
                .then(response => recoveryCodes.value = response.data)
            const regenerateRecoveryCodes = () => axios.post('/user/two-factor-recovery-codes')
                .then(response => showRecoveryCodes())
            const disableTwoFactorAuthentication = () => {
                disabling.value = true

                Inertia.delete('/user/two-factor-authentication', {
                    preserveScroll: true,
                    onSuccess: () => disabling.value = false,
                })
            }

            return {
                enabling,
                disabling,
                qrCode,
                recoveryCodes,
                twoFactorEnabled,
                enableTwoFactorAuthentication,
                showQrCode,
                showRecoveryCodes,
                regenerateRecoveryCodes,
                disableTwoFactorAuthentication,
            }
        },
    }
</script>
