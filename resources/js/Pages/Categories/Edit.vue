<script setup>
    import { useForm } from '@inertiajs/inertia-vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Form from '@/Components/Form.vue'
    import InputText from '@/Components/InputText.vue'
    import InputSelect from '@/Components/InputSelect.vue'

    const props = defineProps({
        editing: {
            type: Object,
            default: null
        },
        categories: Array,
    })

    const form = useForm({
        id: (props.editing ? props.editing.id : null),
        name: (props.editing ? props.editing.name : null),
        category_id: (props.editing ? props.editing.category_id : null),
        icon: (props.editing ? props.editing.icon : null),
    });

    function submit() {
        if(props.editing) {
            form.patch(route('categories.update', form.id));
        } else {
            form.post(route('categories.store'));
        }
    }
</script>

<template>
    <AppLayout :title="editing && editing.name ? 'Edit Category: ' + editing.name : 'Create Category'">
        <Form :form="form" @submitted="submit">
            <InputText id="name" label="Name" v-model="form.name" :error="form.errors.name" />
            <InputSelect id="category_id" label="Category" v-model="form.category_id" :error="form.errors.category_id" :options="categories" option_value="id" option_label="name" :disabled="categories.length == 0 ? true : false" />
            <InputText id="icon" label="Icon" v-model="form.icon" :error="form.errors.icon"/>
        </Form>
    </AppLayout>

</template>
