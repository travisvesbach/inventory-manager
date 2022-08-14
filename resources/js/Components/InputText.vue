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
        step: {
            type: String,
            default: null
        },
        min: {
            type: String,
            default: null
        },
        max: {
            type: String,
            default: null
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
        <JetInput :id="id"
            class="mt-1 block w-full"
            :value="modelValue"
            :type="type"
            :step="step"
            :min="min"
            :max="max"
            @input="updateValue"
        />
        <JetInputError :message="error" class="mt-2" />
    </div>
</template>
