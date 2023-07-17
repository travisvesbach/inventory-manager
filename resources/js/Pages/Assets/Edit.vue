<script setup>
    import { useForm } from '@inertiajs/inertia-vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Form from '@/Components/Form.vue'
    import InputText from '@/Components/InputText.vue'
    import InputSelect from '@/Components/InputSelect.vue'
    import InputDate from '@/Components/InputDate.vue'
    import InputTextarea from '@/Components/InputTextarea.vue'

    const props = defineProps({
        editing: {
            type: Object,
            default: null
        },
        categories: Array,
        locations: Array,
        assets: Array,
    })

    const form = useForm({
        id: (props.editing ? props.editing.id : null),
        name: (props.editing ? props.editing.name : null),
        category_id: (props.editing ? props.editing.category_id : null),
        location_id: (props.editing ? props.editing.location_id : null),
        acquisition_date: (props.editing ? props.editing.acquisition_date : null),
        acquisition_price: (props.editing ? props.editing.acquisition_price : null),
        disposition_date: (props.editing ? props.editing.disposition_date : null),
        disposition_price: (props.editing ? props.editing.disposition_price : null),
        info_url: (props.editing ? props.editing.info_url : null),
        notes: (props.editing ? props.editing.notes : null),
        parent_id: (props.editing ? props.editing.parent_id : null),
        checkout_date: (props.editing ? props.editing.checkout_date : null),
    });

    function submit() {
        if(props.editing) {
            form.patch(route('assets.update', form.id));
        } else {
            form.post(route('assets.store'));
        }
    }
</script>

<template>
    <AppLayout :title="editing && editing.name ? 'Edit Location: ' + editing.name : 'Create Location'">
        <Form :form="form" @submitted="submit">
            <InputText id="name" label="Name" v-model="form.name" :error="form.errors.name" />
            <InputSelect id="category_id" label="Category" v-model="form.category_id" :error="form.errors.category_id" :options="categories" option_value="id" option_label="name" :disabled="categories.length == 0 ? true : false" />
            <InputSelect id="location_id" label="Location" v-model="form.location_id" :error="form.errors.location_id" :options="locations" option_value="id" option_label="name" :disabled="locations.length == 0 || form.parent_id ? true : false" />
            <InputDate id="acquisition_date" label="Acquisition Date" v-model="form.acquisition_date" :error="form.errors.acquisition_date" />
            <InputText id="acquisition_price" label="Acquisition Price" type="number" step="0.01" min="0" max="999999.99" v-model="form.acquisition_price" :error="form.errors.acquisition_price" />
            <InputDate id="disposition_date" label="Disposition Date" v-model="form.disposition_date" :error="form.errors.disposition_date" />
            <InputText id="disposition_price" label="Disposition Price" type="number" step="0.01" min="0" max="999999.99" v-model="form.disposition_price" :error="form.errors.disposition_price" />
            <InputText id="info_url" label="Info URL" v-model="form.info_url" :error="form.errors.info_url" />
            <InputTextarea id="notes" label="Notes" v-model="form.notes" :error="form.errors.notes" />
            <InputSelect id="parent_id" label="Checkout To" v-model="form.parent_id" :error="form.errors.parent_id" :options="assets" option_value="id" option_label="name" :disabled="assets.length == 0 ? true : false" />
            <InputDate id="checkout_date" label="Checkout Date" v-model="form.checkout_date" :error="form.errors.checkout_date" />
        </Form>
    </AppLayout>

</template>
