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
        locations: Array,
    })

    const states = ['Alabama','Alaska','American Samoa','Arizona','Arkansas','California','Colorado','Connecticut','Delaware','District of Columbia','Federated States of Micronesia','Florida','Georgia','Guam','Hawaii','Idaho','Illinois','Indiana','Iowa','Kansas','Kentucky','Louisiana','Maine','Marshall Islands','Maryland','Massachusetts','Michigan','Minnesota','Mississippi','Missouri','Montana','Nebraska','Nevada','New Hampshire','New Jersey','New Mexico','New York','North Carolina','North Dakota','Northern Mariana Islands','Ohio','Oklahoma','Oregon','Palau','Pennsylvania','Puerto Rico','Rhode Island','South Carolina','South Dakota','Tennessee','Texas','Utah','Vermont','Virgin Island','Virginia','Washington','West Virginia','Wisconsin','Wyoming']

    const countries = ['United States']

    const form = useForm({
        id: (props.editing ? props.editing.id : null),
        name: (props.editing ? props.editing.name : null),
        location_id: (props.editing ? props.editing.location_id : null),
        address: (props.editing ? props.editing.address : null),
        address_secondary: (props.editing ? props.editing.address_secondary : null),
        city: (props.editing ? props.editing.city : null),
        state: (props.editing ? props.editing.state : null),
        country: (props.editing ? props.editing.country : null),
        zipcode: (props.editing ? props.editing.zipcode : null),
        latitude: (props.editing ? props.editing.latitude : null),
        longitude: (props.editing ? props.editing.longitude : null),
    });

    function submit() {
        if(props.editing) {
            form.patch(route('locations.update', form.id));
        } else {
            form.post(route('locations.store'));
        }
    }
</script>

<template>
    <AppLayout :title="editing && editing.name ? 'Edit Location: ' + editing.name : 'Create Location'">
        <Form :form="form" @submitted="submit">
            <InputText id="name" label="Name" v-model="form.name" :error="form.errors.name" />
            <InputSelect id="location_id" label="Location" v-model="form.location_id" :error="form.errors.location_id" :options="locations" option_value="id" option_label="name" :disabled="locations.length == 0 ? true : false" />
            <InputText id="address" label="Address" v-model="form.address" :error="form.errors.address"/>
            <InputText id="address_secondary" label="Address 2" v-model="form.address_secondary" :error="form.errors.address_secondary"/>
            <InputText id="city" label="City" v-model="form.city" :error="form.errors.city"/>
            <InputSelect id="state" label="State" v-model="form.state" :error="form.errors.state" :options="states" />
            <InputSelect id="country" label="Country" v-model="form.country" :error="form.errors.country" :options="countries" />
            <InputText id="zipcode" label="Zipcode" v-model="form.zipcode" :error="form.errors.zipcode"/>
            <InputText id="latitude" label="Latitude" v-model="form.latitude" :error="form.errors.latitude"/>
            <InputText id="longitude" label="Longitude" v-model="form.longitude" :error="form.errors.longitude"/>
        </Form>
    </AppLayout>

</template>
