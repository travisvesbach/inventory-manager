<script setup>
    import { Link } from '@inertiajs/inertia-vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Card from '@/Components/Card.vue';
    import Table from '@/Components/Table.vue';
</script>

<template>
    <AppLayout title="Locations">
        <Card>
            <Table
                :headers="[
                    {
                        key: 'name',
                        label: 'Name',
                        format: 'link',
                    },
                    {
                        key: 'location',
                        subkey: 'name',
                        label: 'Location',
                        format: 'obj_link',
                    },
                ]"
                :data="$page.props.locations"
                :actions="['edit', 'delete']"
                route_slug="locations"
            >
                <Link :href="route('locations.create')" class="btn btn-primary" :as="'button'">
                    New
                </Link>
            </Table>
        </Card>
    </AppLayout>

</template>
