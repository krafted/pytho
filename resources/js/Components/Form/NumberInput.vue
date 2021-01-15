<template>
    <div class="flex items-center justify-between w-full space-x-4">
        <input
            class="block w-full text-gray-900 bg-transparent dark:text-white focus:outline-none focus:ring-0"
            :class="{ 'transform translate-y-1': value || focused }"
            type="number"
            :value="value"
            @input="handleInput($event.target.value)"
            @focus="focused = true"
            @blur="focused = false"
        />

        <div
            v-if="increments"
            class="flex items-stretch space-x-1 transform translate-x-2 -translate-y-1"
        >
            <button
                class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full dark:bg-gray-800 focus:outline-none hover:bg-gray-200 dark:hover:bg-gray-900 focus:bg-gray-200 dark:focus:bg-gray-900"
                @click="decrement"
            >
                <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                </svg>
            </button>
            <button
                class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full dark:bg-gray-800 focus:outline-none hover:bg-gray-200 dark:hover:bg-gray-900 focus:bg-gray-200 dark:focus:bg-gray-900"
                @click="increment"
            >
                <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>
</template>

<script>
    import { inject } from 'vue'

    export default {
        props: {
            max: {
                type: String,
                required: false,
            },
            min: {
                type: String,
                required: false,
            },
            increments: {
                type: Boolean,
                required: false,
                default: false,
            },
            step: {
                type: String,
                required: false,
                default: '1',
            },
            type: {
                type: String,
                required: false,
                default: 'int',
            },
        },
        setup(props) {
            const focused = inject('focused')
            const handleInput = inject('handleInput')
            const value = inject('modelValue')
            const getValue = (v) => {
                if (!v || isNaN(v)) return
                return props.type === 'int' ? parseInt(v) : parseFloat(v)
            }
            const decrement = () => {
                if (getValue(value.value) <= getValue(props.min)) return
                handleInput(getValue(value.value) - getValue(props.step))
            }
            const increment = () => {
                if (getValue(value.value) >= getValue(props.max)) return
                handleInput(getValue(value.value) + getValue(props.step))
            }

            return {
                decrement,
                increment,
                focused,
                handleInput,
                value,
            }
        },
    }
</script>
