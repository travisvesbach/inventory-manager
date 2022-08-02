<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Table from '@/Components/Table.vue';

</script>

<template>
    <AppLayout title="Categories">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Categories
            </h2>
        </template>

        <div>
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
        </div>
    </AppLayout>

</template>
