<template>
    <div class="flex flex-col items-center min-h-screen py-6 bg-white pt-safe-top sm:justify-center sm:pt-0 dark:bg-gray-900">
        <div class="flex items-center w-full px-2 sm:w-auto">
            <div class="flex w-full py-1 mt-px pl-safe-left pr-safe-right sm:px-4 sm:max-w-sm">
                <slot name="logo" />
            </div>
        </div>

        <div class="w-full overflow-hidden bg-white border-t border-b border-gray-100 sm:mt-2 sm:border-r sm:border-l dark:border-gray-800 dark:bg-gray-900 sm:max-w-sm sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>
