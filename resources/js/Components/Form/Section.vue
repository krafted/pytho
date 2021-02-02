<template>
    <div class="mt-6 md:grid md:grid-cols-3 md:gap-6 sm:mt-0">
        <f-section-title>
            <template #title><slot name="title"></slot></template>
            <template #description><slot name="description"></slot></template>
        </f-section-title>

        <div class="mt-6 md:mt-0 md:col-span-2">
            <form @submit.prevent="$emit('submitted')">
                <div class="bg-white border-t border-b border-gray-100 sm:border-r sm:border-l dark:border-gray-800 dark:bg-gray-900 sm:rounded-lg">
                    <div class="grid grid-cols-6 gap-3 p-4 sm:p-6">
                        <slot name="form"></slot>
                    </div>

                    <div
                        v-if="hasActions"
                        class="flex items-center justify-end p-4 space-x-3 bg-gray-100 sm:rounded-b-lg sm:px-6 sm:py-3 dark:bg-gray-800"
                    >
                        <slot name="actions"></slot>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import { computed } from 'vue'
    import FSectionTitle from '@/Components/Form/SectionTitle'

    export default {
        emits: ['submitted'],
        components: { FSectionTitle },
        setup(_, { slots }) {
            const hasActions = computed(() => !!slots.actions)

            return { hasActions }
        },
    }
</script>
