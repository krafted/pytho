<template>
    <div v-show="show">
        <div class="fixed inset-0 z-10 w-full h-full" @click="close" />

        <div
            class="absolute z-20 w-56 py-1 bg-white divide-y divide-gray-100 rounded-md shadow  comment-list dark:bg-gray-1000 dark:divide-gray-900"
            ref="list"
        >
            <div
                v-for="comment in comments"
                :key="comment.id"
                class="flex items-start px-3 py-2 space-x-3 text-sm text-gray-700  dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900"
                @mouseover="onMouseOver(comment)"
                @mouseout="onMouseOut(comment)"
            >
                <inertia-link
                    class="flex-shrink-0"
                    :href="route('profile.show', { user: comment.user })"
                >
                    <img
                        class="object-cover w-8 h-8 border-2 border-gray-100 rounded-full  dark:border-gray-800"
                        :src="`${comment.user.profile_photo_url}`"
                        :alt="comment.user.name"
                    />
                </inertia-link>

                <div class="flex-1">
                    <div class="flex items-center justify-between">
                        <inertia-link
                            class="font-medium text-gray-500  hover:underline focus:outline-none focus:ring-2 focus:ring-primary-500"
                            :href="
                                route('profile.show', { user: comment.user })
                            "
                        >
                            {{ comment.user.name }}
                        </inertia-link>

                        <time class="text-xs tracking-wide text-gray-500">{{
                            comment.created_at
                        }}</time>
                    </div>

                    <div class="flex">
                        <p class="flex-1">{{ comment.body }}</p>

                        <button
                            v-if="
                                page.props.value.user.id === comment.user.id ||
                                isCreator
                            "
                            class="flex-shrink-0 text-red-600 rounded-none  focus:outline-none focus:ring-2 focus:ring-red-600"
                            @click="deleteComment(comment)"
                        >
                            <svg
                                class="w-4 h-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { inject, ref, toRaw } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

export default {
    props: ["comments", "isCreator", "pen", "show"],
    setup(props, { emit }) {
        let selection;
        const page = usePage();
        const editor = inject("editor");
        const list = ref(null);
        const close = () => emit("close");
        const onMouseOver = (comment) => {
            selection = toRaw(editor.value).markText(
                comment.properties.coords[0],
                comment.properties.coords[1],
                { className: "cm-markedselection" }
            );
        };
        const onMouseOut = () => selection.clear();
        const deleteComment = (comment) => {
            Inertia.delete(
                route("pen.comments.destroy", {
                    pen: props.pen?.slug,
                    comment,
                }),
                {
                    preserveScroll: true,
                    preserveState: false,
                }
            );
        };

        return {
            page,
            close,
            list,
            onMouseOver,
            onMouseOut,
            deleteComment,
        };
    },
};
</script>
