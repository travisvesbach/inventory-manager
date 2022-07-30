<script setup>
    import TransitionExpand from '@/Components/TransitionExpand.vue'
    import { ref, inject, computed } from 'vue'

    const props = defineProps({
        id: String,
        justify: String,
        icon_size: String,
        button_width: String,
        button_classes: String,
        button_weight: String,
    })

    const setActive = inject('setActive')

    const show = ref(false);

    const iconClasses = computed(() => {
        let classes = ''
        classes += (show.value == true ? ' -rotate-90' : '')
        classes += (props.icon_size == 'sm' ? ' h-3 w-3' : ' h-4 w-4');
        return classes;
    })

    const buttonClasses = computed(() => {
        let classes = props.button_classes + ' ';
        classes += (props.button_width ?? 'w-full')
        classes += '  justify' + (props.justify ?? '-between')
        return classes;
    })

    const toggle = function(value) {
        if(value != show.value) {
            show.value = value;
            setActive(this, value);
        }
    }

    defineExpose({show, toggle})
</script>

<template>
    <div class="accordion-item">
        <button class="btn-text flex items-center" :class="buttonClasses" @click="toggle(!show)">
            <slot name="title"></slot>
            <svg xmlns="https://www.w3.org/2000/svg" class="transform ease-in duration-200" :class="iconClasses" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <TransitionExpand>
            <div class="accorion-item-content h-auto" v-if="show">
                <slot></slot>
            </div>
        </TransitionExpand>
    </div>
</template>

