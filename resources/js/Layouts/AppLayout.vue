<script setup>
import { ref, provide, computed } from 'vue'
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { usePage } from '@inertiajs/inertia-vue3';
import JetApplicationMark from '@/Jetstream/ApplicationMark.vue';
import JetBanner from '@/Jetstream/Banner.vue';
import JetDropdown from '@/Jetstream/Dropdown.vue';
import JetDropdownLink from '@/Jetstream/DropdownLink.vue';
import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue';
import Accordion from '@/Components/Accordion.vue';
import AccordionItem from '@/Components/AccordionItem.vue';
import SidebarLink from '@/Components/SidebarLink.vue';
import SidebarAccordionItem from '@/Components/SidebarAccordionItem.vue';
import SidebarDivider from '@/Components/SidebarDivider.vue';
import SidebarCategoryItem from '@/Components/SidebarCategoryItem.vue';
import DropdownDivider from '@/Components/DropdownDivider.vue';
import DropdownHeader from '@/Components/DropdownHeader.vue';
import PageHeading from '@/Components/PageHeading.vue';
import PageContent from '@/Components/PageContent.vue';
import Flash from '@/Components/Flash.vue';

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const showingLeftSidebar = ref(false);

const switchToTeam = (team) => {
    Inertia.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    Inertia.post(route('logout'));
};

const themeClass = computed(() => {
    let theme = usePage().props.value.user ? usePage().props.value.user.theme : null;
    if((theme == 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches) || theme == 'dark') {
        return 'dark';
    }
    return 'light';
})

provide('showingLeftSidebar', showingLeftSidebar);
</script>

<template>
    <div id="layout" class="flex" :class="themeClass">
        <div class="w-[50px] hover:w-[300px] bg-zinc-900 text-gray-400 px-2 transition-all duration-500 group" :class="{'w-[300px]': showingLeftSidebar, 'w-[50px]': ! showingLeftSidebar}">
            <!-- Logo -->
            <div class="flex my-2 items-end">
                <Link :href="route('dashboard')">
                    <JetApplicationMark class="block h-8 w-8" />
                </Link>
                <span class="pl-2 opacity-0 group-hover:opacity-100 transition-all duration-500 whitespace-nowrap font-bold text-lg overflow-x-hidden" :class="{'opacity-100': showingLeftSidebar, 'opacity-0': ! showingLeftSidebar}">Zasset</span>
            </div>
            <SidebarDivider/>

            <Accordion>
                <SidebarLink :href="route('assets.index')" text="Assets" icon="fa-solid fa-list"/>

                <SidebarCategoryItem :category="category" v-for="category in $page.props.categories_top" />

                <SidebarLink :href="route('locations.index')" text="Locations" icon="fa-solid fa-location-dot"/>
                <SidebarAccordionItem id="firearms" title="Settings" icon="fa-solid fa-gear">
                    <SidebarLink :href="route('categories.index')" text="Categories" icon="fa-solid fa-object-group"/>
                    <SidebarLink :href="route('users.index')" text="Users" icon="fa-solid fa-user"/>
                </SidebarAccordionItem>
            </Accordion>
        </div>

        <div class="w-full text-color">

            <Head :title="title" />

            <JetBanner />

            <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
                <nav class="bg-white border-b border-gray-100 dark:bg-zinc-900 dark:border-gray-900">
                    <!-- Primary Navigation Menu -->
                    <div class="max-w-9xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-between h-12">
                            <!-- Hamburger for left sidebar -->
                            <div class="-mr-2 flex items-center">
                                <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition" @click="showingLeftSidebar = ! showingLeftSidebar">
                                    <svg
                                        class="h-6 w-6"
                                        stroke="currentColor"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            :class="{'hidden': showingLeftSidebar, 'inline-flex': ! showingLeftSidebar }"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h16"
                                        />
                                        <path
                                            :class="{'hidden': ! showingLeftSidebar, 'inline-flex': showingLeftSidebar }"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"
                                        />
                                    </svg>
                                </button>

                                <!-- Page Heading -->
                                <div v-if="title">
                                    <PageHeading>
                                        {{ title }}
                                    </PageHeading>
                                </div>
                            </div>


                            <div class="hidden sm:flex sm:items-center sm:ml-6">
                                <!-- Settings Dropdown -->
                                <div class="ml-3 relative">
                                    <JetDropdown align="right" width="48">
                                        <template #trigger>
                                            <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex flex link link-color">
                                                <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name">
                                            </button>

                                            <span v-else class="inline-flex rounded-md">
                                                <button type="button" class="flex link link-color">
                                                    {{ $page.props.user.name }}

                                                    <svg
                                                        class="ml-2 -mr-0.5 h-4 w-4"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20"
                                                        fill="currentColor"
                                                    >
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>

                                        <template #content>
                                            <!-- Account Management -->
                                            <DropdownHeader>Manage Account</DropdownHeader>

                                            <JetDropdownLink :href="route('profile.show')">
                                                Profile
                                            </JetDropdownLink>

                                            <JetDropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
                                                API Tokens
                                            </JetDropdownLink>

                                            <DropdownDivider />

                                            <!-- Authentication -->
                                            <form @submit.prevent="logout">
                                                <JetDropdownLink as="button">
                                                    Log Out
                                                </JetDropdownLink>
                                            </form>
                                        </template>
                                    </JetDropdown>
                                </div>
                            </div>

                            <!-- Hamburger -->
                            <div class="-mr-2 flex items-center sm:hidden">
                                <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition" @click="showingNavigationDropdown = ! showingNavigationDropdown">
                                    <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name">
                                </button>
                                <button v-else class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition" @click="showingNavigationDropdown = ! showingNavigationDropdown">
                                    {{ $page.props.user.name }}
                                    <svg
                                        class="ml-2 -mr-0.5 h-4 w-4"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Responsive Navigation Menu -->
                    <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                        <!-- Responsive Settings Options -->
                        <div class="pt-4 pb-1 border-t border-gray-200">
                            <div class="flex items-center px-4">
                                <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 mr-3">
                                    <img class="h-10 w-10 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name">
                                </div>

                                <div>
                                    <div class="font-medium text-base text-gray-800">
                                        {{ $page.props.user.name }}
                                    </div>
                                    <div class="font-medium text-sm text-gray-500">
                                        {{ $page.props.user.email }}
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 space-y-1">
                                <JetResponsiveNavLink :href="route('profile.show')" :active="route().current('profile.show')">
                                    Profile
                                </JetResponsiveNavLink>

                                <JetResponsiveNavLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')" :active="route().current('api-tokens.index')">
                                    API Tokens
                                </JetResponsiveNavLink>

                                <!-- Authentication -->
                                <form method="POST" @submit.prevent="logout">
                                    <JetResponsiveNavLink as="button">
                                        Log Out
                                    </JetResponsiveNavLink>
                                </form>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Page Content -->
                <main class="mt-10">
                    <PageContent>
                        <slot />
                    </PageContent>
                </main>

                <Flash
                    v-bind:message="$page.props.flash.message"
                    v-bind:status="$page.props.flash.status"
                    v-bind:timestamp="$page.props.flash.timestamp" />

            </div>
        </div>
    </div>
</template>
