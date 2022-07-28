<script setup>
    import { ref, provide } from 'vue'

    provide('setActive', setActive);

    const active = ref(null);

    function setActive(item, open) {
        if(active.value && active.value.show) {
            active.value.toggle()
        }
        if(open == false) {
            active.value = null;
        } else {
            active.value = item;
        }
    }
</script>

<template>
    <div>
        <slot></slot>
    </div>
</template>
