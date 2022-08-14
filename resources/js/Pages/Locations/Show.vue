<script setup>
    import { computed } from 'vue'
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

    const addressSet = computed(() => {
        if(props.location.address || props.location.address_secondary || props.location.city || props.location.state || props.location.country || props.location.zipcode) {
            return true;
        }
        return false;
    });
</script>
<template>
    <AppLayout :title="location.name">
        <div class="md:flex justify-between md:flex-row-reverse">
            <div class="w-full md:w-1/4 md:ml-4">
                <Card class="w-full mb-4">
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
                        <tr v-if="addressSet">
                            <td>
                                Parent Location:
                            </td>
                            <td>
                                <Link :href="location.location.path"
                                    class="text-lg link-color"
                                    v-html="location.location.name"/>
                            </td>
                        </tr>
                        <tr valign="top">
                            <td>
                                Address
                            </td>
                            <td>
                                {{ location.address }}<br v-if="location.address">
                                {{ location.address_secondary }}<br v-if="location.address_secondary">
                                {{ location.city }}<span v-if="location.city && location.state">,</span> {{ location.state }} {{ location.zipcode }} <br v-if="location.country">
                                {{ location.country }}
                            </td>
                        </tr>
                    </table>
                </Card>
                <Card class="w-full mb-4 md:mb-0" v-if="props.location.locations.length > 0">
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
            <Card class="w-full md:w-3/4">
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
                    :data="props.location.assets"
                    route_slug="assets"
                />
            </Card>
        </div>
    </AppLayout>
</template>
