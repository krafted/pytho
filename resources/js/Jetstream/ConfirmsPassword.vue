<template>
    <span>
        <span @click="startConfirmingPassword">
            <slot />
        </span>

        <jet-dialog-modal :show="confirmingPassword" @close="closeModal">
            <template #title>
                {{ title }}
            </template>

            <template #content>
                {{ content }}

                <div class="mt-4">
                    <jet-input type="password" class="block w-3/4 mt-1" placeholder="Password"
                                ref="password"
                                v-model="form.password"
                                @keyup.enter.native="confirmPassword" />

                    <jet-input-error :message="form.error" class="mt-2" />
                </div>
            </template>

            <template #footer>
                <jet-secondary-button @click.native="closeModal">
                    Nevermind
                </jet-secondary-button>

                <jet-button class="ml-2" @click.native="confirmPassword" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    {{ button }}
                </jet-button>
            </template>
        </jet-dialog-modal>
    </span>
</template>

<script>
    import { nextTick, ref } from 'vue'
    import JetButton from './Button'
    import JetDialogModal from './DialogModal'
    import JetInput from './Input'
    import JetInputError from './InputError'
    import JetSecondaryButton from './SecondaryButton'

    export default {
        emits: ['confirmed'],
        props: {
            title: {
                default: 'Confirm Password',
            },
            content: {
                default: 'For your security, please confirm your password to continue.',
            },
            button: {
                default: 'Confirm',
            }
        },
        components: {
            JetButton,
            JetDialogModal,
            JetInput,
            JetInputError,
            JetSecondaryButton,
        },
        setup(_, { emit }) {
            const password = ref(null)
            const confirmingPassword = ref(false)
            const form = ref({
                password: '',
                email: '',
            })
            const startConfirmingPassword = () => {
                axios.get(route('password.confirmation')).then(response => {
                    if (response.data.confirmed) emit('confirmed')
                    else {
                        confirmingPassword.value = true

                        setTimeout(() => password.value.focus(), 250)
                    }
                })
            }
            const confirmPassword = () => {
                form.value.processing = true

                axios.post(route('password.confirm'), {
                    password: form.value.password,
                }).then(async () => {
                    form.value.processing = false
                    closeModal()
                    await nextTick()
                    emit('confirmed')
                }).catch(error => {
                    form.value.processing = false
                    form.value.error = error.response.data.errors.password[0]
                    password.value.focus()
                })
            }
            const closeModal = () => {
                confirmingPassword.value = false
                form.value.password = ''
                form.value.error = ''
            }

            return {
                closeModal,
                confirmingPassword,
                confirmPassword,
                form,
                password,
                startConfirmingPassword,
            }
        },
    }
</script>
