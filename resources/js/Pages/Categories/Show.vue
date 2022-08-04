<script setup>
    import { Link } from '@inertiajs/inertia-vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Card from '@/Components/Card.vue'

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
        <Card>
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
    </AppLayout>
</template>
