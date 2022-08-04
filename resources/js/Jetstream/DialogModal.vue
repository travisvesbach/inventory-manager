<script setup>
import Modal from './Modal.vue';
import Card from '@/Components/Card.vue';

const emit = defineEmits(['close']);

defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: '2xl',
    },
    closeable: {
        type: Boolean,
        default: true,
    },
});

const close = () => {
    emit('close');
};
</script>

<template>
    <Modal
        :show="show"
        :max-width="maxWidth"
        :closeable="closeable"
        @close="close"
    >
        <Card>
            <template #header>
                <slot name="title" />
            </template>

            <slot name="content" />

            <template #footer>
                <slot name="footer" />
            </template>
        </Card>
    </Modal>
</template>
