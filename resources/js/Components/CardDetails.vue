<script setup>
    import { Link } from '@inertiajs/inertia-vue3';
    import Card from '@/Components/Card.vue'

    const props = defineProps({
        item: Object,
        route_slug: String,
    })
</script>
<template>
    <Card class="w-full">
        <template #header>
            <div class="flex flex-grow items-center justify-between">
                <span>
                    Details
                </span>
                <div>
                    <Link :href="route(route_slug + '.edit', item.id)"
                        class="btn btn-sm btn-square btn-primary"
                        title="Edit"
                        as="button"
                        v-if="route_slug && item">
                        <i class="fa-solid fa-pencil text-lg"></i>
                    </Link>
                </div>
            </div>
        </template>
        <slot></slot>
    </Card>
</template>
