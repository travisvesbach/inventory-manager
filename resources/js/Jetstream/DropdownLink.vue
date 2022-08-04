<script setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/inertia-vue3';

defineProps({
    href: String,
    as: String,
});

const classes = computed(() => {
    return 'block px-4 py-2 text-sm leading-5 transition text-gray-700 focus:outline-none hover:bg-gray-100 focus:bg-gray-100 dark:hover:bg-gray-600 link-color';
})
</script>

<template>
    <div>
        <button v-if="as == 'button'" type="submit" class="w-full text-left" :class="classes">
            <slot />
        </button>

        <a v-else-if="as =='a'" :href="href" :class="classes">
            <slot />
        </a>

        <Link v-else :href="href" :class="classes">
            <slot />
        </Link>
    </div>
</template>
