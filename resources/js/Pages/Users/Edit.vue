<script setup>
    import { useForm } from '@inertiajs/inertia-vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Form from '@/Components/Form.vue';
    import InputText from '@/Components/InputText.vue';
    import InputCheckbox from '@/Components/InputCheckbox.vue';

    const props = defineProps({
        editing: {
            type: Object,
            default: null
        },
    })

    const form = useForm({
        id: (props.editing ? props.editing.id : null),
        name: (props.editing ? props.editing.name : null),
        email: (props.editing ? props.editing.email : null),
        password: null,
        password_confirmation: null,
        admin: (props.editing ? props.editing.admin : false),
    });

    function submit() {
        if(props.editing) {
            form.patch(route('users.update', form.id));
        } else {
            form.post(route('users.store'));
        }
    }
</script>

<template>
    <AppLayout :title="editing && editing.name ? 'Edit Category: ' + editing.name : 'Create Category'">
        <Form :form="form" @submitted="submit">
            <InputText id="name" label="Name" v-model="form.name" :error="form.errors.name" />
            <InputText id="email" label="Email" type="email" v-model="form.email" :error="form.errors.email" />
            <InputText id="password" label="Password" type="password" v-model="form.password" :error="form.errors.password" />
            <InputText id="password_confirmation" label="Password" type="password" v-model="form.password_confirmation" :error="form.errors.password_confirmation" />
            <InputCheckbox id="admin" label="Admin" v-model="form.admin" :error="form.errors.admin" />
        </Form>
    </AppLayout>

</template>
