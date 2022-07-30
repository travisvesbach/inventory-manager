<script setup>
    import AccordionItem from '@/Components/AccordionItem.vue';
    import SidebarDivider from '@/Components/SidebarDivider.vue';

    const props = defineProps({
        id: String,
        title: String,
        icon: {
            type: String,
            default: 'fa-regular fa-circle',
        }
    })

</script>

<template>
    <AccordionItem :id="props.id" button_classes="py-1 rounded-lg hover:bg-gray-700">
        <template #title>
            <div class="flex">
                <div class="ml-1">
                    <i :class="props.icon + ' h-6 w-6 text-lg'"></i>
                </div>
                <span class="pl-1 opacity-0 whitespace-nowrap group-hover:opacity-100 transition-all duration-500">{{ props.title }}</span>
            </div>
        </template>
        <SidebarDivider/>
        <slot></slot>
        <SidebarDivider/>
    </AccordionItem>
</template>
