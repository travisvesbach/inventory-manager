<script setup>
    import { Link } from '@inertiajs/inertia-vue3';
    import SplitLayout from '@/Layouts/SplitLayout.vue';
    import CardDetails from '@/Components/CardDetails.vue';
    import CardAssets from '@/Components/CardAssets.vue';
    import Card from '@/Components/Card.vue';
    import Table from '@/Components/Table.vue';

    const props = defineProps({
        asset: {
            type: Object,
            default: null
        },
        all_assets: {
            type: Array,
            default: null
        },
    })
</script>
<template>
    <SplitLayout :title="asset.name">
        <template #left>
            <CardDetails route_slug="assets" :item="asset">
                <table class="w-full">
                    <tr>
                        <td>
                            Name
                        </td>
                        <td>
                            {{ asset.name }}
                        </td>
                    </tr>
                    <tr v-if="asset.category">
                        <td>
                            Category:
                        </td>
                        <td>
                            <Link :href="asset.category.path"
                                class="text-lg link-color"
                                v-html="asset.category.name"/>
                        </td>
                    </tr>
                    <tr v-if="asset.location">
                        <td>
                            Location:
                        </td>
                        <td>
                            <Link :href="asset.location.path"
                                class="text-lg link-color"
                                v-html="asset.location.name"/>
                        </td>
                    </tr>
                    <tr v-if="asset.acquisition_date">
                        <td>
                            Acquisition Date:
                        </td>
                        <td>
                            {{ asset.acquisition_date }}
                        </td>
                    </tr>
                    <tr v-if="asset.acquisition_price">
                        <td>
                            Acquisition Price:
                        </td>
                        <td>
                            {{ asset.acquisition_price }}
                        </td>
                    </tr>
                    <tr v-if="asset.disposition_date">
                        <td>
                            Disposition Date:
                        </td>
                        <td>
                            {{ asset.disposition_date }}
                        </td>
                    </tr>
                    <tr v-if="asset.disposition_price">
                        <td>
                            Disposition Price:
                        </td>
                        <td>
                            {{ asset.disposition_price }}
                        </td>
                    </tr>
                    <tr v-if="asset.info_url">
                        <td>
                            Info URL:
                        </td>
                        <td>
                            <a :href="asset.info_url" target="_blank" class="text-lg link-color">More Info</a>
                        </td>
                    </tr>
                    <tr v-if="asset.notes">
                        <td>
                            Notes:
                        </td>
                        <td>
                            {{ asset.notes }}
                        </td>
                    </tr>
                    <tr v-if="asset.parent">
                        <td>
                            Assigned To:
                        </td>
                        <td>
                            <Link :href="asset.parent.path"
                                class="text-lg link-color"
                                v-html="asset.parent.name"/>
                        </td>
                    </tr>
                    <tr v-if="asset.checkout_date">
                        <td>
                            Assigned On:
                        </td>
                        <td>
                            {{ asset.checkout_date }}
                        </td>
                    </tr>
                </table>
            </CardDetails>
        </template>
        <template #right>
            <CardAssets :assets="asset.children" :all_assets="all_assets" :hierarchy_root="asset.id"/>
        </template>
    </SplitLayout>
</template>
