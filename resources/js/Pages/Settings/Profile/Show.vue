<template>
    <app-settings-layout>
        <div v-if="page.props.value.jetstream.canUpdateProfileInformation">
            <update-profile-information-form :user="page.props.value.user" />
        </div>
    </app-settings-layout>
</template>

<script>
    import AppSettingsLayout from '@/Layouts/Settings'
    import UpdateProfileInformationForm from './UpdateProfileInformationForm'
    import { usePage } from '@inertiajs/inertia-vue3'
    import { useHead } from '@vueuse/head'

    export default {
        components: {
            AppSettingsLayout,
            UpdateProfileInformationForm,
        },
        setup() {
            const page = usePage()

            useHead({ title: 'Profile Settings — Py' })

            return { page }
        },
    }
</script>
