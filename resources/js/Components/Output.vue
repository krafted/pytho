<template>
    <div
        class="flex-1 mr-safe-right"
        :class="{ 'ml-safe-left': preferences.layout === 'horizontal' }"
        :style="{
            fontSize: `${preferences.fontSize}px`,
            lineHeight: `${preferences.lineHeight}rem`,
        }"
    >
        <textarea
            id="output"
            class="absolute inset-0 flex-shrink-0 w-full h-full px-4 py-1 pb-4 font-mono text-gray-600 bg-transparent border-0 border-none resize-none dark:text-gray-400 leading-inherit text-inherit focus:ring-0 focus:outline-none"
            readonly
            :value="output"
        />

        <transition leave-active-class="duration-200">
            <div
                v-show="show"
                class="absolute inset-0 z-10 flex flex-1 overflow-hidden"
                :class="{ 'ml-safe-left': preferences.layout === 'horizontal' }"
            >
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
                        class="absolute inset-0 flex items-center justify-center flex-1 p-12 overflow-auto transition-opacity bg-gray-100 bg-opacity-25 dark:bg-black dark:bg-opacity-25 backdrop-filter-blur mr-safe-right focus:outline-none"
                    >
                        <transition
                            enter-active-class="duration-300 ease-out delay-300"
                            enter-from-class="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
                            enter-to-class="translate-y-0 opacity-100 sm:scale-100"
                            leave-active-class="duration-200 ease-in delay-200"
                            leave-from-class="translate-y-0 opacity-100 sm:scale-100"
                            leave-to-class="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
                        >
                            <div
                                v-show="show"
                                class="m-auto overflow-hidden bg-gray-100 shadow-xl window dark:bg-gray-900"
                                :class="{
                                    'rounded-lg': isMac,
                                    'rounded-none': !isMac,
                                }"
                            >
                                <header
                                    class="flex items-center window__header"
                                    :class="{
                                        'justify-start p-4': isMac,
                                        'justify-end': !isMac,
                                    }"
                                >
                                    <button
                                        class="inline-flex items-center justify-center group focus:outline-none focus:ring-0 h-"
                                        :class="{
                                            'w-3 h-3 bg-red-400 rounded-full focus:bg-red-300': isMac,
                                            'w-14 h-11 hover:bg-red-400 focus:bg-red-400 transition ease-in-out duration-150': !isMac,
                                        }"
                                        @click="show = false"
                                    >
                                        <svg
                                            :class="{
                                                'w-2 h-2 text-red-900 hidden group-focus:inline group-hover:inline': isMac,
                                                'w-6 h-6 text-gray-500 group-focus:text-white group-hover:text-white transition ease-in-out duration-150': !isMac,
                                            }"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                        >
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </header>

                                <div
                                    class="overflow-auto transition-all transform bg-white focus:outline-none"
                                    :class="{ 'rounded-b-lg': isMac }"
                                >
                                    <div id="canvas" />

                                    <div
                                        class="absolute inset-0"
                                        @click="close"
                                    />
                                </div>
                            </div>
                        </transition>
                    </div>
                </transition>
            </div>
        </transition>
    </div>
</template>

<script>
    import '@interactjs/auto-start'
    import '@interactjs/actions/drag'
    import '@interactjs/inertia'
    import '@interactjs/modifiers'
    import interact from '@interactjs/interact'
    import { inject, onMounted } from 'vue'

    export default {
        setup() {
            const preferences = inject('preferences')
            const isMac = inject('isMac')
            const output = inject('output')
            const show = inject('showCanvas')
            const close = inject('closeCanvas')

            onMounted(() => {
                const position = { x: 0, y: 0 }

                interact('.window')
                    .draggable({
                        allowFrom: '.window__header',
                        inertia: true,
                        listeners: {
                            move (event) {
                                position.x += event.dx
                                position.y += event.dy

                                event.target.style.transform =
                                    `translate(${position.x}px, ${position.y}px)`
                            },
                        },
                        modifiers: [
                            interact.modifiers.restrictRect({
                                restriction: 'parent',
                            }),
                        ],
                    })
            })

            return {
                close,
                isMac,
                output,
                preferences,
                show,
            }
        },
    }
</script>
