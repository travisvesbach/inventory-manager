<script setup>
import { computed } from 'vue';

const props = defineProps({
    type: {
        type: String,
        default: 'button',
    },
    size: {
        type: String,
        default: 'md',
    }
});

const sizeClass = computed(() => {
    return {
        'xs': 'btn-xs',
        'sm': 'btn-sm',
        'md': '',
    }[props.size]
});
</script>

<template>
    <button :type="type" class="btn btn-secondary" :class="sizeClass">
        <slot />
    </button>
</template>
