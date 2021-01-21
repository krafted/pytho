<template>
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <icon-github v-if="provider === 'github'" class="w-8 h-8 text-gray-500" />
            <icon-git-lab v-if="provider === 'gitlab'" class="w-8 h-8 text-gray-500" />

            <div class="ml-3">
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    {{ provider.charAt(0).toUpperCase() + provider.slice(1)  }}
                </div>

                <div v-if="createdAt !== null" class="text-xs text-gray-500">
                    Connected {{ createdAt }}
                </div>

                <div v-else class="text-xs text-gray-500">
                    Not connected
                </div>
            </div>
        </div>

        <slot name="action"></slot>
    </div>
</template>

<script>
    import IconGithub from '@/Icons/Github'
    import IconGitLab from '@/Icons/GitLab'

    export default {
        props: {
            provider: String,
            createdAt: {
                type: String,
                default: null,
            }
        },
        components: {
            IconGithub,
            IconGitLab,
        },
    }
</script>
