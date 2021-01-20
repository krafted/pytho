<template>
    <button
        class="flex items-center justify-center p-2.5 text-gray-500 dark:text-gray-700 border border-transparent rounded-md group hover:w-auto hover:bg-gray-200 dark:hover:bg-black focus:bg-gray-200 dark:focus:bg-black focus:border-gray-300 dark:focus:border-gray-800 hover:border-gray-300 dark:hover:border-gray-800 hover:text-gray-900 dark:hover:text-gray-400 focus:text-gray-900 dark:focus:text-gray-400 focus:outline-none focus:w-auto"
        :title="isMac ? '⌘ + S' : '⌃ + S'"
        @click="show = true"
    >
        <span class="sr-only">Save</span>

        <span
            v-if="!isMobile"
            class="flex-shrink-0 hidden mr-2 text-sm group-hover:inline group-focus:inline"
        >
            Save
        </span>

        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
        </svg>

        <transition
            enter-active-class="duration-300 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
        >
            <span
                v-if="dirty || error"
                class="absolute w-1 h-1 transition-opacity rounded-full bottom-0.5 inline-block group-hover:hidden"
                :class="error ? 'bg-red-500' : 'bg-primary-500'"
            />
        </transition>
    </button>

    <app-modal
        :show="show"
        type="form"
        @close="show = false"
        @submitted="save"
    >
        <template #icon>
            <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-gray-100 rounded-full dark:bg-black sm:mx-0 sm:h-10 sm:w-10">
                <svg class="w-6 h-6 text-gray-600 dark:text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                </svg>
            </div>
        </template>

        <template #title>
            Save
        </template>

        <template #content>
            <div class="grid grid-cols-1 gap-3">
                <div class="space-y-1">
                    <form-url-input
                        ref="url"
                        label="URL"
                        :prepend="page.props.value.appUrl"
                        v-model="form.slug"
                    />
                    <form-input-error :message="form.errors.slug" />
                </div>

                <div class="space-y-1">
                    <form-input
                        label="Title"
                        v-model="form.title"
                    />
                    <form-input-error :message="form.errors.title" />
                </div>

                <div class="space-y-1">
                    <form-textarea
                        label="Description"
                        v-model="form.description"
                    />
                    <form-input-error :message="form.errors.description" />
                </div>

                <div class="space-y-1">
                    <form-listbox
                        label="Visibility"
                        :options="visibilityOptions"
                        v-model="form.visibility"
                    >
                        <template #option="{ option }">
                            <div>
                                <div class="flex items-center">
                                    <div class="text-sm font-semibold">
                                        {{ option.label }}
                                    </div>
                                </div>

                                <div class="mt-1 text-xs">
                                    {{ option.description }}
                                </div>
                            </div>
                        </template>
                    </form-listbox>
                    <form-input-error :message="form.errors.visibility" />
                </div>
            </div>
        </template>

        <template #actions>
            <app-secondary-button
                type="button"
                @click="show = false"
            >
                Close
            </app-secondary-button>

            <app-button
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                Save
            </app-button>
        </template>
    </app-modal>
</template>

<script>
    import AppButton from '@/Components/Button'
    import AppModal from '@/Components/Modal'
    import AppSecondaryButton from '@/Components/SecondaryButton'
    import FormInput from '@/Components/Form/Input'
    import FormInputError from '@/Components/Form/InputError'
    import FormListbox from '@/Components/Form/Listbox'
    import FormTextarea from '@/Components/Form/Textarea'
    import FormUrlInput from '@/Components/Form/UrlInput'
    import { inject, onMounted, onUnmounted, ref, watchEffect } from 'vue'
    import hotkeys from 'hotkeys-js'
    import { Inertia } from '@inertiajs/inertia'
    import { usePage } from '@inertiajs/inertia-vue3'

    export default {
        props: ['isOwner', 'pen', 'slug'],
        components: {
            AppButton,
            AppModal,
            AppSecondaryButton,
            FormInput,
            FormInputError,
            FormListbox,
            FormTextarea,
            FormUrlInput,
        },
        setup(props) {
            const page = usePage()
            const form = inject('form')
            const dirty = inject('dirty')
            const error = inject('error')
            const isMac = inject('isMac')
            const isMobile = inject('isMobile')
            const show = ref(false)
            const url = ref(null)
            const run = inject('run')
            const visibilityOptions = [
                { value: 'public', label: 'Public', description: 'Anyone you send this link to will be able to view it.' },
                { value: 'private', label: 'Private', description: 'You will be the only user that is able to view it.' },
            ]
            const save = async () => {
                const method = props.isOwner && props.pen ? 'put' : 'post'
                const url = props.isOwner && props.pen
                    ? route('pen.update', props.pen)
                    : route('pen.store')
                
                form.value[method](url, { onSuccess: () => (show.value = false, dirty.value = false) })

                await run()
            }

            onMounted(() => {
                hotkeys(isMac.value ? 'cmd+s' : 'ctrl+s', async (event) => {
                    if (props.pen) save()
                    else show.value = true
                    event.preventDefault()
                })
            })
            onUnmounted(() => hotkeys.unbind(isMac.value ? 'cmd+s' : 'ctrl+s'))

            watchEffect(() => {
                if (show.value) url.value.focus()
            })

            return {
                page,
                form,
                dirty,
                error,
                isMac,
                isMobile,
                save,
                show,
                url,
                visibilityOptions,
            }
        }
    }
</script>
