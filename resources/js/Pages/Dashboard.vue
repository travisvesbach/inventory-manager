<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Jetstream/Welcome.vue';
import PageHeader from '@/Components/PageHeader.vue';
import PageContent from '@/Components/PageContent.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <PageHeader>
                Dashboard
            </PageHeader>
        </template>

        <PageContent>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <Welcome />
            </div>
        </PageContent>
    </AppLayout>
</template>
