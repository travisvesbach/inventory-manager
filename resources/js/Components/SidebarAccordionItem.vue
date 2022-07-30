<script setup>
    import AccordionItem from '@/Components/AccordionItem.vue';

    const props = defineProps({
        id: String,
        title: String,
    })
</script>

<template>
    <AccordionItem :id="props.id" button_classes="py-1 rounded-lg hover:bg-gray-700">
        <template #title>
            <div class="flex">
                <div class="ml-1">
                    <slot name="icon"></slot>
                </div>
                <span class="pl-1 opacity-0 whitespace-nowrap group-hover:opacity-100 transition-all duration-500">{{ props.title }}</span>
            </div>
        </template>
        <slot></slot>
    </AccordionItem>
</template>
