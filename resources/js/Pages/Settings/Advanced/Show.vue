<template>
    <l-settings>
        <div v-if="page.props.value.socialstream.hasPassword">
            <logout-other-browser-sessions-form  :sessions="sessions" />
        </div>

        <div v-if="page.props.value.socialstream.hasPassword">
            <f-section-border />

            <delete-user-form class="mt-6 sm:mt-0" />
        </div>
    </l-settings>
</template>

<script>
    import DeleteUserForm from './DeleteUserForm'
    import FSectionBorder from '@/Components/Form/SectionBorder'
    import LSettings from '@/Layouts/Settings'
    import LogoutOtherBrowserSessionsForm from './LogoutOtherBrowserSessionsForm'
    import { usePage } from '@inertiajs/inertia-vue3'
    import { useHead } from '@vueuse/head'

    export default {
        props: ['sessions'],
        components: {
            DeleteUserForm,
            FSectionBorder,
            LSettings,
            LogoutOtherBrowserSessionsForm,
        },
        setup() {
            const page = usePage()

            useHead({ title: 'Advanced Settings — Py' })

            return { page }
        },
    }
</script>
