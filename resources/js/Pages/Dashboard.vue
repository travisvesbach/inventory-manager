<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Jetstream/Welcome.vue';
import PageHeading from '@/Components/PageHeading.vue';
import PageContent from '@/Components/PageContent.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <PageHeading>
                Dashboard
            </PageHeading>
        </template>

        <PageContent>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <Welcome />
            </div>
        </PageContent>
    </AppLayout>
</template>
