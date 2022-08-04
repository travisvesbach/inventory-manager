<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Card from '@/Components/Card.vue'

    const props = defineProps({
        category: {
            type: Object,
            default: null
        },
        categories: Array,
    })
</script>
<template>
    <AppLayout :title="category.name">
        <Card>

        </Card>
    </AppLayout>
</template>
