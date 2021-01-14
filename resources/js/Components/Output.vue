<template>
    <div
        v-if="!showCanvas"
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
    </div>

    <div
        v-if="showCanvas"
        class="absolute inset-0 flex items-center justify-center flex-1 overflow-auto mr-safe-right"
        :class="{ 'ml-safe-left': state.settings.layout === 'horizontal' }"
        @mouseover="dirty = false"
        @click="dirty = false, closeCanvas"
        @focus="dirty = false"
    >
        <div
            id="canvas"
            class="bg-white"
        />
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
