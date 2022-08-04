<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Jetstream/Welcome.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <Welcome />
        </div>
    </AppLayout>
</template>
