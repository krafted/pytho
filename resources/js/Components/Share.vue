<template>
    <button
        class="flex items-center justify-center p-2.5 text-gray-500 dark:text-gray-700 border border-transparent rounded-md group hover:w-auto hover:bg-gray-200 dark:hover:bg-black focus:bg-gray-200 dark:focus:bg-black focus:border-gray-300 dark:focus:border-gray-800 hover:border-gray-300 dark:hover:border-gray-800 hover:text-gray-900 dark:hover:text-gray-400 focus:text-gray-900 dark:focus:text-gray-400 focus:outline-none focus:w-auto"
        @click="show = true"
    >
        <span class="sr-only">Share</span>

        <span
            v-if="!isMobile"
            class="flex-shrink-0 hidden mr-2 text-sm group-hover:inline group-focus:inline"
        >
            Share
        </span>

        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
        </svg>
    </button>

    <app-modal
        :show="show"
        @close="show = false"
    >
        <template #icon>
            <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-gray-100 rounded-full dark:bg-black sm:mx-0 sm:h-10 sm:w-10">
                <svg class="w-6 h-6 text-gray-600 dark:text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
            </div>
        </template>

        <template #title>
            Share
        </template>

        <template #content>
            <div class="grid grid-cols-1 gap-3">
            </div>
        </template>

        <template #actions>
            <app-button
                class="ml-3"
                type="button"
                @click="show = false"
            >
                Share
            </app-button>

            <app-secondary-button
                type="button"
                @click="show = false"
            >
                Close
            </app-secondary-button>
        </template>
    </app-modal>
</template>

<script>
    import AppButton from '@/Components/Button'
    import AppModal from '@/Components/Modal'
    import AppSecondaryButton from '@/Components/SecondaryButton'
    import { inject, onMounted, onUnmounted, ref } from 'vue'
    import hotkeys from 'hotkeys-js'

    export default {
        components: {
            AppButton,
            AppModal,
            AppSecondaryButton,
        },
        setup() {
            const isMac = inject('isMac')
            const isMobile = inject('isMobile')
            const show = ref(false)
            const share = () => {

            }

            onMounted(() => {
                hotkeys(isMac.value ? 'cmd+s' : 'ctrl+s', async (event) => {
                    show.value = true
                    event.preventDefault()
                })
            })
            onUnmounted(() => hotkeys.unbind(isMac.value ? 'cmd+s' : 'ctrl+s'))

            return {
                isMobile,
                share,
                show,
            }
        }
    }
</script>
