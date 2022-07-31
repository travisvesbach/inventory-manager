<script setup>
    import { ref, computed } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3';
    import JetDropdown from '@/Jetstream/Dropdown.vue';
    import JetDropdownLink from '@/Jetstream/DropdownLink.vue';

    const props = defineProps({
        headers: Object,
        data: Object,
        actions: {
            type: Array,
            default: null
        },
        route_slug: String,
    })

    const search = ref(null);
    const sort_key = ref(null);
    const sort_reverse = ref(false);

    const buttonClasses = computed(() => {
        let classes = props.button_classes + ' ';
        classes += (props.button_width ?? 'w-full')
        classes += '  justify' + (props.justify ?? '-between')
        return classes;
    })



    const filtered = computed(() => {
        let filtered = props.data;
        if(search.value) {
            let searching = search.value.toLowerCase();
            filtered = filtered.filter(function(item) {
                if (item.name.toLowerCase().includes(searching)) {
                    return true;
                } else {
                    return false;
                }
            });
        }

        let sort = (sort_key.value ?? props.headers[0].key);
        if(!sort_reverse.value) {
            filtered.sort(function(a, b) {
                if(isNaN(a[sort]) && isNaN(b[sort])) {
                    return a[sort].localeCompare(b[sort]);
                } else {
                    return a[sort] - b[sort];
                }

            });
        } else {
            filtered.sort(function(a, b) {
                if(isNaN(a[sort]) && isNaN(b[sort])) {
                    return b[sort].localeCompare(a[sort]);
                } else {
                    return b[sort] - a[sort];
                }

            });
        }
        console.log(filtered);
        return filtered;
    })

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
</script>

<template>
    <table class="w-full">
        <thead>
            <tr class="border-b-2 border-color" v-if="props.headers">
                <th class="p-1 text-left cursor-pointer" @click="sortBy(header.key)" v-for="header in props.headers">{{ header.label }}</th>
            </tr>
        </thead>
        <tbody>
            <tr class="border-b-2 border-color hover-trigger" v-for="item in filtered">
                <td class="py-2 px-1" v-for="header in props.headers">
                    <Link :href="item.path" class="text-lg link-color" v-html="highlight(item[header.key])" v-if="item[header.key] && header.format == 'link'"/>
                    <i :class="item[header.key]" v-else-if="header.format == 'icon' && item[header.key]"/>
                    <span class="text-lg link-color" v-html="highlight(item[header.key])" v-else/>
                </td>
                <td class="py-2 px-1" v-if="props.actions">
                    <!-- dropdown -->
                    <JetDropdown align="right" width="48" class="hover-target">
                        <template #trigger>
                            <button class="ml-auto flex link link-color">
                                <svg class="fill-current h-8 w-8" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </template>

                        <template #content>
                            <div>
                                <JetDropdownLink :href="route(props.route_slug + '.edit', item.id)" v-if="props.actions.includes('edit')">
                                    Edit
                                </JetDropdownLink>
                                <JetDropdownLink :href="route(props.route_slug + '.destroy', item.id)" v-if="props.actions.includes('delete')">
                                    Delete
                                </JetDropdownLink>
                            </div>
                        </template>
                    </JetDropdown>
                </td>
            </tr>
        </tbody>
    </table>
</template>
