<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import DeleteUserForm from '@/Pages/Profile/Partials/DeleteUserForm.vue';
import JetSectionBorder from '@/Jetstream/SectionBorder.vue';
import LogoutOtherBrowserSessionsForm from '@/Pages/Profile/Partials/LogoutOtherBrowserSessionsForm.vue';
import TwoFactorAuthenticationForm from '@/Pages/Profile/Partials/TwoFactorAuthenticationForm.vue';
import UpdatePasswordForm from '@/Pages/Profile/Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from '@/Pages/Profile/Partials/UpdateProfileInformationForm.vue';
import PageHeader from '@/Components/PageHeader.vue';
import PageContent from '@/Components/PageContent.vue';

defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
});
</script>

<template>
    <AppLayout title="Profile">
        <template #header>
            <PageHeader>
                Profile
            </PageHeader>
        </template>

        <PageContent>
            <div v-if="$page.props.jetstream.canUpdateProfileInformation">
                <UpdateProfileInformationForm :user="$page.props.user" />

                <JetSectionBorder />
            </div>

            <div v-if="$page.props.jetstream.canUpdatePassword">
                <UpdatePasswordForm class="sm:smt-0" />

                <JetSectionBorder />
            </div>

            <div v-if="$page.props.jetstream.canManageTwoFactorAuthentication">
                <TwoFactorAuthenticationForm
                    :requires-confirmation="confirmsTwoFactorAuthentication"
                    class="sm:mt-0"
                />

                <JetSectionBorder />
            </div>

            <LogoutOtherBrowserSessionsForm :sessions="sessions" class="sm:mt-0" />

            <template v-if="$page.props.jetstream.hasAccountDeletionFeatures">
                <JetSectionBorder />

                <DeleteUserForm class="sm:mt-0" />
            </template>
        </PageContent>
    </AppLayout>
</template>
