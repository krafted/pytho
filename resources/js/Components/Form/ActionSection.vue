<template>
    <div class="mt-6 sm:mt-0 md:grid md:grid-cols-3 md:gap-6">
        <form-section-title>
            <template #title><slot name="title"></slot></template>
            <template #description><slot name="description"></slot></template>
        </form-section-title>

        <div class="mt-6 md:mt-0 md:col-span-2">
            <div class="overflow-hidden bg-white border-t border-b border-gray-100 sm:border-r sm:border-l dark:border-gray-800 dark:bg-gray-900 sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <slot name="content"></slot>
                </div>

                <div
                    v-if="hasActions"
                    class="flex items-center justify-end p-4 space-x-3 bg-gray-100 sm:rounded-b-lg sm:px-6 sm:py-3 dark:bg-gray-800"
                >
                    <slot name="actions"></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import FormSectionTitle from '@/Components/Form/SectionTitle'
    import { computed } from 'vue'

    export default {
        components: { FormSectionTitle },
        setup(_, { slots }) {
            const hasActions = computed(() => !!slots.actions)

            return { hasActions }
        },
    }
</script>
