<script setup>
    import { Link } from '@inertiajs/inertia-vue3';
    import SplitLayout from '@/Layouts/SplitLayout.vue';
    import Card from '@/Components/Card.vue'
    import Table from '@/Components/Table.vue';
    import CardDetails from '@/Components/CardDetails.vue';
    import CardAssets from '@/Components/CardAssets.vue';

    const props = defineProps({
        category: {
            type: Object,
            default: null
        },
        categories: Array,
        all_assets: {
            type: Array,
            default: null
        },
    })
</script>
<template>
    <SplitLayout :title="category.name">
        <template #left>
            <CardDetails route_slug="categories" :item="category">
                <table class="w-full">
                    <tr>
                        <td>
                            Name
                        </td>
                        <td>
                            {{ category.name }}
                        </td>
                    </tr>
                    <tr v-if="category.parent">
                        <td>
                            Parent Category:
                        </td>
                        <td>
                            <Link :href="category.parent.path"
                                class="text-lg link-color"
                                v-html="category.parent.name"/>
                        </td>
                    </tr>
                    <tr v-if="category.icon">
                        <td>
                            Icon:
                        </td>
                        <td>
                            <i :class="category.icon"/>
                        </td>
                    </tr>
                    <tr v-if="category.icon">
                        <td>
                            Asset Count:
                        </td>
                        <td>
                            {{ category.asset_count }}
                            <span title="including all subcategories" v-if="category.asset_count_all">
                                ({{ category.asset_count_all }})
                            </span>
                        </td>
                    </tr>
                </table>
            </CardDetails>
            <Card class="w-full my-4 md:mb-0" v-if="category.children.length > 0">
                <template #header>
                    Subcategories
                </template>
                <Table
                    :headers="[
                        {
                            key: 'name',
                            label: 'Name',
                            format: 'link',
                        },
                        {
                            key: 'icon',
                            label: 'Icon',
                            format: 'icon',
                        },
                        {
                            key: 'asset_count_all',
                            label: 'Assets',
                            format: 'count',
                        },
                    ]"
                    :data="category.children"
                    route_slug="categories"
                    :searchable="false"
                />
            </Card>
        </template>
        <template #right>
            <CardAssets :assets="category.assets" :all_assets="all_assets"/>
        </template>
    </SplitLayout>
</template>
