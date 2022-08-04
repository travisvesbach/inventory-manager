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
        },
        options: Array,
        option_value: {
            type: String,
            defualt: null,
        },
        option_label: {
            type: String,
            defualt: null,
        },
        disabled: {
            type: Boolean,
            default: false,
        }
    })

    const emit = defineEmits(['update:modelValue'])

    function focus() {
        this.$refs.input.focus()
    }
    function optionContents(option, selector) {
        if(selector) {
            return option[selector]
        }
        return option;
    }

    function updateValue(event) {
        emit('update:modelValue', event.target.value);
    }
</script>

<template>
    <div class="col-span-6 sm:col-span-4">
        <JetLabel :for="props.id" :value="props.label" />
        <select :id="props.id"
            class="form-input"
            :value="modelValue"
            @input="updateValue" :disabled="props.disabled">
            <option v-for="option in options" :value="optionContents(option, props.option_value)">{{ optionContents(option, props.option_label) }}</option>
        </select>
        <JetInputError :message="props.error" class="mt-2" />
    </div>
</template>

