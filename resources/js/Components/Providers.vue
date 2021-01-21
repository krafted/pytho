<template>
    <div>
        <div class="flex flex-row items-center justify-between py-1 text-gray-400 dark:text-gray-600">
            <hr class="w-full mr-2 border-gray-200 dark:border-gray-700">
            <span class="text-sm font-medium tracking-wide uppercase">Or</span>
            <hr class="w-full ml-2 border-gray-200 dark:border-gray-700">
        </div>

        <div class="flex items-center justify-center">
            <app-button
                v-if="page.props.value.socialstream.providers.includes('github')"
                class="w-full space-x-3"
                :href="route('oauth.redirect', 'github')"
            >
                <icon-github class="w-4 h-4" />
                <span>{{ method || 'Connect' }} with Github</span>
            </app-button>

            <app-button
                v-if="page.props.value.socialstream.providers.includes('gitlab')"
                class="w-full space-x-3"
                :href="route('oauth.redirect', 'gitlab')"
            >
                <icon-github class="w-4 h-4" />
                <span>{{ method || 'Connect' }} with GitLab</span>
            </app-button>
        </div>
    </div>
</template>

<script>
    import AppButton from '@/Components/Button'
    import IconGithub from '@/Icons/Github'
    import IconGitLab from '@/Icons/GitLab'
    import { usePage } from '@inertiajs/inertia-vue3'

    export default {
        props: ['method'],
        components: {
            AppButton,
            IconGithub,
            IconGitLab,
        },
        setup() {
            const page = usePage()

            return { page }
        },
    }
</script>
