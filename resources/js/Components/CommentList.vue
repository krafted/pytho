<template>
    <div v-show="show">
        <div
            class="fixed inset-0 z-10 w-full h-full"
            @click="close"
        />

        <div
            class="absolute z-20 w-56 py-3 bg-white rounded-md shadow comment-list dark:bg-gray-1000"
            ref="list"
        >
            <div
                v-for="comment in comments"
                :key="comment.id"
                class="px-4 py-1 text-sm text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900"
                @mouseover="onMouseOver(comment)"
                @mouseout="onMouseOut(comment)"
            >
                {{ comment.body }}

                <span class="text-gray-500">&mdash; </span>

                <inertia-link
                    class="text-gray-500 hover:underline focus:outline-none focus:ring-2 focus:ring-primary-500"
                    :href="route('profile.show', { user: comment.user })"
                >
                    {{ comment.user.name }}
                </inertia-link>
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
