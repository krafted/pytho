<template>
    <button
        class="flex items-center justify-center p-2.5 text-gray-600 dark:text-gray-400 border border-white bg-white dark:bg-gray-900 dark:border-gray-900 rounded-md group hover:w-auto hover:bg-gray-200 dark:hover:bg-gray-1000 focus:bg-gray-200 dark:focus:bg-gray-1000 focus:border-gray-300 dark:focus:border-gray-600 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-900 dark:hover:text-gray-200 focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-200 dark:focus:ring-offset-gray-900 focus:ring-primary-500 focus:outline-none focus:w-auto"
        @click="show = true"
    >
        <span class="sr-only">Details</span>

        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>

        <span
            v-if="!isMobile"
            class="flex-shrink-0 hidden ml-2 text-sm group-hover:inline group-focus:inline"
        >
            Details
        </span>
    </button>

    <x-modal
        :show="show"
        @close="show = false"
    >
        <template #icon>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </template>

        <template #title>
            Details
        </template>

        <template #content>
            <div class="grid grid-cols-1 gap-3">
                <f-field
                    label="Creator"
                    :value="pen.creator?.name || 'Anonymous'"
                >
                    <template #value="{ value }">
                        <inertia-link
                            v-if="pen.creator"
                            class="hover:underline focus:ring-2 focus:ring-primary-500"
                            :href="route('profile.show', pen.creator.username)"
                        >
                            {{ value }}

                            <span
                                v-if="pen.creator.username"
                                class="text-gray-500"
                            >
                                @{{ pen.creator.username }}
                            </span>
                        </inertia-link>

                        <span v-else>{{ value }}</span>
                    </template>
                </f-field>

                <f-field
                    label="Title"
                    :value="pen.title || 'Untitled'"
                />

                <f-field
                    label="Description"
                    :value="pen.description || 'No description'"
                />
            </div>
        </template>

        <template #actions>
            <x-secondary-button
                type="button"
                @click="show = false"
            >
                Close
            </x-secondary-button>
        </template>
    </x-modal>
</template>

<script>
    import FField from '@/Components/Form/Field'
    import XButton from '@/Components/Button'
    import XModal from '@/Components/Modal'
    import XSecondaryButton from '@/Components/SecondaryButton'
    import { inject, ref } from 'vue'

    export default {
        props: ['pen'],
        components: {
            FField,
            XButton,
            XModal,
            XSecondaryButton,
        },
        setup(props) {
            const isMobile = inject('isMobile')
            const show = ref(false)

            return {
                isMobile,
                show,
            }
        },
    }
</script>
