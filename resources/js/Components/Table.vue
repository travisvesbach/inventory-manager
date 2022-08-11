<script setup>
    import { ref, computed } from 'vue'
    import { Link, useForm } from '@inertiajs/inertia-vue3';
    import JetDropdown from '@/Jetstream/Dropdown.vue';
    import JetDropdownLink from '@/Jetstream/DropdownLink.vue';
    import JetInput from '@/Jetstream/Input.vue';
    import JetButton from '@/Jetstream/Button.vue';
    import JetDangerButton from '@/Jetstream/DangerButton.vue';
    import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue';
    import JetCheckbox from '@/Jetstream/Checkbox.vue';
    import InputCheckbox from '@/Components/InputCheckbox.vue';
    import JetConfirmationModal from '@/Jetstream/ConfirmationModal.vue';

    const props = defineProps({
        headers: Object,
        data: Object,
        actions: {
            type: Array,
            default: null
        },
        route_slug: String,
        search: {
            type: Boolean,
            default: true
        },
    })

    const empty_char = '&#8212';

    const search        = ref(null);
    const sort_key      = ref(null);
    const sort_reverse  = ref(false);
    const page_number   = ref(1);
    const per_page      = ref(3);
    const selected      = ref([]);
    const deleting      = ref(null);

    const form_delete   = useForm({
        id: null,
        ids: null,
    });


    const buttonClasses = computed(() => {
        let classes = props.button_classes + ' ';
        classes += (props.button_width ?? 'w-full')
        classes += '  justify' + (props.justify ?? '-between')
        return classes;
    })

    const filtered = computed(() => {
        let filtered = props.data ?? [];
        if(search.value) {
            let searching = search.value.toLowerCase();
            filtered = filtered.filter(function(item) {
                for(let header of props.headers) {
                    let search_value = (header.subkey && item[header.key] ? item[header.key][header.subkey] : item[header.key]);
                    if(header.format == 'boolean' && !isNaN(search_value)) {
                        search_value = search_value ? (header.true_text ?? null) : (header.false_text ?? null);
                    }
                    if(search_value && search_value.toLowerCase().includes(searching)) {
                        return true;
                    }
                }
                return false;
            });
        }

        let sort = (sort_key.value ?? props.headers[0].key);
        let sort_subkey = (props.headers.find(obj => obj.key === sort).subkey ?? false)
        if(!sort_reverse.value) {
            filtered.sort(function(a, b) {
                let a_sort = (a[sort] != null && sort_subkey ? a[sort][sort_subkey] : a[sort]);
                let b_sort = (b[sort] != null && sort_subkey ? b[sort][sort_subkey] : b[sort]);
                if(a_sort == null) {
                    return 1
                } else if(a_sort == null && b_sort == null) {
                    return 0
                } else if(b_sort == null) {
                    return -1
                } else if(isNaN(a_sort) && isNaN(b_sort)) {
                    return a_sort.localeCompare(b_sort);
                } else {
                    return a_sort - b_sort;
                }
            });
        } else {
            filtered.sort(function(a, b) {
                let a_sort = (a[sort] != null && sort_subkey ? a[sort][sort_subkey] : a[sort]);
                let b_sort = (b[sort] != null && sort_subkey ? b[sort][sort_subkey] : b[sort]);
                if(a_sort == null) {
                    return -1
                } else if(a_sort == null && b_sort == null) {
                    return 0
                } else if(b_sort == null) {
                    return +1
                } else if(isNaN(a_sort) && isNaN(b_sort)) {
                    return b_sort.localeCompare(a_sort);
                } else {
                    return b_sort - a_sort;
                }
            });
        }
        return filtered;
    })

    const page_count = computed(() => {
        if (filtered.value != null) {
            return Math.ceil(filtered.value.length / per_page.value);
        }
    })

    const paginated_data = computed(() => {
        let start = (page_number.value - 1) * per_page.value;
        let end = start + per_page.value;
        return filtered.value.slice(start, end);
    })

    function formatBoolean(input, header) {
        return input ? (header.true_text ?? empty_char) : (header.false_text ?? empty_char);
    }

    function content(input) {
        return highlight(input ?? empty_char);
    }

    function highlight(content) {
        if(!content) {
            return '';
        }
        if(!search.value) {
            return content;
        }
        return content.replace(new RegExp(search.value, "gi"), match => {
            return '<span class="highlight">' + match + '</span>';
        });
    }

    function sortBy(key) {
        sort_reverse.value = (sort_key.value == key ? ! sort_reverse.value : false);
        sort_key.value = key;
    }

    function deleteItem(item) {
        form_delete.id = (item ? item.id : null);

        form_delete.delete(route(props.route_slug + '.destroy', item.id), {
            onSuccess: () => {
                form_delete.reset();
                deleting.value = null;
            },
        });
    }

    function deleteSelected() {
        form_delete.ids = selected.value;

        form_delete.post(route(props.route_slug + '.bulk_destroy'), {
            onSuccess: () => {
                form_delete.reset();
                deleting.value = null;
            },
        });
    }

    function toggleSelected(item) {
        if(selected.value.includes(item.id)) {
            removeSelected(item);
        } else {
            addSelected(item);
        }
    }

    function addSelected(item) {
        if(!selected.value.includes(item.id)) {
            selected.value.push(item.id);
        }
    }

    function removeSelected(item) {
        if(selected.value.includes(item.id)) {
            selected.value.splice(selected.value.indexOf(item.id), 1);
        }
    }

    function toggleSelectPage(event) {
        for(let item of paginated_data.value) {
            if(event.target.checked) {
                addSelected(item);
            } else {
                removeSelected(item);
            }
        }
    }
</script>

