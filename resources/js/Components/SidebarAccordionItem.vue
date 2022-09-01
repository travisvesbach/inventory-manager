<script setup>
    import { inject, computed } from 'vue'
    import AccordionItem from '@/Components/AccordionItem.vue';
    import SidebarDivider from '@/Components/SidebarDivider.vue';

    const showingLeftSidebar = inject('showingLeftSidebar')

    const props = defineProps({
        id: String,
        title: String,
        icon: String,
    })

    const icon = computed(() => {
        return props.icon ?? 'fa-regular fa-circle';
    })

</script>

<template>
    <AccordionItem :id="id" button_classes="py-1 rounded-lg hover:bg-gray-700">
        <template #title>
            <div class="flex">
                <div class="ml-1">
                    <i :class="icon + ' h-6 w-6 text-lg'"></i>
                </div>
                <span class="pl-1 opacity-0 whitespace-nowrap group-hover:opacity-100 transition-all duration-500" :class="{'opacity-100': showingLeftSidebar, 'opacity-0': ! showingLeftSidebar}">{{ title }}</span>
            </div>
        </template>
        <SidebarDivider/>
        <slot></slot>
        <SidebarDivider/>
    </AccordionItem>
</template>
