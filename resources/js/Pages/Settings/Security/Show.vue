<template>
    <app-settings-layout>
        <div v-if="page.props.value.jetstream.canUpdatePassword && page.props.value.socialstream.hasPassword">
            <update-password-form />

            <form-section-border />
        </div>

        <div v-else>
            <set-password-form class="mt-6 sm:mt-0" />

            <form-section-border />
        </div>

        <div v-if="page.props.value.jetstream.canManageTwoFactorAuthentication && page.props.value.socialstream.hasPassword">
            <two-factor-authentication-form class="mt-6 sm:mt-0" />
        </div>
    </app-settings-layout>
</template>

<script>
    import AppSettingsLayout from '@/Layouts/Settings'
    import FormSectionBorder from '@/Components/Form/SectionBorder'
    import SetPasswordForm from './SetPasswordForm'
    import TwoFactorAuthenticationForm from './TwoFactorAuthenticationForm'
    import UpdatePasswordForm from './UpdatePasswordForm'
    import { usePage } from '@inertiajs/inertia-vue3'
    import { useHead } from '@vueuse/head'

    export default {
        components: {
            AppSettingsLayout,
            FormSectionBorder,
            SetPasswordForm,
            TwoFactorAuthenticationForm,
            UpdatePasswordForm,
        },
        setup() {
            const page = usePage()

            useHead({ title: 'Security Settings — Py' })

            return { page }
        },
    }
</script>
