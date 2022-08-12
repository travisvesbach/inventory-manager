<script setup>
    import { Link } from '@inertiajs/inertia-vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Card from '@/Components/Card.vue'
    import Table from '@/Components/Table.vue';

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
                </Card>
                <Card class="w-full mb-4 md:mb-0" v-if="props.category.subcategories.length > 0">
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
                        :data="props.category.subcategories"
                        route_slug="categories"
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
                        {
                            key: 'icon',
                            label: 'Icon',
                            format: 'icon',
                        },
                    ]"
                    :data="props.category.subcategories"
                    route_slug="categories"
                />
            </Card>
        </div>
    </AppLayout>
</template>
