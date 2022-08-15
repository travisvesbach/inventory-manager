<script setup>
    import { computed } from 'vue'
    import { usePage } from '@inertiajs/inertia-vue3';
    import JetLabel from '@/Jetstream/Label.vue';
    import JetInput from '@/Jetstream/Input.vue';
    import JetInputError from '@/Jetstream/InputError.vue';
    import Datepicker from '@vuepic/vue-datepicker';
    import '@vuepic/vue-datepicker/dist/main.css'

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

    function updateValue(value) {
        emit('update:modelValue', value);
    }

    const darkMode = computed(() => {
        let theme = usePage().props.value.user ? usePage().props.value.user.theme : null;
        if((theme == 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches) || theme == 'dark') {
            return true;
        }
        return false;
    });

</script>
<template>
    <div class="col-span-6 sm:col-span-4 mt-4">
        <JetLabel :for="id" :value="label" />
        <Datepicker
            class="mt-1"
            v-model="modelValue"
            v-on:update:modelValue="updateValue"
            :enableTimePicker="false"
            :autoApply="true"
            format="yyyy-MM-dd"
            model-type="format"
            position="left"
            inputClassName="form-input hover:!border-zinc-800 text-color"
            teleport="#layout"
            :dark="darkMode"
            :transitions="false"
            :hideInputIcon="true"
        >
        </Datepicker>
        <JetInputError :message="error" class="mt-2" />
    </div>
</template>

<style>
    .dp__theme_light {
       --dp-text-color: rgb(55, 65, 81);
       --dp-primary-color: rgb(88, 28, 135);
       --dp-primary-text-color: rgb(255, 255, 255);
    }

    .dp__theme_dark {
       --dp-background-color: rgb(63 63 70);
       --dp-text-color: rgb(209 213 219);
       --dp-primary-color: rgb(216 180 254);
       --dp-primary-text-color: rgb(0 0 0);
    }
</style>
