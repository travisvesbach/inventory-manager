<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';

    const props = defineProps({
        title: String,
    })
</script>
<template>
    <AppLayout :title="title">
        <div class="md:flex justify-between md:flex-row-reverse">
            <div class="w-full md:w-1/4 md:ml-4">
                <slot name="left"></slot>
            </div>
            <div class="md:w-3/4">
                <slot name="right"></slot>
            </div>
        </div>
    </AppLayout>
</template>
