<script setup>
import ApiTokenManager from '@/Pages/API/Partials/ApiTokenManager.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import PageHeading from '@/Components/PageHeading.vue';
import PageContent from '@/Components/PageContent.vue';

defineProps({
    tokens: Array,
    availablePermissions: Array,
    defaultPermissions: Array,
});
</script>

<template>
    <AppLayout title="API Tokens">
        <template #header>
            <PageHeading>
                API Tokens
            </PageHeading>
        </template>

        <PageContent>
            <ApiTokenManager
                :tokens="tokens"
                :available-permissions="availablePermissions"
                :default-permissions="defaultPermissions"
            />
        </PageContent>
    </AppLayout>
</template>
