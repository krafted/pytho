<template>
    <l-app>
        <template #header>
            <h1 class="text-xl font-semibold leading-tight text-gray-800">
                API Tokens
            </h1>
        </template>

        <div>
            <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <api-token-manager :tokens="tokens"
                                   :available-permissions="availablePermissions"
                                   :default-permissions="defaultPermissions" />
            </div>
        </div>
    </l-app>
</template>

<script>
    import ApiTokenManager from '@/Pages/API/ApiTokenManager'
    import LApp from '@/Layouts/App'

    export default {
        props: [
            'tokens',
            'availablePermissions',
            'defaultPermissions',
        ],
        components: {
            ApiTokenManager,
            LApp,
        },
    }
</script>
