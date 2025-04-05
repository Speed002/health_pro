<script setup>
import { Link, router } from '@inertiajs/vue3'
import { Disclosure, DisclosurePanel, DisclosureButton, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { ChevronDownIcon, ChevronUpIcon } from '@heroicons/vue/24/outline';
import { Bars3Icon, XMarkIcon } from '@heroicons/vue/24/outline'
import { ref } from 'vue';
const isOpen = ref(false)

const changeTeam = (id) => {
    router.patch(route('team.setCurrent', `${id}`), {}, {
        onSuccess: () => {
            router.visit(route('team.edit'), { replace: true, preserveScroll:true }); // Refreshes without full reload
        },
        onError: (errors) => {
            console.error('Failed to revoke invitation:', errors);
        }
    });
};

const toggleDropdown = () => {
    isOpen.value = !isOpen.value
}
const logout = () => {
    router.post(route('logout'))
}
</script>

<template>
    <Disclosure as="nav" class="border-b border-b-slate-200 shadow-sm" v-slot="{ open }" :class="{ 'hidden': $page.props.ziggy.route_name === 'home' || $page.props.ziggy.route_name === 'auth.login' || $page.props.ziggy.route_name === 'auth.register' }">
        <div class="mx-auto max-w-6xl">
            <div class="flex h-16 justify-between relative md:px-0 sm:px-8 px-8">
                <div class="flex grow">
                    <div class="flex items-center sm:mr-6">
                        <Link href="#" class="font-bold font-mono text-lg">
                            {{ $page.props.config['app.name'] }}
                        </Link>
                    </div>
                </div>
                <div class="absolute inset-y-0 right-0 flex items-center space-x-3">
                    <Menu as="div" class="relative mr-3" v-if="$page.props.auth.user">
                        <MenuButton v-slot="{ open }" class="flex items-center text-sm space-x-3">
                            <span class="font-medium text-gray-500">
                                {{ $page.props.auth.user.current_team.name }}
                            </span>
                            <ChevronDownIcon v-if="!open" class="w-4 h-4"/>
                            <ChevronUpIcon v-if="open" class="w-4 h-4"/>
                        </MenuButton>
                        <MenuItems class="absolute right-0 z-10 mt-2 w-48 bg-white border border-b-slate-200 focus:outline-none rounded-md">
                            <MenuItem v-slot="{ active }">
                                <Link :href="route('team.create')" class="block px-4 py-2 text-sm text-gray-500 w-full text-left font-semibold" :class="{ 'bg-gray-100': active }">
                                    Create team
                                </Link>
                            </MenuItem>
                            <MenuItem v-slot="{ active }">
                                <Link :href="route('team.edit')" class="block px-4 py-2 text-sm text-gray-500 w-full text-left font-semibold" :class="{ 'bg-gray-100': active }">
                                    Team settings
                                </Link>
                            </MenuItem>
                            <MenuItem v-for="team in $page.props.auth.user.teams" v-slot="{ active }">
                                <button v-on:click="changeTeam(team.id)" class="block px-4 py-2 text-sm text-gray-500 w-full text-left" :class="{ 'bg-gray-100': active }">
                                        {{ team.name }}
                                </button>
                            </MenuItem>
                        </MenuItems>
                    </Menu>
                    <Menu as="div" class="relative mr-3" v-if="$page.props.auth.user">
                        <MenuButton class="flex items-center text-sm space-x-3">
                            <span class="font-medium text-gray-500">
                                {{ $page.props.auth.user.name }}
                            </span>
                            <img :src="$page.props.auth.user.avatar_url" class="h-8 w-8 rounded-full">
                        </MenuButton>
                        <MenuItems class="absolute right-0 z-10 mt-2 w-48 bg-white border border-b-slate-200 focus:outline-none rounded-md">
                            <MenuItem v-slot="{ active }">
                                <Link :href="route('account.index')" class="block px-4 py-2 text-sm text-gray-500 w-full text-left" :class="{ 'bg-gray-100': active }">
                                    Account settings
                                </Link>
                            </MenuItem>
                            <MenuItem v-slot="{ active }">
                                <Link :href="route('account.security.index')" class="block px-4 py-2 text-sm text-gray-500 w-full text-left" :class="{ 'bg-gray-100': active }">
                                    Security
                                </Link>
                            </MenuItem>
                            <MenuItem v-slot="{ active }">
                                <button v-on:click="logout" class="block px-4 py-2 text-sm text-gray-500 w-full text-left" :class="{ 'bg-gray-100': active }">
                                    Sign out
                                </button>
                            </MenuItem>
                        </MenuItems>
                    </Menu>
                    <DisclosureButton class="sm:block md:hidden relative p-2 text-gray-900 hover:bg-gray-100">
                        <Bars3Icon v-if="!open" class="block h-6 w-6" />
                        <XMarkIcon v-if="open" class="block h-6 w-6" />
                    </DisclosureButton>
                </div>
            </div>
        </div>

        <DisclosurePanel>
            <div class="spacey-1 pb-3">
                <nav class="border-r border-r-slate-200 h-full md:px-0 sm:px-8 px-8 md:hidden">
                    <ul class="space-y-4">
                        <li>
                            <Link :href="route('dashboard')" class="text-gray-900 flex text-sm" :class="{ 'text-sky-700 font-semibold': $page.props.ziggy.route_name === 'dashboard' }">
                                Dashboard
                            </Link>
                        </li>
                        <li>
                            <Disclosure v-slot="{ open }">
                                <DisclosureButton class="text-gray-900 flex text-sm font-semibold">
                                    <div class="flex items-center justify-start w-full">
                                        <span class="pr-3">Dropdown link</span>
                                        <ChevronDownIcon v-if="!open" class="w-4 h-4"/>
                                        <ChevronUpIcon v-if="open" class="w-4 h-4"/>
                                    </div>
                                </DisclosureButton>
                                <DisclosurePanel class="text-gray-500 flex flex-col pt-1 space-y-1">
                                    <Link :href="route('dashboard')" class="text-sm font-normal">
                                        Dropdown link
                                    </Link>
                                    <Link :href="route('dashboard')" class="text-sm font-normal">
                                        Dropdown link
                                    </Link>
                                </DisclosurePanel>
                            </Disclosure>
                        </li>
                        <li>
                            <Disclosure v-slot="{ open }">
                                <DisclosureButton class="text-gray-900 flex text-sm font-semibold">
                                    <div class="flex items-center justify-start w-full">
                                        <span class="pr-3">Dropdown link</span>
                                        <ChevronDownIcon v-if="!open" class="w-4 h-4"/>
                                        <ChevronUpIcon v-if="open" class="w-4 h-4"/>
                                    </div>
                                </DisclosureButton>
                                <DisclosurePanel class="text-gray-500 flex flex-col pt-1 space-y-1">
                                    <Link :href="route('dashboard')" class="text-sm font-normal">
                                        Dropdown1
                                    </Link>
                                    <Link :href="route('dashboard')" class="text-sm font-normal">
                                        Dropdown2
                                    </Link>
                                </DisclosurePanel>
                            </Disclosure>
                        </li>
                        <!-- last -->
                        <li>
                            <Link :href="route('account.index')" class="text-gray-900 flex text-sm" :class="{ 'text-sky-700 font-semibold': $page.props.ziggy.route_name === 'account.index' }">
                                Profile information
                            </Link>
                        </li>
                        <li v-if="$page.props.features.security">
                            <Link :href="route('account.security.index')" class="text-gray-900 flex text-sm" :class="{ 'text-sky-700 font-semibold': $page.props.ziggy.route_name === 'account.security.index' }">
                                Security
                            </Link>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="spacey-1 pb-3" v-if="!$page.props.auth.user">
                <Link :href="route('auth.register')" class="block py-2 px-8 font-medium text-gray-900" v-if="$page.props.features.registration">
                    Create an account
                </Link>
                <Link :href="route('auth.login')" class="block py-2 px-8 font-medium text-gray-900">
                    Sign in
                </Link>
            </div>
        </DisclosurePanel>
    </Disclosure>
</template>
