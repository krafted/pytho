<template>
    <div>
        <div
            v-if="show && message"
            :class="{
                'bg-primary-500': style == 'success',
                'bg-red-500': style == 'danger',
            }"
        >
            <div class="px-4 py-2">
                <div class="flex flex-wrap items-center justify-between">
                    <div class="flex items-center flex-1 w-0 min-w-0">
                        <svg class="w-5 h-5 text-primary-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" v-if="style === 'success'">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>

                        <svg class="w-5 h-5 text-red-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" v-if="style === 'danger'">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>

                        <p
                            class="ml-3 text-sm font-medium truncate"
                            :class="{
                                'text-primary-900': style === 'success',
                                'text-red-900': style === 'danger',
                            }"
                        >
                            {{ message }}
                        </p>
                    </div>

                    <div class="flex-shrink-0 sm:ml-3">
                        <button
                            type="button"
                            class="flex p-2 focus:outline-none sm:-mr-2"
                            aria-label="Dismiss"
                            @click.prevent="show = false">
                            <svg
                                class="w-6 h-6"
                                :class="{
                                    'text-primary-900': style === 'success',
                                    'text-red-900': style === 'danger',
                                }"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { computed, ref } from 'vue'
    import { usePage } from '@inertiajs/inertia-vue3'

    export default {
        setup() {
            const page = usePage()
            const show = ref(true)
            const style = computed(() => page.props.value.jetstream.flash?.bannerStyle || 'success')
            const message = computed(() => page.props.value.jetstream.flash?.banner || '')

            return {
                message,
                show,
                style,
            }
        }
    }
</script>
