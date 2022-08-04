<script setup>
    import { ref, computed } from 'vue'
    import JetButton from '@/Jetstream/Button.vue';
    import JetActionMessage from '@/Jetstream/ActionMessage.vue';
    import Card from '@/Components/Card.vue'

    const props = defineProps({
        width: {
            type: String,
            default: '1/2'
        },
        form: Object,
    })

    const widthClass = computed(() => {
        return 'md:w-' + props.width;
    })
</script>

<template>
    <form @submit.prevent="$emit('submitted')" class="w-full mx-auto ty-10" :class="widthClass">
        <card>
            <template #header v-if="$slots.header">
                <slot name="header"></slot>
            </template>
            <slot name="description"></slot>
            <slot></slot>
            <template #footer>
                <div class="w-full flex justify-end">
                    <JetActionMessage :on="props.form.recentlySuccessful" class="mr-3">
                        Saved.
                    </JetActionMessage>
                    <JetButton :class="{ 'opacity-25': props.form.processing }" :disabled="props.form.processing">
                        Save
                    </JetButton>
                </div>
            </template>
        </card>
    </form>
</template>

