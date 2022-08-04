<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import Form from '@/Components/Form.vue';
import InputText from '@/Components/InputText.vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('user-password.update'), {
        errorBag: 'updatePassword',
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }

            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <Form :form="form" @submitted="updatePassword">
        <template #header>
            Update Password
        </template>
        <template #description>
            Ensure your account is using a long, random password to stay secure.
        </template>

        <InputText id="current_password" type="password" label="Current Password" v-model="form.current_password" :error="form.errors.current_password" />

        <InputText id="password" type="password" label="New Password" v-model="form.password" :error="form.errors.password" />

        <InputText id="password_confirmation" type="password_confirmation" label="Confirm Password" v-model="form.password_confirmation" :error="form.errors.password_confirmation" />
    </Form>
</template>
