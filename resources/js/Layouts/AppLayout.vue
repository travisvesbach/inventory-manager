<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import JetApplicationMark from '@/Jetstream/ApplicationMark.vue';
import JetBanner from '@/Jetstream/Banner.vue';
import JetDropdown from '@/Jetstream/Dropdown.vue';
import JetDropdownLink from '@/Jetstream/DropdownLink.vue';
import JetNavLink from '@/Jetstream/NavLink.vue';
import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue';
import Accordion from '@/Components/Accordion.vue';
import AccordionItem from '@/Components/AccordionItem.vue';
import SidebarLink from '@/Components/SidebarLink.vue';
import SidebarAccordionItem from '@/Components/SidebarAccordionItem.vue';
import SidebarDivider from '@/Components/SidebarDivider.vue';

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

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
</script>

<template>
    <div class="flex">
        <div class="w-[50px] hover:w-[300px] bg-gray-800 text-gray-400 p-2 transition-all duration-500 group">
            <!-- Logo -->
            <div class="flex mb-2 items-end">
                <Link :href="route('dashboard')">
                    <JetApplicationMark class="block h-8 w-8" />
                </Link>
                <span class="pl-2 opacity-0 group-hover:opacity-100 transition-all duration-500 whitespace-nowrap font-bold text-lg">Zasset</span>
            </div>
            <SidebarDivider/>

            <SidebarLink :href="route('dashboard')" text="Item 1" icon="fa-solid fa-car-side"/>

            <Accordion>
                <SidebarAccordionItem id="electronics" title="Electronics" icon="fa-solid fa-bolt">
                    <SidebarLink :href="route('dashboard')" text="All Electronics"/>
                    <Accordion>
                        <SidebarAccordionItem id="camera" title="Camera" icon="fa-solid fa-camera">
                            <SidebarLink :href="route('dashboard')" text="All Camera" icon="fa-solid fa-camera" class="active"/>
                            <SidebarLink :href="route('dashboard')" text="Bodies" icon="fa-solid fa-camera"/>
                            <SidebarLink :href="route('dashboard')" text="Filters" icon="fa-solid fa-circle-half-stroke"/>
                            <SidebarLink :href="route('dashboard')" text="Lenses" icon="fa-solid fa-camera-retro"/>
                        </SidebarAccordionItem>
                    </Accordion>
                    <SidebarLink :href="route('dashboard')" text="Computer" icon="fa-solid fa-computer"/>
                </SidebarAccordionItem>
                <SidebarAccordionItem id="firearms" title="Firearms" icon="fa-solid fa-gun">
                    <SidebarLink :href="route('dashboard')" text="All Firearms" icon="fa-solid fa-gun"/>
                    <SidebarLink :href="route('dashboard')" text="Ammo" icon="fa-solid fa-gun"/>
                    <SidebarLink :href="route('dashboard')" text="Optics" icon="fa-solid fa-crosshairs"/>
                </SidebarAccordionItem>
            </Accordion>
        </div>

        <div>

            <Head :title="title" />

            <JetBanner />

            <div class="min-h-screen bg-gray-100">
                <nav class="bg-white border-b border-gray-100">
                    <!-- Primary Navigation Menu -->
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-between h-16">
                            <div class="flex">
                                <!-- Navigation Links -->
                                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                    <JetNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                        Dashboard
                                    </JetNavLink>
                                </div>
                            </div>

                            <div class="hidden sm:flex sm:items-center sm:ml-6">
                                <div class="ml-3 relative">
                                    <!-- Teams Dropdown -->
                                    <JetDropdown v-if="$page.props.jetstream.hasTeamFeatures" align="right" width="60">
                                        <template #trigger>
                                            <span class="inline-flex rounded-md">
                                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                                    {{ $page.props.user.current_team.name }}

                                                    <svg
                                                        class="ml-2 -mr-0.5 h-4 w-4"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20"
                                                        fill="currentColor"
                                                    >
                                                        <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>

                                        <template #content>
                                            <div class="w-60">
                                                <!-- Team Management -->
                                                <template v-if="$page.props.jetstream.hasTeamFeatures">
                                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                                        Manage Team
                                                    </div>

                                                    <!-- Team Settings -->
                                                    <JetDropdownLink :href="route('teams.show', $page.props.user.current_team)">
                                                        Team Settings
                                                    </JetDropdownLink>

                                                    <JetDropdownLink v-if="$page.props.jetstream.canCreateTeams" :href="route('teams.create')">
                                                        Create New Team
                                                    </JetDropdownLink>

                                                    <div class="border-t border-gray-100" />

                                                    <!-- Team Switcher -->
                                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                                        Switch Teams
                                                    </div>

                                                    <template v-for="team in $page.props.user.all_teams" :key="team.id">
                                                        <form @submit.prevent="switchToTeam(team)">
                                                            <JetDropdownLink as="button">
                                                                <div class="flex items-center">
                                                                    <svg
                                                                        v-if="team.id == $page.props.user.current_team_id"
                                                                        class="mr-2 h-5 w-5 text-green-400"
                                                                        fill="none"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        stroke="currentColor"
                                                                        viewBox="0 0 24 24"
                                                                    ><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                                    <div>{{ team.name }}</div>
                                                                </div>
                                                            </JetDropdownLink>
                                                        </form>
                                                    </template>
                                                </template>
                                            </div>
                                        </template>
                                    </JetDropdown>
                                </div>

                                <!-- Settings Dropdown -->
                                <div class="ml-3 relative">
                                    <JetDropdown align="right" width="48">
                                        <template #trigger>
                                            <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                                <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name">
                                            </button>

                                            <span v-else class="inline-flex rounded-md">
                                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
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
                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                Manage Account
                                            </div>

                                            <JetDropdownLink :href="route('profile.show')">
                                                Profile
                                            </JetDropdownLink>

                                            <JetDropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
                                                API Tokens
                                            </JetDropdownLink>

                                            <div class="border-t border-gray-100" />

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
                                <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition" @click="showingNavigationDropdown = ! showingNavigationDropdown">
                                    <svg
                                        class="h-6 w-6"
                                        stroke="currentColor"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h16"
                                        />
                                        <path
                                            :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Responsive Navigation Menu -->
                    <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                        <div class="pt-2 pb-3 space-y-1">
                            <JetResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                Dashboard
                            </JetResponsiveNavLink>
                        </div>

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

                <!-- Page Heading -->
                <header v-if="$slots.header" class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <slot name="header" />
                    </div>
                </header>

                <!-- Page Content -->
                <main>
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>
