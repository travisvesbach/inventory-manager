<script setup>
    import JetLabel from '@/Jetstream/Label.vue';
    import JetCheckbox from '@/Jetstream/Checkbox.vue';
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
            default: false
        },
        error: {
            type: String,
            default: ''
        }
    })

    const emit = defineEmits(['update:modelValue'])

    function updateValue(event) {
        emit('update:modelValue', event);
    }

</script>
<template>
    <div class="col-span-6 sm:col-span-4 mt-4">
        <div class="flex items-center">
            <JetCheckbox :id="id"
                class="mr-2"
                :checked="modelValue ? true : false"
                v-on:update:modelValue="updateValue"
            />
            <JetLabel :for="id" :value="label" />
        </div>
        <JetInputError :message="error" class="mt-2" />
    </div>
</template>
