<template>
    <h-listbox
        as="div"
        class="h-14.5 px-4 pt-2 pb-8 bg-gray-100 border border-gray-100 rounded-md dark:border-gray-800 dark:bg-gray-800 focus-within:bg-white dark:focus-within:bg-gray-900 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-white dark:focus-within:ring-offset-gray-900 focus-within:outline-none focus-within:ring-primary-500"
        :model-value="modelValue"
        v-slot="{ open }"
        @update:model-value="handleInput"
    >
        <h-listbox-label
            class="block font-semibold tracking-wide text-gray-500 uppercase transition-all duration-200 ease-in-out transform cursor-pointer"
            :class="{
                'text-2xs': modelValue,
                'text-xs translate-y-3': !modelValue,
            }"
        >
            {{ label }}
        </h-listbox-label>

        <h-listbox-button class="absolute inset-0 z-10 flex items-center justify-between w-full px-4 mt-px text-left text-gray-900 dark:text-white focus:outline-none focus:ring-0">
            <span class="mt-3.5">
                <span v-if="modelValue">
                    {{ options.find(o => o.value === modelValue).label }}
                </span>
                <span v-else>&nbsp;</span>
            </span>

            <svg class="absolute w-4 h-4 text-gray-500 right-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </h-listbox-button>

        <transition
            leave-active-class="transition duration-100 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="open"
                class="absolute z-20 bg-white rounded-md shadow-lg -inset-x-px dark:bg-gray-900"
                :class="{
                    bottom: 'top-full mt-2',
                    top: 'bottom-full mb-2',
                }[position]"
            >
                <h-listbox-options class="overflow-y-auto bg-white border border-gray-100 rounded-md shadow-xs max-h-60 dark:bg-gray-900 focus:outline-none dark:border-gray-800">
                    <h-listbox-option
                        v-for="option in options"
                        :key="option.value"
                        class="w-full focus:outline-none focus:ring-0"
                        :value="option.value"
                        v-slot="{ selected, active }"
                    >
                        <button
                            class="flex items-center justify-between w-full px-4 py-2 focus:outline-none focus:ring-0"
                            :class="{
                                'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white': active,
                                'font-semibold text-gray-900 dark:text-white': selected,
                                'text-gray-600 dark:text-gray-400': !selected && !active,
                            }"
                            type="button"
                        >
                            <slot
                                name="option"
                                :active="active"
                                :option="option"
                                :selected="selected"
                            >
                                {{ option.label }}
                            </slot>

                            <svg
                                v-if="selected"
                                class="w-4 h-4 ml-4"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </button>
                    </h-listbox-option>
                </h-listbox-options>
            </div>
        </transition>
    </h-listbox>
</template>

<script>
    import {
        Listbox as HListbox,
        ListboxButton as HListboxButton,
        ListboxLabel as HListboxLabel,
        ListboxOption as HListboxOption,
        ListboxOptions as HListboxOptions,
    } from '@headlessui/vue'

    export default {
        emits: ['update:modelValue'],
        props: {
            label: {
                type: String,
            },
            modelValue: {
                type: [Array, Number, String],
            },
            options: {
                type: [Array],
            },
            position: {
                type: String,
                default: 'bottom',
            },
        },
        components: {
            HListbox,
            HListboxButton,
            HListboxLabel,
            HListboxOption,
            HListboxOptions,
        },
        setup(_, { emit }) {
            const handleInput = (v) => emit('update:modelValue', v)

            return { handleInput }
        },
    }
</script>
