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
        console.log(value);
        emit('update:modelValue', value);
    }
</script>

<template>
    <div class="col-span-6 sm:col-span-4 mt-4">
        <JetLabel :for="props.id" :value="props.label" />
        <vSelect :id="props.id"
            :options="props.options"
            :label="props.option_label"
            :reduce="(option) => option[props.option_value]"
            v-model="modelValue"
            v-on:update:modelValue="updateValue"
            :disabled="props.disabled"
            :clearable="props.clearable">
        </vSelect>
        <JetInputError :message="props.error" class="mt-2" />
    </div>
</template>

