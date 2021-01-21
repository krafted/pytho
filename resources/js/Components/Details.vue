<template>
    <button
        class="flex items-center justify-center p-2.5 text-gray-500 dark:text-gray-700 border border-transparent rounded-md group hover:w-auto hover:bg-gray-200 dark:hover:bg-black focus:bg-gray-200 dark:focus:bg-black focus:border-gray-300 dark:focus:border-gray-800 hover:border-gray-300 dark:hover:border-gray-800 hover:text-gray-900 dark:hover:text-gray-400 focus:text-gray-900 dark:focus:text-gray-400 focus:outline-none focus:w-auto"
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

    <app-modal
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
                <form-field
                    label="Title"
                    :value="pen.title || 'Untitled'"
                />

                <form-field
                    label="Description"
                    :value="pen.description || 'No description'"
                />
            </div>
        </template>

        <template #actions>
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
    import FormField from '@/Components/Form/Field'
    import { inject, ref } from 'vue'

    export default {
        props: ['pen'],
        components: {
            AppButton,
            AppModal,
            AppSecondaryButton,
            FormField,
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
