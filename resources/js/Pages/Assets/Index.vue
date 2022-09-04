<script setup>
    import { Link } from '@inertiajs/inertia-vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Card from '@/Components/Card.vue';
    import Table from '@/Components/Table.vue';
</script>

<template>
    <AppLayout title="Assets">
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
                        key: 'location',
                        subkey: 'name',
                        label: 'Location',
                        format: 'obj_link',
                    },
                    {
                        key: 'acquisition_date',
                        label: 'Acquisition Date',
                    },
                    {
                        key: 'acquisition_price',
                        label: 'Acquisition Price',
                    },
                    {
                        key: 'parent',
                        subkey: 'name',
                        label: 'Assigned To',
                        format: 'obj_link',
                    },
                    {
                        key: 'checkout_date',
                        label: 'Checkout Date',
                    },
                ]"
                :data="$page.props.assets"
                :actions="['edit', 'delete']"
                route_slug="assets"
            >
                <Link :href="route('assets.create')" class="btn btn-primary" :as="'button'">
                    New
                </Link>
            </Table>
        </Card>
    </AppLayout>

</template>
