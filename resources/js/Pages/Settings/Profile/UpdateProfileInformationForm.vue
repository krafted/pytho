<template>
    <form-section @submitted="updateProfileInformation">
        <template #title>
            Profile Information
        </template>

        <template #description>
            Update your account's profile information and email address.
        </template>

        <template #form>
            <!-- Profile Photo -->
            <div
                v-if="page.props.value.jetstream.managesProfilePhotos"
                class="col-span-6 p-4 bg-gray-100 rounded-md dark:bg-gray-800 sm:col-span-4"
            >
                <!-- Profile Photo File Input -->
                <input
                    class="hidden"
                    type="file"
                    ref="photo"
                    @change="updatePhotoPreview"
                />

                <div class="flex items-center">
                    <!-- Current Profile Photo -->
                    <button
                        v-show="!photoPreview"
                        class="overflow-hidden border-2 border-gray-200 rounded-full dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-gray-100 dark:focus:ring-offset-gray-900 ring-offset-2 group"
                        type="button"
                        @click="selectNewPhoto"
                    >
                        <img
                            class="object-cover w-24 h-24"
                            :src="`${user.profile_photo_url}`"
                            :alt="user.name"
                        />

                        <div class="absolute inset-0 flex items-center justify-center p-6 transition-opacity duration-200 ease-in-out bg-white bg-opacity-75 rounded-full opacity-0 dark:bg-gray-1000 dark:bg-opacity-75 group-hover:opacity-100 group-focus:opacity-100 backdrop-filter-blur">
                            <span class="font-semibold tracking-wide text-gray-300 uppercase text-2xs">Update Photo</span>
                        </div>
                    </button>

                    <!-- New Profile Photo Preview -->
                    <button
                        v-show="photoPreview"
                        class="overflow-hidden border-2 border-gray-200 rounded-full dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-gray-100 dark:focus:ring-offset-gray-900 ring-offset-2 group"
                        type="button"
                        @click="selectNewPhoto"
                    >
                        <span class="block w-24 h-24"
                            :style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                        </span>

                        <div class="absolute inset-0 flex items-center justify-center p-6 transition-opacity duration-200 ease-in-out bg-white bg-opacity-75 rounded-full opacity-0 dark:bg-gray-1000 dark:bg-opacity-75 group-hover:opacity-100 group-focus:opacity-100 backdrop-filter-blur">
                            <span class="font-semibold tracking-wide text-gray-300 uppercase text-2xs">Update Photo</span>
                        </div>
                    </button>
                    
                    <div class="flex flex-col ml-3 space-y-3">
                        <app-button type="button" @click.native.prevent="selectNewPhoto">
                            Select A New Photo
                        </app-button>

                        <app-button type="button" @click.native.prevent="deletePhoto" v-if="user.profile_photo_path">
                            Remove Photo
                        </app-button>
                    </div>
                </div>

                <form-input-error :message="form.errors.photo" class="mt-2" />
            </div>

            <!-- Name -->
            <div class="col-span-6 space-y-1 sm:col-span-4">
                <form-input
                    label="Name"
                    autocomplete="name"
                    v-model="form.name"
                />

                <form-input-error :message="form.errors.name" />
            </div>

            <!-- Username -->
            <div class="col-span-6 space-y-1 sm:col-span-4">
                <form-input
                    label="Username"
                    v-model="form.username"
                />

                <form-input-error :message="form.errors.username" />
            </div>

            <!-- Email -->
            <div class="col-span-6 space-y-1 sm:col-span-4">
                <form-input
                    label="Email"
                    type="email"
                    v-model="form.email"
                />

                <form-input-error :message="form.errors.email" />
            </div>
        </template>

        <template #actions>
            <form-action-message :on="form.recentlySuccessful">
                Saved
            </form-action-message>

            <app-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </app-button>
        </template>
    </form-section>
</template>

<script>
    import AppButton from '@/Components/Button'
    import FormActionMessage from '@/Components/Form/ActionMessage'
    import FormInput from '@/Components/Form/Input'
    import FormInputError from '@/Components/Form/InputError'
    import FormSection from '@/Components/Form/Section'
    import { inject, ref } from 'vue'
    import { Inertia } from '@inertiajs/inertia'
    import { useForm, usePage } from '@inertiajs/inertia-vue3'

    export default {
        props: ['user'],
        components: {
            AppButton,
            FormActionMessage,
            FormInput,
            FormInputError,
            FormSection,
        },
        setup(props) {
            const page = usePage()
            const form = useForm({
                _method: 'PUT',
                name: props.user.name,
                username: props.user.username,
                email: props.user.email,
                photo: null,
            })
            const photo = ref(null)
            const photoPreview = ref(null)
            const updateProfileInformation = () => {
                if (photo.value) form.value.photo = photo.value.files[0]

                form.value.post(route('user-profile-information.update'), {
                    errorBag: 'updateProfileInformation',
                    preserveScroll: true
                })
            }
            const selectNewPhoto = () => photo.value.click()
            const updatePhotoPreview = () => {
                const reader = new FileReader();

                reader.onload = (e) => photoPreview.value = e.target.result
                reader.readAsDataURL(photo.value.files[0])
            }
            const deletePhoto = () => {
                Inertia.delete(route('current-user-photo.destroy'), {
                    preserveScroll: true,
                    onSuccess: () => photoPreview.value = null,
                })
            }

            return {
                page,
                form,
                photo,
                photoPreview,
                updateProfileInformation,
                selectNewPhoto,
                updatePhotoPreview,
                deletePhoto,
            }
        },
    }
</script>
