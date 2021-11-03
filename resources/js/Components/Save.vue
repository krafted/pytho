<template>
    <button
        class="
            flex
            items-center
            justify-center
            p-2.5
            text-gray-600
            dark:text-gray-400
            border border-white
            bg-white
            dark:bg-gray-900 dark:border-gray-900
            rounded-md
            group
            hover:w-auto hover:bg-gray-200
            dark:hover:bg-gray-1000
            focus:bg-gray-200
            dark:focus:bg-gray-1000
            focus:border-gray-300
            dark:focus:border-gray-600
            hover:border-gray-300
            dark:hover:border-gray-600
            hover:text-gray-900
            dark:hover:text-gray-200
            focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-200
            dark:focus:ring-offset-gray-900
            focus:ring-primary-500 focus:outline-none focus:w-auto
        "
        :title="isMac ? '⌘S' : '⌃S'"
        @click="show = true"
    >
        <span class="sr-only">Save</span>

        <span
            v-if="!isMobile"
            class="flex-shrink-0 hidden mr-2 text-sm  group-hover:inline group-focus:inline"
        >
            Save
        </span>

        <svg
            class="w-5 h-5"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"
            />
        </svg>

        <transition
            enter-active-class="duration-300 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
        >
            <span
                v-if="dirty || error"
                class="
                    absolute
                    w-1
                    h-1
                    transition-opacity
                    rounded-full
                    bottom-0.5
                    inline-block
                    group-hover:hidden
                "
                :class="error ? 'bg-red-500' : 'bg-primary-500'"
            />
        </transition>
    </button>

    <x-modal :show="show" type="form" @close="show = false" @submitted="save">
        <template #icon>
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"
            />
        </template>

        <template #title> Save </template>

        <template #content>
            <div class="grid grid-cols-1 gap-3">
                <div class="space-y-1">
                    <f-url-input
                        ref="url"
                        label="URL"
                        :prepend="page.props.value.appUrl"
                        v-model="form.slug"
                    />
                    <f-input-error :message="form.errors.slug" />
                </div>

                <div class="space-y-1">
                    <f-input label="Title" v-model="form.title" />
                    <f-input-error :message="form.errors.title" />
                </div>

                <div class="space-y-1">
                    <f-textarea
                        label="Description"
                        v-model="form.description"
                    />
                    <f-input-error :message="form.errors.description" />
                </div>

                <div class="space-y-1">
                    <f-listbox
                        label="Visibility"
                        :options="visibilityOptions"
                        position="top"
                        v-model="form.visibility"
                    >
                        <template #option="{ option }">
                            <div class="text-left">
                                <div class="flex items-center">
                                    <div class="text-sm font-semibold">
                                        {{ option.label }}
                                    </div>
                                </div>

                                <div class="mt-1 text-xs">
                                    {{ option.description }}
                                </div>
                            </div>
                        </template>
                    </f-listbox>
                    <f-input-error :message="form.errors.visibility" />
                </div>
            </div>
        </template>

        <template #actions>
            <x-danger-button
                v-if="pen"
                class="mr-auto sm:ml-16"
                type="button"
                @click="confirmDeletion"
            >
                Delete
            </x-danger-button>

            <!-- Delete Confirmation Modal -->
            <x-modal :show="confirmingDeletion" @close="closeDeleteModal">
                <template #icon>
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                    />
                </template>

                <template #title> Delete </template>

                <template #content>
                    <div class="text-sm text-gray-500">
                        Are you sure you want to delete this pen? Once this pen
                        is deleted it cannot be recovered.
                    </div>
                </template>

                <template #actions>
                    <x-secondary-button @click.native="closeDeleteModal">
                        Close
                    </x-secondary-button>

                    <x-danger-button
                        @click.native="deletePen"
                        :class="{ 'opacity-25': deleteForm.processing }"
                        :disabled="deleteForm.processing"
                    >
                        Delete
                    </x-danger-button>
                </template>
            </x-modal>

            <x-secondary-button type="button" @click="show = false">
                Close
            </x-secondary-button>

            <x-button
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                Save
            </x-button>
        </template>
    </x-modal>
</template>

<script>
import FInput from "@/Components/Form/Input";
import FInputError from "@/Components/Form/InputError";
import FListbox from "@/Components/Form/Listbox";
import FTextarea from "@/Components/Form/Textarea";
import FUrlInput from "@/Components/Form/UrlInput";
import XButton from "@/Components/Button";
import XDangerButton from "@/Components/DangerButton";
import XModal from "@/Components/Modal";
import XSecondaryButton from "@/Components/SecondaryButton";
import {
    inject,
    nextTick,
    onMounted,
    onUnmounted,
    ref,
    watchEffect,
} from "vue";
import hotkeys from "hotkeys-js";
import { useForm, usePage } from "@inertiajs/inertia-vue3";

export default {
    emits: ["created", "saved"],
    props: ["isCreator", "pen", "slug"],
    components: {
        FInput,
        FInputError,
        FListbox,
        FTextarea,
        FUrlInput,
        XButton,
        XDangerButton,
        XModal,
        XSecondaryButton,
    },
    setup(props, { emit }) {
        const page = usePage();
        const form = inject("form");
        const dirty = inject("dirty");
        const error = inject("error");
        const isMac = inject("isMac");
        const isMobile = inject("isMobile");
        const show = ref(false);
        const url = ref(null);
        const run = inject("run");
        const visibilityOptions = [
            {
                value: "public",
                label: "Public",
                description:
                    "Anyone you send this link to will be able to view it.",
            },
            {
                value: "private",
                label: "Private",
                description:
                    "You will be the only user that is able to view it.",
            },
            {
                value: "unlisted",
                label: "Unlisted",
                description:
                    "Users will only be able to view it with the direct link.",
            },
        ];
        const deleteForm = useForm();
        const confirmingDeletion = ref(false);

        const save = async () => {
            const canSave = props.isCreator && !!props.pen;
            const method = canSave ? "put" : "post";
            const url = canSave
                ? route("pen.update", props.pen)
                : route("pen.store");

            form.value[method](url, {
                onSuccess: async () => {
                    if (!canSave && typeof navigator.clipboard !== "undefined")
                        navigator.clipboard.writeText(
                            `${page.props.value.appUrl}/${form.value.slug}`
                        );

                    await run();

                    show.value = false;
                    dirty.value = false;

                    emit(canSave ? "saved" : "created");
                },
            });
        };

        const confirmDeletion = () => (confirmingDeletion.value = true);
        const deletePen = () => {
            form.value.delete(route("pen.destroy", props.pen), {
                preserveState: false,
                onSuccess: () => closeDeleteModal(),
                onFinish: () => deleteForm.value.reset(),
            });
        };
        const closeDeleteModal = () => {
            confirmingDeletion.value = false;
            deleteForm.value.reset();
        };

        onMounted(() => {
            hotkeys(isMac.value ? "cmd+s" : "ctrl+s", async (event) => {
                const canSave = props.isCreator && props.pen;

                if (canSave) save();
                else show.value = true;

                event.preventDefault();
            });
        });
        onUnmounted(() => hotkeys.unbind(isMac.value ? "cmd+s" : "ctrl+s"));

        watchEffect(
            async () => show.value && (await nextTick(), url.value.focus())
        );

        return {
            page,
            form,
            dirty,
            error,
            isMac,
            isMobile,
            save,
            show,
            url,
            visibilityOptions,
            closeDeleteModal,
            confirmDeletion,
            confirmingDeletion,
            deleteForm,
            deletePen,
        };
    },
};
</script>
