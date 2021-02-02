<template>
    <f-action-section>
        <template #title>
            Connected Accounts
        </template>

        <template #description>
            Manage and remove your connected accounts.
        </template>

        <template #content>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200" v-if="page.props.value.socialstream.connectedAccounts.length === 0">
                You have no connected accounts.
            </h3>

            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200" v-else>
                Your connected accounts.
            </h3>

            <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
                You are free to connect Github to your profile and may remove that connection at any time. If you feel Github has been compromised, you should disconnect it immediately and change your password.
            </div>

            <div class="-mx-6 -mb-6 divide-y divide-gray-100 dark:divide-gray-800">
                <div class="p-6" v-for="(provider) in page.props.value.socialstream.providers" :key="provider">
                    <x-connected-account v-if="hasAccountForProvider(provider)" :provider="getAccountForProvider(provider).provider" :created-at="getAccountForProvider(provider).created_at">
                        <template #action>
                            <button
                                v-if="page.props.value.socialstream.canRemoveAccounts || page.props.value.socialstream.hasPassword"
                                class="text-sm font-semibold tracking-wide text-red-500 uppercase focus:outline-none focus:ring-2 focus:ring-red-500"
                                @click="confirmRemove(provider, getAccountForProvider(provider).id)"
                            >
                                Remove
                            </button>
                        </template>
                    </x-connected-account>

                    <x-connected-account v-else :provider="provider">
                        <template #action>
                            <a
                                class="text-sm font-semibold tracking-wide text-gray-500 uppercase focus:outline-none focus:ring-2 focus:ring-primary-500"
                                :href="route('oauth.redirect', { provider })"
                                @click="confirmRemove(provider, getAccountForProvider(provider).id)"
                            >
                                Connect
                            </a>
                        </template>
                    </x-connected-account>
                </div>
            </div>

            <!-- Confirmation Modal -->
            <x-modal
                :show="confirmingRemove"
                @close="confirmingRemove = false"
            >
                <template #icon>
                    <path v-if="currentProvider === 'github'" d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22" />
                    <path v-if="currentProvider === 'gitlab'" d="M22.65 14.39L12 22.13 1.35 14.39a.84.84 0 0 1-.3-.94l1.22-3.78 2.44-7.51A.42.42 0 0 1 4.82 2a.43.43 0 0 1 .58 0 .42.42 0 0 1 .11.18l2.44 7.49h8.1l2.44-7.51A.42.42 0 0 1 18.6 2a.43.43 0 0 1 .58 0 .42.42 0 0 1 .11.18l2.44 7.51L23 13.45a.84.84 0 0 1-.35.94z" />
                </template>

                <template #title>
                    Remove Connected Account
                </template>

                <template #content>
                    <div class="text-sm text-gray-500">
                        Please confirm your removal of this account - this action cannot be undone.
                    </div>
                </template>

                <template #actions>
                    <x-secondary-button @click.native="confirmingRemove = false">
                        Close
                    </x-secondary-button>

                    <x-danger-button @click.native="removeConnectedAccount(accountId)" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Remove Connected Account
                    </x-danger-button>
                </template>
            </x-modal>
        </template>
    </f-action-section>
</template>

<script>
    import FActionSection from '@/Components/Form/ActionSection'
    import XDangerButton from '@/Components/DangerButton'
    import XConnectedAccount from '@/Components/ConnectedAccount'
    import XModal from '@/Components/Modal'
    import XSecondaryButton from '@/Components/SecondaryButton'
    import { ref } from 'vue'
    import { useForm, usePage } from '@inertiajs/inertia-vue3'

    export default {
        components: {
            FActionSection,
            XConnectedAccount,
            XDangerButton,
            XModal,
            XSecondaryButton,
        },
        setup() {
            const page = usePage()
            const form = useForm({ '_method': 'DELETE' }, { bag: 'removeConnectedAccount' })
            const confirmingRemove = ref(false)
            const accountId = ref(null)
            const currentProvider = ref('')
            const confirmRemove = (provider, id) => {
                currentProvider.value = provider
                form.value.password = ''
                accountId.value = id
                confirmingRemove.value = true
            }
            const hasAccountForProvider = provider => page.props.value.socialstream.connectedAccounts.filter(account => account.provider === provider).length > 0
            const getAccountForProvider = provider => {
                if (hasAccountForProvider(provider)) return page.props.value.socialstream.connectedAccounts.filter(account => account.provider === provider).shift()

                return null
            }
            const removeConnectedAccount = id => {
                form.value.post(route('connected-accounts.destroy', { id }), {
                    preserveScroll: true,
                    onSuccess: () => (confirmingRemove.value = false)
                })
            }

            return {
                page,
                form,
                accountId,
                confirmRemove,
                confirmingRemove,
                currentProvider,
                getAccountForProvider,
                hasAccountForProvider,
                removeConnectedAccount,
            }
        },
    }
</script>
