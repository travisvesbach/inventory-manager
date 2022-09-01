<script setup>
    import { computed } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3';
    import SplitLayout from '@/Layouts/SplitLayout.vue';
    import Card from '@/Components/Card.vue'
    import Table from '@/Components/Table.vue';
    import CardDetails from '@/Components/CardDetails.vue';
    import CardAssets from '@/Components/CardAssets.vue';

    const props = defineProps({
        location: {
            type: Object,
            default: null
        },
        locations: Array,
        all_assets: {
            type: Array,
            default: null
        },
    })

    const addressSet = computed(() => {
        if(props.location.address || props.location.address_secondary || props.location.city || props.location.state || props.location.country || props.location.zipcode) {
            return true;
        }
        return false;
    });
</script>
<template>
    <SplitLayout :title="location.name">
        <template #left>
            <CardDetails route_slug="locations" :item="location">
                <table class="w-full">
                    <tr>
                        <td>
                            Name
                        </td>
                        <td>
                            {{ location.name }}
                        </td>
                    </tr>
                    <tr v-if="location.parent">
                        <td>
                            Parent Location:
                        </td>
                        <td>
                            <Link :href="location.parent.path"
                                class="text-lg link-color"
                                v-html="location.parent.name"/>
                        </td>
                    </tr>
                    <tr valign="top" v-if="addressSet">
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
            </CardDetails>
            <Card class="w-full my-4 md:mb-0" v-if="location.children.length > 0">
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
                        {
                            key: 'asset_count',
                            label: 'Assets',
                            format: 'count',
                        },
                    ]"
                    :data="location.children"
                    route_slug="locations"
                    :searchable="false"
                />
            </Card>
        </template>
        <template #right>
            <CardAssets :assets="location.assets" :all_assets="all_assets"/>
        </template>
    </SplitLayout>
</template>
