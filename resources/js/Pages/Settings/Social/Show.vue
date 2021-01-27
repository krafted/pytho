<template>
    <app-settings-layout>
        <div v-if="page.props.value.socialstream.show">
            <connected-accounts-form />
        </div>
    </app-settings-layout>
</template>

<script>
    import AppSettingsLayout from '@/Layouts/Settings'
    import ConnectedAccountsForm from './ConnectedAccountsForm'
    import { usePage } from '@inertiajs/inertia-vue3'
    import { useHead } from '@vueuse/head'

    export default {
        components: {
            AppSettingsLayout,
            ConnectedAccountsForm,
        },
        setup() {
            const page = usePage()

            useHead({ title: 'Social Settings — Py' })

            return { page }
        },
    }
</script>
