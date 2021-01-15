<template>
    <app-layout>
        <div class="w-full py-6 mx-auto sm:px-4 max-w-7xl">
            <h2 class="px-4 mt-6 text-4xl font-semibold leading-tight text-gray-900 sm:px-0 dark:text-gray-100">
                Profile
            </h2>

            <form-section-border />

            <div
                v-if="page.props.value.jetstream.canUpdateProfileInformation"
                class="mt-6 sm:mt-0"
            >
                <update-profile-information-form :user="page.props.value.user" />

                <form-section-border />
            </div>

            <div v-if="page.props.value.jetstream.canUpdatePassword">
                <update-password-form class="mt-6 sm:mt-0" />

                <form-section-border />
            </div>

            <div v-if="page.props.value.jetstream.canManageTwoFactorAuthentication">
                <two-factor-authentication-form class="mt-6 sm:mt-0" />

                <form-section-border />
            </div>

            <logout-other-browser-sessions-form :sessions="sessions" class="mt-6 sm:mt-0" />

            <template v-if="page.props.value.jetstream.hasAccountDeletionFeatures">
                <form-section-border />

                <delete-user-form class="mt-10 sm:mt-0" />
            </template>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import DeleteUserForm from './DeleteUserForm'
    import FormSectionBorder from '@/Components/Form/SectionBorder'
    import LogoutOtherBrowserSessionsForm from './LogoutOtherBrowserSessionsForm'
    import TwoFactorAuthenticationForm from './TwoFactorAuthenticationForm'
    import UpdatePasswordForm from './UpdatePasswordForm'
    import UpdateProfileInformationForm from './UpdateProfileInformationForm'
    import { usePage } from '@inertiajs/inertia-vue3'

    export default {
        props: ['sessions'],
        components: {
            AppLayout,
            DeleteUserForm,
            FormSectionBorder,
            LogoutOtherBrowserSessionsForm,
            TwoFactorAuthenticationForm,
            UpdatePasswordForm,
            UpdateProfileInformationForm,
        },
        setup() {
            const page = usePage()

            return { page }
        },
    }
</script>
