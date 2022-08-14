<script setup>
    import Card from '@/Components/Card.vue'
    import Table from '@/Components/Table.vue';

    const props = defineProps({
        assets: {
            type: Array,
            default: null
        },
    })
</script>
<template>
    <Card class="w-full" v-if="assets">
        <template #header>
            Assets
        </template>
        <Table
            :headers="[
                {
                    key: 'name',
                    label: 'Name',
                    format: 'link',
                },
            ]"
            :data="assets"
            route_slug="assets"
        />
    </Card>
</template>
