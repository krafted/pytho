<template>
    <transition leave-active-class="transition duration-1000 ease-in" leave-from-class="opacity-100" leave-to-class="opacity-0">
        <div
            v-show="on"
            class="text-sm"
            :class="{
                default: 'text-gray-600 dark:text-gray-400',
                success: 'text-green-600 dark:text-green-400',
            }[type]"
        >
            <slot />
        </div>
    </transition>
</template>

<script>
    export default {
        props: {
            on: {
                type: Boolean,
            },
            type: {
                type: String,
                default: 'default',
            },
        },
    }
</script>
