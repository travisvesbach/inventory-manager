<script setup>
    import JetLabel from '@/Jetstream/Label.vue';
    import JetInput from '@/Jetstream/Input.vue';
    import JetInputError from '@/Jetstream/InputError.vue';

    const props = defineProps({
        id: {
            type: String,
            default: null,
        },
        label: {
            type: String,
            default: ''
        },
        modelValue: {
            default: ''
        },
        type: {
            type: String,
            default: 'text'
        },
        error: {
            type: String,
            default: ''
        }
    })

    const emit = defineEmits(['update:modelValue'])

    function updateValue(event) {
        emit('update:modelValue', event.target.value);
    }

</script>
<template>
    <div class="col-span-6 sm:col-span-4">
        <JetLabel :for="props.id" :value="props.label" />
        <JetInput :id="props.id"
            class="mt-1 block w-full"
            :value="props.modelValue"
            :type="props.type"
            @input="updateValue"
        />
        <JetInputError :message="props.error" class="mt-2" />
    </div>
</template>
