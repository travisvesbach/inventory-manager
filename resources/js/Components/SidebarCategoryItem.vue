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
        <SidebarAccordionItem :id="category.name.toLowerCase()" :title="category.name" :icon="category.icon" v-if="category.all_children.length > 0">


            <Accordion>
                <SidebarLink :href="route('categories.show', category.id)" :text="'All ' + category.name" />
                <SidebarCategoryItem :category="subcategory" v-for="subcategory in category.all_children" />
            </Accordion>

        </SidebarAccordionItem>

        <SidebarLink :href="route('categories.show', category.id)" :text="category.name" :icon="category.icon" v-else/>
    </div>
</template>
