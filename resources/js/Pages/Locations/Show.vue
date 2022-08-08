<script setup>
    import { Link } from '@inertiajs/inertia-vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Card from '@/Components/Card.vue'
    import Table from '@/Components/Table.vue';

    const props = defineProps({
        location: {
            type: Object,
            default: null
        },
        locations: Array,
    })
</script>
<template>
    <AppLayout :title="location.name">
        <div class="grid sm:grid-cols-2 gap-4">
            <Card class="w-full">
                <template #header>
                    Details
                </template>
                <table class="w-full">
                    <tr>
                        <td>
                            Name
                        </td>
                        <td>
                            {{ location.name }}
                        </td>
                    </tr>
                    <tr v-if="location.location">
                        <td>
                            Parent location:
                        </td>
                        <td>
                            <Link :href="location.location.path"
                                class="text-lg link-color"
                                v-html="location.location.name"/>
                        </td>
                    </tr>
                </table>
            </Card>
            <Card class="w-full">
                <template #header>
                    Locations
                </template>
                <Table
                    :headers="[
                        {
                            key: 'name',
                            label: 'Name',
                            format: 'link',
                        },
                    ]"
                    :data="props.location.locations"
                    route_slug="locations"
                    :search="false"
                />
            </Card>
        </div>
    </AppLayout>
</template>
