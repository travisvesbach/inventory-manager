<script setup>
    import Accordion from '@/Components/Accordion.vue';
    import AccordionItem from '@/Components/AccordionItem.vue';
    import SidebarLink from '@/Components/SidebarLink.vue';
    import SidebarAccordionItem from '@/Components/SidebarAccordionItem.vue';


    defineProps({
        category: Object,
    });
</script>

<template>
    <div>
        <SidebarAccordionItem :id="category.name.toLowerCase()" :title="category.name" :icon="category.icon" v-if="category.all_subcategories.length > 0">


            <Accordion>
                <SidebarLink :href="route('dashboard')" :text="'All ' + category.name" />
                <SidebarCategoryItem :category="subcategory" v-for="subcategory in category.all_subcategories" />
            </Accordion>

        </SidebarAccordionItem>

        <SidebarLink :href="route('dashboard')" :text="category.name" :icon="category.icon" v-else/>
    </div>
</template>
