<template>
    <div v-show="show">
        <div
            class="fixed inset-0 z-10 w-full h-full"
            @click="close"
        />

        <div
            class="absolute z-20 w-56 py-1 bg-white divide-y divide-gray-100 rounded-md shadow comment-list dark:bg-gray-1000 dark:divide-gray-900"
            ref="list"
        >
            <div
                v-for="comment in comments"
                :key="comment.id"
                class="flex items-start px-3 py-2 space-x-3 text-sm text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900"
                @mouseover="onMouseOver(comment)"
                @mouseout="onMouseOut(comment)"
            >
                <inertia-link class="flex-shrink-0" :href="route('profile.show', { user: comment.user })">
                    <img
                        class="object-cover w-8 h-8 border-2 border-gray-100 rounded-full dark:border-gray-800"
                        :src="`${comment.user.profile_photo_url}`"
                        :alt="comment.user.name"
                    />
                </inertia-link>

                <div class="flex-1">
                    <div class="flex items-center justify-between">
                        <inertia-link
                            class="font-medium text-gray-500 hover:underline focus:outline-none focus:ring-2 focus:ring-primary-500"
                            :href="route('profile.show', { user: comment.user })"
                        >
                            {{ comment.user.name }}
                        </inertia-link>

                        <time class="text-xs tracking-wide text-gray-500">{{ comment.created_at }}</time>
                    </div>

                    {{ comment.body }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { inject, ref, toRaw } from 'vue'

    export default {
        props: ['comments', 'show'],
        setup(_, { emit }) {
            let selection
            const editor = inject('editor')
            const list = ref(null)
            const close = () => emit('close')
            const onMouseOver = comment => {
                selection = toRaw(editor.value).markText(comment.properties.coords[0], comment.properties.coords[1], { className: 'cm-markedselection' })
            }
            const onMouseOut = () => selection.clear()

            return {
                close,
                list,
                onMouseOver,
                onMouseOut,
            }
        }
    }
</script>
