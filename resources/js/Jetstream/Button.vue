<script setup>
import { computed } from 'vue';

const props = defineProps({
    type: {
        type: String,
        default: 'submit',
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
    <button :type="type" class="btn btn-primary" :class="sizeClass">
        <slot />
    </button>
</template>
