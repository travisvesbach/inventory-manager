<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import JetActionMessage from '@/Jetstream/ActionMessage.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetConfirmationModal from '@/Jetstream/ConfirmationModal.vue';
import JetDangerButton from '@/Jetstream/DangerButton.vue';
import JetDialogModal from '@/Jetstream/DialogModal.vue';
import JetCheckbox from '@/Jetstream/Checkbox.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue';
import JetSectionBorder from '@/Jetstream/SectionBorder.vue';
import Card from '@/Components/Card.vue';
import Form from '@/Components/Form.vue';
import InputText from '@/Components/InputText.vue';

const props = defineProps({
    tokens: Array,
    availablePermissions: Array,
    defaultPermissions: Array,
});

const createApiTokenForm = useForm({
    name: '',
    permissions: props.defaultPermissions,
});

const updateApiTokenForm = useForm({
    permissions: [],
});

const deleteApiTokenForm = useForm();

const displayingToken = ref(false);
const managingPermissionsFor = ref(null);
const apiTokenBeingDeleted = ref(null);

const createApiToken = () => {
    createApiTokenForm.post(route('api-tokens.store'), {
        preserveScroll: true,
        onSuccess: () => {
            displayingToken.value = true;
            createApiTokenForm.reset();
        },
    });
};

const manageApiTokenPermissions = (token) => {
    updateApiTokenForm.permissions = token.abilities;
    managingPermissionsFor.value = token;
};

const updateApiToken = () => {
    updateApiTokenForm.put(route('api-tokens.update', managingPermissionsFor.value), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => (managingPermissionsFor.value = null),
    });
};

const confirmApiTokenDeletion = (token) => {
    apiTokenBeingDeleted.value = token;
};

const deleteApiToken = () => {
    deleteApiTokenForm.delete(route('api-tokens.destroy', apiTokenBeingDeleted.value), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => (apiTokenBeingDeleted.value = null),
    });
};
</script>

<template>
    <div>
        <!-- Generate API Token -->
        <Form :form="createApiTokenForm"  @submitted="createApiToken">
            <template #header>
                Create API Token
            </template>

            <template #description>
                API tokens allow third-party services to authenticate with our application on your behalf.
            </template>

            <InputText id="name" label="Name" v-model="createApiTokenForm.name" :error="createApiTokenForm.errors.name" />

            <!-- Token Permissions -->
            <div v-if="availablePermissions.length > 0" class="col-span-6 mt-4">
                <JetLabel for="permissions" value="Permissions" />

                <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div v-for="permission in availablePermissions" :key="permission">
                        <label class="flex items-center">
                            <JetCheckbox v-model:checked="createApiTokenForm.permissions" :value="permission" />
                            <span class="ml-2 text-sm">{{ permission }}</span>
                        </label>
                    </div>
                </div>
            </div>

            <template #actions>
                <JetActionMessage :on="createApiTokenForm.recentlySuccessful" class="mr-3">
                    Created.
                </JetActionMessage>

                <JetButton :class="{ 'opacity-25': createApiTokenForm.processing }" :disabled="createApiTokenForm.processing">
                    Create
                </JetButton>
            </template>
        </Form>

        <div v-if="tokens.length > 0">
            <JetSectionBorder />

            <!-- Manage API Tokens -->
            <div class="mt-10 sm:mt-0">
                <Card>
                    <template #header>
                        Manage API Tokens
                    </template>

                    <div>
                        You may delete any of your existing tokens if they are no longer needed.
                    </div>

                    <!-- API Token List -->
                    <div class="space-y-6 mt-5">
                        <div v-for="token in tokens" :key="token.id" class="flex items-center justify-between">
                            <div>
                                {{ token.name }}
                            </div>

                            <div class="flex items-center">
                                <div v-if="token.last_used_ago" class="text-sm text-gray-400">
                                    Last used {{ token.last_used_ago }}
                                </div>

                                <button
                                    v-if="availablePermissions.length > 0"
                                    class="cursor-pointer ml-6 text-sm text-gray-400 underline"
                                    @click="manageApiTokenPermissions(token)"
                                >
                                    Permissions
                                </button>

                                <button class="cursor-pointer ml-6 text-sm text-red-500" @click="confirmApiTokenDeletion(token)">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </Card>
            </div>
        </div>

        <!-- Token Value Modal -->
        <JetDialogModal :show="displayingToken" @close="displayingToken = false">
            <template #title>
                API Token
            </template>

            <template #content>
                <div>
                    Please copy your new API token. For your security, it won't be shown again.
                </div>

                <div v-if="$page.props.jetstream.flash.token" class="mt-4 bg-gray-100 px-4 py-2 rounded font-mono text-sm text-gray-500">
                    {{ $page.props.jetstream.flash.token }}
                </div>
            </template>

            <template #footerend>
                <JetSecondaryButton @click="displayingToken = false">
                    Close
                </JetSecondaryButton>
            </template>
        </JetDialogModal>

        <!-- API Token Permissions Modal -->
        <JetDialogModal :show="managingPermissionsFor != null" @close="managingPermissionsFor = null">
            <template #title>
                API Token Permissions
            </template>

            <template #content>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div v-for="permission in availablePermissions" :key="permission">
                        <label class="flex items-center">
                            <JetCheckbox v-model:checked="updateApiTokenForm.permissions" :value="permission" />
                            <span class="ml-2 text-sm">{{ permission }}</span>
                        </label>
                    </div>
                </div>
            </template>

            <template #footer>
                <div class="w-full flex justify-between">
                    <JetSecondaryButton @click="managingPermissionsFor = null">
                        Cancel
                    </JetSecondaryButton>

                    <JetButton
                        class="ml-3"
                        :class="{ 'opacity-25': updateApiTokenForm.processing }"
                        :disabled="updateApiTokenForm.processing"
                        @click="updateApiToken"
                    >
                        Save
                    </JetButton>
                </div>
            </template>
        </JetDialogModal>

        <!-- Delete Token Confirmation Modal -->
        <JetConfirmationModal :show="apiTokenBeingDeleted != null" @close="apiTokenBeingDeleted = null">
            <template #title>
                Delete API Token
            </template>

            <template #content>
                Are you sure you would like to delete this API token?
            </template>

            <template #footer>
                <div class="w-full flex justify-between">
                    <JetSecondaryButton @click="apiTokenBeingDeleted = null">
                        Cancel
                    </JetSecondaryButton>

                    <JetDangerButton
                        class="ml-3"
                        :class="{ 'opacity-25': deleteApiTokenForm.processing }"
                        :disabled="deleteApiTokenForm.processing"
                        @click="deleteApiToken"
                    >
                        Delete
                    </JetDangerButton>
                </div>
            </template>
        </JetConfirmationModal>
    </div>
</template>
