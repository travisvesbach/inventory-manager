<script setup>
const props = defineProps({
  modelValue: String,
  options: Array,
})

const emit = defineEmits(['update:modelValue'])

function focus() {
    this.$refs.input.focus()
}
function optionContents(option, selector) {
    if(Array.isArray(option)) {
        return option[selector];
    }
    return option;
}
</script>

<template>
    <select class="form-input" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)">
        <option v-for="option in options" :value="optionContents(option, 0)">{{ optionContents(option, 1) }}</option>
    </select>
</template>
