<template>
    <app-layout>
        <div class="w-full py-6 mx-auto sm:px-4 max-w-7xl">
            <h1 class="px-4 mt-6 text-4xl font-semibold leading-tight text-gray-900 sm:px-0 dark:text-gray-100">
                Account
            </h1>

            <form-section-border />

            <div
                v-if="page.props.value.jetstream.canUpdateProfileInformation"
                class="mt-6 sm:mt-0"
            >
                <update-profile-information-form :user="page.props.value.user" />

                <form-section-border />
            </div>

            <div v-if="page.props.value.jetstream.canUpdatePassword && page.props.value.socialstream.hasPassword">
                <update-password-form class="mt-6 sm:mt-0" />

                <form-section-border />
            </div>

            <div v-else>
                <set-password-form class="mt-6 sm:mt-0" />

                <form-section-border />
            </div>

            <div v-if="page.props.value.jetstream.canManageTwoFactorAuthentication && page.props.value.socialstream.hasPassword">
                <two-factor-authentication-form class="mt-10 sm:mt-0" />

                <form-section-border />
            </div>

            <div v-if="page.props.value.socialstream.show">
                <connected-accounts-form class="mt-6 sm:mt-0" />
            </div>

            <div v-if="page.props.value.socialstream.hasPassword">
                <form-section-border />

                <logout-other-browser-sessions-form  :sessions="sessions" class="mt-6 sm:mt-0" />
            </div>

            <div v-if="page.props.value.socialstream.hasPassword">
                <form-section-border />

                <delete-user-form class="mt-6 sm:mt-0" />
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import ConnectedAccountsForm from './ConnectedAccountsForm'
    import DeleteUserForm from './DeleteUserForm'
    import FormSectionBorder from '@/Components/Form/SectionBorder'
    import LogoutOtherBrowserSessionsForm from './LogoutOtherBrowserSessionsForm'
    import SetPasswordForm from './SetPasswordForm'
    import TwoFactorAuthenticationForm from './TwoFactorAuthenticationForm'
    import UpdatePasswordForm from './UpdatePasswordForm'
    import UpdateProfileInformationForm from './UpdateProfileInformationForm'
    import { usePage } from '@inertiajs/inertia-vue3'
    import { useHead } from '@vueuse/head'

    export default {
        props: ['sessions'],
        components: {
            AppLayout,
            ConnectedAccountsForm,
            DeleteUserForm,
            FormSectionBorder,
            LogoutOtherBrowserSessionsForm,
            TwoFactorAuthenticationForm,
            SetPasswordForm,
            UpdatePasswordForm,
            UpdateProfileInformationForm,
        },
        setup() {
            const page = usePage()

            useHead({ title: 'Account Settings — Py' })

            return { page }
        },
    }
</script>
