<template>
    <teleport to="#modals">
        <transition leave-active-class="duration-200">
            <div
                v-show="show"
                class="fixed inset-0 z-30 overflow-x-hidden overflow-y-auto pb-safe-bottom"
            >
                <div class="flex items-end justify-center min-h-screen p-4 text-center sm:block sm:p-0">
                    <transition
                        enter-active-class="duration-300 ease-out"
                        enter-from-class="opacity-0"
                        enter-to-class="opacity-100"
                        leave-active-class="duration-200 ease-in"
                        leave-from-class="opacity-100"
                        leave-to-class="opacity-0"
                    >
                        <div
                            v-show="show"
                            class="fixed inset-0 transition-all bg-gray-100 bg-opacity-90 backdrop-filter-blur dark:bg-gray-1000 dark:bg-opacity-90"
                            aria-hidden="true"
                            @click="close"
                        />
                    </transition>

                    <!-- This element is to trick the browser into centering the modal contents. -->
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <transition
                        enter-active-class="duration-300 ease-out"
                        enter-from-class="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
                        enter-to-class="translate-y-0 opacity-100 sm:scale-100"
                        leave-active-class="duration-200 ease-in"
                        leave-from-class="translate-y-0 opacity-100 sm:scale-100"
                        leave-to-class="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
                    >
                        <template v-if="type === 'form'">
                            <form
                                v-show="show"
                                class="inline-block w-full text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl dark:bg-gray-900 sm:my-8 sm:align-middle sm:max-w-lg"
                                role="dialog"
                                aria-modal="true"
                                aria-labelledby="modal-headline"
                                @submit.prevent="submit"
                            >
                                <div class="p-4 sm:p-6">
                                    <div class="flex items-start sm:space-x-6">
                                        <div v-if="hasIcon" class="hidden sm:block">
                                            <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-gray-100 rounded-full dark:bg-gray-1000 sm:mx-0 sm:h-10 sm:w-10">
                                                <svg class="w-6 h-6 text-gray-600 dark:text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <slot name="icon" />
                                                </svg>
                                            </div>
                                        </div>

                                        <div class="flex-1">
                                            <header class="flex items-center">
                                                <h3 class="flex items-center text-lg font-semibold leading-6 text-gray-600 dark:text-gray-200 sm:h-10" id="modal-headline">
                                                    <slot name="title" />
                                                </h3>
                                            </header>

                                            <div class="mt-3">
                                                <slot name="content" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-end p-4 space-x-3 bg-gray-100 rounded-b-lg sm:px-6 sm:py-3 dark:bg-gray-800">
                                    <slot name="actions" />
                                </div>
                            </form>
                        </template>

                        <template v-else>
                            <div
                                v-show="show"
                                class="inline-block w-full text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl dark:bg-gray-900 sm:my-8 sm:align-middle sm:max-w-lg"
                                role="dialog"
                                aria-modal="true"
                                aria-labelledby="modal-headline"
                            >
                                <div class="p-4 sm:p-6">
                                    <div class="flex items-start sm:space-x-6">
                                        <div v-if="hasIcon" class="hidden sm:block">
                                            <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-gray-100 rounded-full dark:bg-gray-1000 sm:mx-0 sm:h-10 sm:w-10">
                                                <svg class="w-6 h-6 text-gray-600 dark:text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <slot name="icon" />
                                                </svg>
                                            </div>
                                        </div>

                                        <div class="flex-1">
                                            <header class="flex items-center">
                                                <h3 class="flex items-center text-lg font-semibold leading-6 text-gray-600 dark:text-gray-200 sm:h-10" id="modal-headline">
                                                    <slot name="title" />
                                                </h3>
                                            </header>

                                            <div class="mt-3">
                                                <slot name="content" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-end p-4 space-x-3 bg-gray-100 rounded-b-lg sm:px-6 sm:py-3 dark:bg-gray-800">
                                    <slot name="actions" />
                                </div>
                            </div>
                        </template>
                    </transition>
                </div>
            </div>
        </transition>
    </teleport>
</template>

<script>
    import { computed, inject, onMounted, onUnmounted, watchEffect } from 'vue'
    import hotkeys from 'hotkeys-js'

    export default {
        emits: ['close', 'submitted'],
        props: {
            show: {
                type: Boolean,
                default: false,
            },
            type: {
                type: String,
                default: 'div',
            }
        },
        setup(props, { emit, slots }) {
            const hasIcon = computed(() => !!slots.icon)
            const close = () => emit('close')
            const submit = () => emit('submitted')

            onMounted(() => {
                hotkeys('esc', (event) => {
                    close()
                    event.preventDefault()
                })
            })
            onUnmounted(() => hotkeys.unbind('esc'))

            watchEffect(() => props.show && document.activeElement.blur())

            return {
                hasIcon,
                close,
                submit,
            }
        },
    }
</script>
