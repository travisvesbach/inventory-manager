<script setup>
    import { Link } from '@inertiajs/inertia-vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Card from '@/Components/Card.vue';
    import Table from '@/Components/Table.vue';
</script>

<template>
    <AppLayout title="Categories">
        <Card>
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
                    {
                        key: 'asset_count',
                        label: 'Assets',
                        format: 'count',
                    },
                    {
                        key: 'asset_count_all',
                        label: 'Asset Total',
                        format: 'count',
                    },
                ]"
                :data="$page.props.categories"
                :actions="['edit', 'delete']"
                route_slug="categories"
            >
                <Link :href="route('categories.create')" class="btn btn-primary" :as="'button'">
                    New
                </Link>
            </Table>
        </Card>
    </AppLayout>

</template>
