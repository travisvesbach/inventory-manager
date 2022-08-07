<script setup>
    import { Link } from '@inertiajs/inertia-vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Card from '@/Components/Card.vue';
    import Table from '@/Components/Table.vue';
</script>

<template>
    <AppLayout title="Users">
        <Card>
            <Table
                :headers="[
                    {
                        key: 'name',
                        label: 'Name',
                        format: 'link',
                    },
                    {
                        key: 'email',
                        label: 'Email',
                        format: 'text',
                    },
                    {
                        key: 'admin',
                        label: 'Admin',
                        format: 'boolean',
                        true_text: 'Admin',
                    },
                ]"
                :data="$page.props.users"
                :actions="['edit', 'delete']"
                route_slug="users"
            >
                <Link :href="route('users.create')" class="btn btn-primary" :as="'button'">
                    New
                </Link>
            </Table>
        </Card>
    </AppLayout>
</template>
