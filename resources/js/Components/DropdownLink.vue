<template>
    <div>
        <button :type="type || 'submit'" class="block w-full px-4 py-2 text-sm leading-5 text-left text-gray-700 transition duration-200 ease-in-out dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800" v-if="as == 'button'">
            <slot></slot>
        </button>

        <inertia-link :href="href" class="block px-4 py-2 text-sm leading-5 text-gray-700 transition duration-200 ease-in-out dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800" v-else>
            <slot></slot>
        </inertia-link>
    </div>
</template>

<script>
    export default {
        props: ['href', 'as', 'type']
    }
</script>
