<script setup>
    import { ref } from 'vue'
    import Card from '@/Components/Card.vue'
    import Table from '@/Components/Table.vue';

    const props = defineProps({
        assets: {
            type: Array,
            default: null
        },
        all_assets: {
            type: Array,
            default: null
        },
    })

    const showing_all = ref(false);
</script>
<template>
    <Card class="w-full" v-if="assets">
        <template #header>
            <div class="flex flex-grow items-center justify-between">
                <span>
                    Assets
                </span>
                <div>
                    <button @click="showing_all = !showing_all"
                        class="btn btn-sm btn-primary"
                        title="Show All Assets"
                        as="button"
                        v-if="all_assets.length != assets.length">
                        {{ showing_all ? 'hide' : 'Include' }} child assets
                    </button>
                </div>
            </div>
        </template>
        <Table
            :headers="[
                {
                    key: 'name',
                    label: 'Name',
                    format: 'link',
                },
                {
                    key: 'category',
                    subkey: 'name',
                    label: 'Category',
                    format: 'obj_link',
                },
                {
                    key: 'location',
                    subkey: 'name',
                    label: 'Location',
                    format: 'obj_link',
                },
            ]"
            :data="all_assets && showing_all ? all_assets : assets"
            route_slug="assets"
        />
    </Card>
</template>
