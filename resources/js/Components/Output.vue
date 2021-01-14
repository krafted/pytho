<template>
    <div
        class="flex-1 mr-safe-right"
        :class="{ 'ml-safe-left': state.settings.layout === 'horizontal' }"
        :style="{
            fontSize: `${state.settings.fontSize}px`,
            lineHeight: `${state.settings.lineHeight}rem`,
        }"
    >
        <textarea
            id="output"
            class="absolute inset-0 flex-shrink-0 w-full h-full px-4 py-1 pb-4 font-mono text-gray-600 bg-transparent border-0 border-none resize-none dark:text-gray-400 leading-inherit text-inherit focus:ring-0 focus:outline-none"
            readonly
            :value="output"
            @mouseover="dirty = false"
            @click="dirty = false"
            @focus="dirty = false"
        />

        <transition leave-active-class="duration-200">
            <div
                v-show="showCanvas"
                class="absolute inset-0 flex items-center justify-center flex-1 overflow-hidden"
                :class="{ 'ml-safe-left': state.settings.layout === 'horizontal' }"
                @mouseover="dirty = false"
                @click="dirty = false, closeCanvas()"
                @focus="dirty = false"
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
                        v-show="showCanvas"
                        class="absolute inset-0 flex items-center justify-center flex-1 transition-opacity bg-gray-100 bg-opacity-25 dark:bg-black dark:bg-opacity-25 backdrop-filter-blur mr-safe-right focus:outline-none"
                    />
                </transition>

                <transition
                    enter-active-class="duration-300 ease-out"
                    enter-from-class="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
                    enter-to-class="translate-y-0 opacity-100 sm:scale-100"
                    leave-active-class="duration-200 ease-in"
                    leave-from-class="translate-y-0 opacity-100 sm:scale-100"
                    leave-to-class="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
                >
                    <div
                        v-show="showCanvas"
                        id="canvas"
                        class="overflow-auto transition-all transform bg-white rounded-lg shadow-xl focus:outline-none"
                    />
                </transition>
            </div>
        </transition>
    </div>
</template>

<script>
    import { inject } from 'vue'

    export default {
        setup() {
            const state = inject('state')
            const output = inject('output')
            const dirty = inject('dirty')
            const showCanvas = inject('showCanvas')
            const closeCanvas = inject('closeCanvas')

            return {
                state,
                dirty,
                output,
                showCanvas,
                closeCanvas,
            }
        },
    }
</script>
