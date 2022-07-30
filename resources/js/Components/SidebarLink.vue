<script setup>
    import { Link } from '@inertiajs/inertia-vue3';

    const props = defineProps({
        href: String,
        text: String,
    })
</script>

<template>
    <Link :href="props.href" class="flex py-1 rounded-lg hover:bg-gray-700">
        <div class="ml-1">
            <slot></slot>
        </div>
        <span class="pl-1 opacity-0 whitespace-nowrap group-hover:opacity-100 transition-all duration-500">{{ props.text }}</span>
    </Link>
</template>
