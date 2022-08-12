<script setup>
    import { inject} from 'vue'
    import { Link } from '@inertiajs/inertia-vue3';

    const showingLeftSidebar = inject('showingLeftSidebar')

    const props = defineProps({
        href: String,
        text: String,
        icon: {
            type: String,
            default: 'fa-regular fa-circle',
        }
    })
</script>

<template>
    <Link :href="props.href" class="flex py-1 rounded-lg hover:bg-gray-700 overflow-x-hidden">
        <div class="ml-2">
            <i :class="(props.icon ?? 'fa-regular fa-circle') + ' h-6 w-6 text-lg'"></i>
        </div>
        <span class="pl-1 opacity-0 whitespace-nowrap group-hover:opacity-100 transition-all duration-500" :class="{'opacity-100': showingLeftSidebar, 'opacity-0': ! showingLeftSidebar}">{{ props.text }}</span>
    </Link>
</template>
