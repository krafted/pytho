<template>
    <f-section @submitted="setPassword">
        <template #title>
            Set Password
        </template>

        <template #description>
            Ensure your account is using a long, random password to stay secure.
        </template>

        <template #form>
            <div class="col-span-6 space-y-1 sm:col-span-4">
                <f-input
                    label="New Password"
                    autocomplete="new-password"
                    ref="password"
                    type="password"
                    v-model="form.password"
                />

                <f-input-error :message="form.errors.password" />
            </div>

            <div class="col-span-6 space-y-1 sm:col-span-4">
                <f-input
                    label="Confirm Password"
                    autocomplete="new-password"
                    type="password"
                    v-model="form.password_confirmation"
                />

                <f-input-error :message="form.errors.password_confirmation" />
            </div>
        </template>

        <template #actions>
            <f-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved
            </f-action-message>

            <x-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </x-button>
        </template>
    </f-section>
</template>

<script>
    import FActionMessage from '@/Components/Form/ActionMessage'
    import FInput from '@/Components/Form/Input'
    import FInputError from '@/Components/Form/InputError'
    import FSection from '@/Components/Form/Section'
    import XButton from '@/Components/Button'
    import { ref } from 'vue'
    import { useForm } from '@inertiajs/inertia-vue3'

    export default {
        components: {
            FActionMessage,
            FInput,
            FInputError,
            FSection,
            XButton,
        },
        setup() {
            const form = useForm({
                password: '',
                password_confirmation: '',
            })
            const password = ref(null)
            const setPassword = () => {
                form.value.put(route('user-password.set'), {
                    errorBag: 'setPassword',
                    preserveScroll: true,
                    onSuccess: () => form.value.reset(),
                    onError: () => {
                        if (form.value.errors.password) {
                            form.value.reset('password', 'password_confirmation')
                            password.value.focus()
                        }
                    }
                })
            }

            return {
                form,
                password,
                setPassword,
            }
        },
    }
</script>