<template>
    <div>
        <div class="flex justify-between">
            <div>
                <slot></slot>
            </div>
            <JetInput class="p-1" type="text" v-model="search" placeholder="search" v-if="props.search"/>
        </div>
        <table class="w-full mt-2">
            <thead>
                <tr class="border-b-2 border-color" v-if="props.headers">
                    <th class="flex">
                        <!-- <JetCheckbox title="Select All" /> -->

                        <!-- dropdown -->
                        <JetDropdown align="left" width="48" class="">
                            <template #trigger>
                                <button class="ml-auto flex link link-color">
                                    <svg class="fill-current h-8 w-8" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </template>

                            <template #content>
                                <div class="px-4 py-2 text-sm">
                                    <InputCheckbox id="select-page" class="mt-0" label="Select all on page" @click="toggleSelectPage"/>
                                </div>
                            </template>
                        </JetDropdown>

                        <button @click="deleting = 'bulk'"
                            class="btn btn-sm btn-square btn-danger ml-2"
                            title="Delete"
                            as="button"
                            v-if="props.actions.includes('delete')">
                            <i class="fa-solid fa-trash"></i>
                        </button>

                    </th>
                    <th class="p-1 text-left cursor-pointer" @click="sortBy(header.key)" v-for="header in props.headers">{{ header.label }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="paginated_data.length == 0" class="text-center">
                    <td colspan="100%">
                        No results
                    </td>
                </tr>
                <tr class="border-b-2 border-color" v-for="item in paginated_data" v-else>
                    <td>
                        <JetCheckbox :value="item.id.toString()" :checked="selected.includes(item.id)" @click="toggleSelected(item)"/>
                    </td>
                    <td class="py-2 px-1" v-for="header in props.headers">
                        <!-- link -->
                        <Link :href="item.path"
                            class="text-lg link link-color"
                            v-html="content(item[header.key])"
                            v-if="header.format == 'link' && item[header.key]"/>
                        <!-- obj_link -->
                        <Link :href="item[header.key].path"
                            class="text-lg link link-color"
                            v-html="content(item[header.key][header.subkey])"
                            v-else-if="header.format == 'obj_link' && item[header.key] && item[header.key][header.subkey]"/>
                        <!-- icon -->
                        <i :class="item[header.key]"
                            v-else-if="header.format == 'icon' && item[header.key]"/>
                        <!-- boolean -->
                        <span class="text-lg"
                            v-html="content(formatBoolean(item[header.key], header))"
                            v-else-if="header.format == 'boolean'"/>
                        <!-- text -->
                        <span class="text-lg"
                            v-html="content(item[header.key])"
                            v-else/>
                    </td>
                    <td class="py-2 px-1 flex justify-end" v-if="props.actions">
                        <Link :href="route(props.route_slug + '.edit', item.id)"
                            class="btn btn-sm btn-square btn-primary"
                            title="Edit"
                            as="button"
                            v-if="props.actions.includes('edit')">
                            <i class="fa-solid fa-pencil text-lg"></i>
                        </Link>
                        <button @click="deleting = item"
                            class="btn btn-sm btn-square btn-danger ml-2"
                            title="Delete"
                            as="button"
                            v-if="props.actions.includes('delete')">
                            <i class="fa-solid fa-trash text-lg"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="mt-5 flex justify-center" v-if="page_number > 1 || page_count > 1">
            <JetSecondaryButton class="btn btn-sm mx-3" @click="page_number--" :disabled="page_number == 1">Previous</JetSecondaryButton>

            <span class="link link-secondary-color cursor-pointer mx-1" @click="page_number = 1" v-if="page_number != 1">1</span>
            <span class="mx-1" @click="page_number = page_number - 2" v-if="page_number - 3 > 1">...</span>
            <span class="link link-secondary-color cursor-pointer mx-1" @click="page_number = page_number - 2" v-if="page_number - 2 > 1">{{ page_number - 2 }}</span>
            <span class="link link-secondary-color cursor-pointer mx-1" @click="page_number = page_number - 1" v-if="page_number - 1 > 1">{{ page_number - 1 }}</span>
            <span class="mx-1">{{ page_number }}</span>
            <span class="link link-secondary-color cursor-pointer mx-1" @click="page_number = page_number + 1" v-if="page_number + 1 < page_count">{{ page_number + 1 }}</span>
            <span class="link link-secondary-color cursor-pointer mx-1" @click="page_number = page_number + 2" v-if="page_number + 2 < page_count">{{ page_number + 2 }}</span>
            <span class="mx-1" @click="page_number = page_number - 2" v-if="page_number + 3 < page_count">...</span>
            <span class="link link-secondary-color cursor-pointer mx-1" @click="page_number = page_count" v-if="page_number < page_count">{{ page_count }}</span>

            <JetSecondaryButton class="btn btn-sm mx-3" @click="page_number++" :disabled="page_number >= page_count || page_count <= 1">Next</JetSecondaryButton>
        </div>

        <!-- delete confirmation modal -->
        <JetConfirmationModal :show="deleting ? true : false" @close="deleting = null">
            <template #title>
                Delete
            </template>

            <template #content>
                Are you sure you would like to delete {{ deleting == 'bulk' ? 'the selected items' : 'this item' }}?
            </template>

            <template #footer>
                <div class="w-full flex justify-between">
                    <JetSecondaryButton @click="deleting = null">
                        Cancel
                    </JetSecondaryButton>

                    <JetDangerButton
                        class="ml-3"
                        :class="{ 'opacity-25': form_delete.processing }"
                        :disabled="form_delete.processing"
                        @click="deleting == 'bulk' ? deleteSelected() : deleteItem(deleting)"
                    >
                        Delete
                    </JetDangerButton>
                </div>
            </template>
        </JetConfirmationModal>
    </div>
</template>
