<template>
    <jet-form-section @submitted="updatePassword">
        <template #title>
            Update Password
        </template>

        <template #description>
            Ensure your account is using a long, random password to stay secure.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="current_password" value="Current Password" />
                <jet-input id="current_password" type="password" class="block w-full mt-1" v-model="form.current_password" ref="currentPassword" autocomplete="current-password" />
                <jet-input-error :message="form.errors.current_password" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="password" value="New Password" />
                <jet-input id="password" type="password" class="block w-full mt-1" v-model="form.password" ref="password" autocomplete="new-password" />
                <jet-input-error :message="form.errors.password" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="password_confirmation" value="Confirm Password" />
                <jet-input id="password_confirmation" type="password" class="block w-full mt-1" v-model="form.password_confirmation" autocomplete="new-password" />
                <jet-input-error :message="form.errors.password_confirmation" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetButton from '@/Jetstream/Button'
    import JetFormSection from '@/Jetstream/FormSection'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import { inject, ref } from 'vue'
    import { useForm } from '@inertiajs/inertia-vue3'

    export default {
        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
        },
        setup() {
            const form = useForm({
                current_password: '',
                password: '',
                password_confirmation: '',
            })
            const password = ref(null)
            const currentPassword = ref(null)
            const updatePassword = () => {
                form.value.put(route('user-password.update'), {
                    errorBag: 'updatePassword',
                    preserveScroll: true,
                    onSuccess: () => form.value.reset(),
                    onError: () => {
                        if (form.value.errors.password) {
                            form.value.reset('password', 'password_confirmation')
                            password.value.focus()
                        }
                        if (form.value.errors.current_password) {
                            form.value.reset('current_password')
                            currentPassword.value.focus()
                        }
                    }
                })
            }

            return {
                form,
                password,
                updatePassword,
                currentPassword,
            }
        },
    }
</script>
