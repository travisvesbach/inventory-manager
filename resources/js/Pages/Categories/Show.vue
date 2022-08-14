<script setup>
    import { Link } from '@inertiajs/inertia-vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
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
    })
</script>
<template>
    <AppLayout :title="category.name">
        <div class="md:flex justify-between md:flex-row-reverse">
            <div class="w-full md:w-1/4 md:ml-4">
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
                        <tr v-if="category.category">
                            <td>
                                Parent Category:
                            </td>
                            <td>
                                <Link :href="category.category.path"
                                    class="text-lg link-color"
                                    v-html="category.category.name"/>
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
                    </table>
                </CardDetails>
                <Card class="w-full my-4 md:mb-0" v-if="category.subcategories.length > 0">
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
                        ]"
                        :data="category.subcategories"
                        route_slug="categories"
                        :searchable="false"
                    />
                </Card>
            </div>
            <CardAssets class="md:w-3/4" :assets="category.assets"/>
        </div>
    </AppLayout>
</template>
