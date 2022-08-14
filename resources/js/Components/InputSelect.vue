<script setup>
    import JetLabel from '@/Jetstream/Label.vue';
    import JetInput from '@/Jetstream/Input.vue';
    import JetInputError from '@/Jetstream/InputError.vue';
    import vSelect from 'vue-select';

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
        },
        clearable: {
            type: Boolean,
            default: true,
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

    function updateValue(value) {
        emit('update:modelValue', value);
    }
</script>

<template>
    <div class="col-span-6 sm:col-span-4 mt-4">
        <JetLabel :for="id" :value="label" />
        <vSelect :id="id"
            :options="options"
            :label="option_label"
            :reduce="(option) => option_value ? option[option_value] : option"
            v-model="modelValue"
            v-on:update:modelValue="updateValue"
            :disabled="disabled"
            :clearable="clearable">
        </vSelect>
        <JetInputError :message="error" class="mt-2" />
    </div>
</template>

