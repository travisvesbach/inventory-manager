<script setup>
    import { Link } from '@inertiajs/inertia-vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Card from '@/Components/Card.vue'

    const props = defineProps({
        showing: {
            type: Object,
            default: null
        },
    })
</script>
<template>
    <AppLayout :title="showing.name">
        <div class="grid sm:grid-cols-2 gap-4">
            <Card class="w-full">
                <template #header>
                    Details
                </template>
                <table class="w-full">
                    <tr>
                        <td>
                            Name
                        </td>
                        <td>
                            {{ showing.name }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Email:
                        </td>
                        <td>
                            <a :href="'mailto:'+showing.email"
                                class="text-lg link-color"
                                v-html="showing.email"/>
                        </td>
                    </tr>
                    <tr v-if="$page.props.user.admin">
                        <td>
                            Admin:
                        </td>
                        <td>
                            {{ showing.admin ? 'True' : 'False' }}
                        </td>
                    </tr>
                </table>
            </Card>
        </div>
    </AppLayout>
</template>
