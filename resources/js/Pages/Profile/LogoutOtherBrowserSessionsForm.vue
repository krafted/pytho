<template>
    <form-action-section>
        <template #title>
            Browser Sessions
        </template>

        <template #description>
            Manage and logout your active sessions on other browsers and devices.
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
                If necessary, you may logout of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.
            </div>

            <!-- Other Browser Sessions -->
            <div class="mt-3 space-y-3" v-if="sessions.length > 0">
                <div class="flex items-center" v-for="(session, i) in sessions" :key="i">
                    <div>
                        <svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" class="w-8 h-8 text-gray-500" v-if="session.agent.is_desktop">
                            <path d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-gray-500" v-else>
                            <path d="M0 0h24v24H0z" stroke="none"></path><rect x="7" y="4" width="10" height="16" rx="1"></rect><path d="M11 5h2M12 17v.01"></path>
                        </svg>
                    </div>

                    <div class="ml-3">
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            {{ session.agent.platform }} - {{ session.agent.browser }}
                        </div>

                        <div>
                            <div class="text-xs text-gray-500">
                                {{ session.ip_address }},

                                <span class="font-semibold text-green-500" v-if="session.is_current_device">This device</span>
                                <span v-else>Last active {{ session.last_active }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Logout Other Devices Confirmation Modal -->
            <app-modal
                :show="confirmingLogout"
                @close="closeModal"
            >
                <template #icon>
                    <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-gray-100 rounded-full dark:bg-black sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="w-6 h-6 text-gray-600 dark:text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                </template>

                <template #title>
                    Logout Other Browser Sessions
                </template>

                <template #content>
                    <div>
                        <div class="text-sm text-gray-500">
                            Please enter your password to confirm you would like to logout of your other browser sessions across all of your devices.
                        </div>

                        <div class="mt-3 space-y-1">
                            <form-input
                                label="Password"
                                type="password"
                                ref="password"
                                v-model="form.password"
                                @keyup.enter.native="logoutOtherBrowserSessions"
                            />

                            <form-input-error :message="form.errors.password" />
                        </div>
                    </div>
                </template>

                <template #actions>
                    <app-button class="ml-3" @click.native="logoutOtherBrowserSessions" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Logout Other Browser Sessions
                    </app-button>

                    <app-secondary-button @click.native="closeModal">
                        Nevermind
                    </app-secondary-button>
                </template>
            </app-modal>
        </template>

        <template #actions>
            <form-action-message :on="form.recentlySuccessful">
                Done
            </form-action-message>

            <app-button @click.native="confirmLogout" class="ml-3">
                Logout Other Browser Sessions
            </app-button>
        </template>
    </form-action-section>
</template>

<script>
    import AppButton from '@/Components/Button'
    import AppModal from '@/Components/Modal'
    import AppSecondaryButton from '@/Components/SecondaryButton'
    import FormActionMessage from '@/Components/Form/ActionMessage'
    import FormActionSection from '@/Components/Form/ActionSection'
    import FormInput from '@/Components/Form/Input'
    import FormInputError from '@/Components/Form/InputError'
    import { inject, provide, ref } from 'vue'
    import { useForm } from '@inertiajs/inertia-vue3'

    export default {
        props: ['sessions'],
        components: {
            AppButton,
            AppModal,
            AppSecondaryButton,
            FormActionMessage,
            FormActionSection,
            FormInput,
            FormInputError,
        },
        setup() {
            const form = useForm({ password: '' })
            const confirmingLogout = ref(false)
            const password = ref(null)
            const confirmLogout = () => {
                confirmingLogout.value = true
                setTimeout(() => password.value.focus(), 250)
            }
            const logoutOtherBrowserSessions = () => {
                form.value.delete(route('other-browser-sessions.destroy'), {
                    preserveScroll: true,
                    onSuccess: () => closeModal(),
                    onError: () => password.value.focus(),
                    onFinish: () => form.value.reset(),
                })
            }
            const closeModal = () => {
                confirmingLogout.value = false
                form.value.reset()
            }

            return {
                closeModal,
                confirmingLogout,
                confirmLogout,
                form,
                logoutOtherBrowserSessions,
                password,
            }
        },
    }
</script>
