<template>
    <div class="relative flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:pt-0">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center pt-8 divide-x divide-gray-500">
                <div class="px-3 text-lg tracking-wider text-gray-500">
                    {{ title }}
                </div>

                <div class="px-3 text-lg tracking-wider text-gray-500 uppercase">
                    {{ description }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            status: Number,
        },
        computed: {
            title() {
                return {
                    503: '503',
                    500: '500',
                    429: '404',
                    419: '404',
                    404: '404',
                    403: '403',
                    401: '401',
                }[this.status]
            },
            description() {
                return {
                    503: 'Service Unavailable',
                    500: 'Server Error',
                    429: 'Too Many Requests',
                    419: 'Page Expired',
                    404: 'Not Found',
                    403: 'Forbidden',
                    401: 'Unauthorized',
                }[this.status]
            },
        },
    }
</script>
