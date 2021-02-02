<template>
    <l-settings>
        <div v-if="page.props.value.socialstream.show">
            <connected-accounts-form />
        </div>
    </l-settings>
</template>

<script>
    import ConnectedAccountsForm from './ConnectedAccountsForm'
    import LSettings from '@/Layouts/Settings'
    import { usePage } from '@inertiajs/inertia-vue3'
    import { useHead } from '@vueuse/head'

    export default {
        components: {
            ConnectedAccountsForm,
            LSettings,
        },
        setup() {
            const page = usePage()

            useHead({ title: 'Social Settings — Py' })

            return { page }
        },
    }
</script>
