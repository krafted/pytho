<template>
    <div>
        <span
            v-if="label"
            class="block font-semibold tracking-wide text-gray-500 uppercase text-2xs"
        >
            {{ label }}
        </span>

        <div class="block text-gray-900 dark:text-white">
            {{ value }}
        </div>
    </div>
</template>

<script>
    export default {
        props: ['label', 'value'],
    }
</script>
