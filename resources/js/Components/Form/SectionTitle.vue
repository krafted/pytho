<template>
    <div class="md:col-span-1">
        <div class="px-4 sm:px-0">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-300">
                <slot name="title"></slot>
            </h3>

            <p class="mt-1 text-sm text-gray-500">
                <slot name="description"></slot>
            </p>
        </div>
    </div>
</template>
