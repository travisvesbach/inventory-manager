<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Table from '@/Components/Table.vue';
</script>

<template>
    <AppLayout title="Categories">
        <Table
            :headers="[
                {
                    key: 'name',
                    label: 'Name',
                    format: 'link',
                },
                {
                    key: 'category',
                    subkey: 'name',
                    label: 'Category',
                    format: 'obj_link',
                },
                {
                    key: 'icon',
                    label: 'Icon',
                    format: 'icon',
                },
            ]"
            :data="$page.props.categories"
            :actions="['edit', 'delete']"
            route_slug="categories"
        />
    </AppLayout>

</template>
