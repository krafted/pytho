<template>
    <app-settings-layout>
        <div v-if="page.props.value.socialstream.hasPassword">
            <logout-other-browser-sessions-form  :sessions="sessions" />
        </div>

        <div v-if="page.props.value.socialstream.hasPassword">
            <form-section-border />

            <delete-user-form class="mt-6 sm:mt-0" />
        </div>
    </app-settings-layout>
</template>

<script>
    import AppSettingsLayout from '@/Layouts/Settings'
    import DeleteUserForm from './DeleteUserForm'
    import LogoutOtherBrowserSessionsForm from './LogoutOtherBrowserSessionsForm'
    import FormSectionBorder from '@/Components/Form/SectionBorder'
    import { usePage } from '@inertiajs/inertia-vue3'
    import { useHead } from '@vueuse/head'

    export default {
        props: ['sessions'],
        components: {
            AppSettingsLayout,
            DeleteUserForm,
            FormSectionBorder,
            LogoutOtherBrowserSessionsForm,
        },
        setup() {
            const page = usePage()

            useHead({ title: 'Advanced Settings — Py' })

            return { page }
        },
    }
</script>
