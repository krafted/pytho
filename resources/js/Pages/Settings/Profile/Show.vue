<template>
    <l-settings>
        <div v-if="page.props.value.jetstream.canUpdateProfileInformation">
            <update-profile-information-form :user="page.props.value.user" />
        </div>
    </l-settings>
</template>

<script>
import LSettings from "@/Layouts/Settings";
import UpdateProfileInformationForm from "./UpdateProfileInformationForm";
import { usePage } from "@inertiajs/inertia-vue3";
import { useHead } from "@vueuse/head";

export default {
    components: {
        LSettings,
        UpdateProfileInformationForm,
    },
    setup() {
        const page = usePage();

        useHead({ title: "Profile Settings — Pytho" });

        return { page };
    },
};
</script>
