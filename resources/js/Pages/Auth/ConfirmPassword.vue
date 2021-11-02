<template>
    <l-auth>
        <template #logo>
            <x-logo class="h-10.5 text-lg px-3 sm:h-12 sm:text-2xl" />
        </template>

        <form @submit.prevent="submit">
            <div class="grid grid-cols-1 gap-3 p-4 sm:p-6">
                <div class="text-sm text-gray-500">
                    This is a secure area of the application. Please confirm
                    your password before continuing.
                </div>

                <f-validation-errors />

                <f-input
                    label="Password"
                    autocomplete="current-password"
                    autofocus
                    required
                    type="password"
                    v-model="form.password"
                />
            </div>

            <div
                class="flex flex-col p-4 space-y-1 bg-gray-100  sm:rounded-b-lg sm:space-x-3 sm:px-6 sm:py-3 dark:bg-gray-800 sm:flex-row-reverse"
            >
                <x-button
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Confirm
                </x-button>
            </div>
        </form>
    </l-auth>
</template>

<script>
import FInput from "@/Components/Form/Input";
import FValidationErrors from "@/Components/Form/ValidationErrors";
import LAuth from "@/Layouts/Auth";
import XButton from "@/Components/Button";
import XLogo from "@/Components/Logo";
import { useForm } from "@inertiajs/inertia-vue3";

export default {
    components: {
        FInput,
        FValidationErrors,
        LAuth,
        XButton,
        XLogo,
    },
    setup() {
        const form = useForm({ password: "" });
        const submit = () => {
            form.value.post(route("password.confirm"), {
                onFinish: () => form.value.reset(),
            });
        };

        return {
            form,
            submit,
        };
    },
};
</script>
