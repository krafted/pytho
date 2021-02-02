<template>
    <l-settings>
        <div v-if="page.props.value.jetstream.canUpdatePassword && page.props.value.socialstream.hasPassword">
            <update-password-form />

            <f-section-border />
        </div>

        <div v-else>
            <set-password-form class="mt-6 sm:mt-0" />

            <f-section-border />
        </div>

        <div v-if="page.props.value.jetstream.canManageTwoFactorAuthentication && page.props.value.socialstream.hasPassword">
            <two-factor-authentication-form class="mt-6 sm:mt-0" />
        </div>
    </l-settings>
</template>

<script>
    import FSectionBorder from '@/Components/Form/SectionBorder'
    import LSettings from '@/Layouts/Settings'
    import SetPasswordForm from './SetPasswordForm'
    import TwoFactorAuthenticationForm from './TwoFactorAuthenticationForm'
    import UpdatePasswordForm from './UpdatePasswordForm'
    import { usePage } from '@inertiajs/inertia-vue3'
    import { useHead } from '@vueuse/head'

    export default {
        components: {
            FSectionBorder,
            LSettings,
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
