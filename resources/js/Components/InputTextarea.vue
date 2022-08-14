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
    <div class="col-span-6 sm:col-span-4 mt-4">
        <JetLabel :for="id" :value="label" />
        <textarea :id="id"
            class="mt-1 block w-full form-input"
            :value="modelValue"
            @input="updateValue"
        />
        <JetInputError :message="error" class="mt-2" />
    </div>
</template>
