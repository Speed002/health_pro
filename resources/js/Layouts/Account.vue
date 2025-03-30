<script setup>
import { Link } from '@inertiajs/vue3'
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import { ChevronDownIcon, ChevronUpIcon } from '@heroicons/vue/24/outline'
</script>

<template>
    <div>
        <div class="mx-auto max-w-6xl sm:grid grid-cols-5 space-y-8 mt-8 sm:space-y-0">
            <div class="col-span-1">
                <nav class="border-r border-r-slate-200 h-full md:px-0 sm:px-8 px-8 md:block hidden">
                    <ul class="space-y-4">
                        <li>
                            <Link :href="route('dashboard')" class="text-gray-900 flex text-sm" :class="{ 'text-blue-600 font-semibold': $page.props.ziggy.route_name === 'dashboard' }">
                                Dashboard
                            </Link>
                        </li>

                        <!-- First Dropdown -->
                        <li>
                            <Disclosure v-slot="{ open }">
                                <DisclosureButton class="text-gray-900 flex text-sm font-semibold w-full">
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

                        <!-- Second Dropdown -->
                        <li>
                            <Disclosure v-slot="{ open }">
                                <DisclosureButton class="text-gray-900 flex text-sm font-semibold w-full">
                                    <div class="flex items-center justify-start w-full">
                                        <span class="pr-3">Another link</span>
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

                        <!-- Last Links -->
                        <li>
                            <Link :href="route('account.index')" class="text-gray-900 flex text-sm" :class="{ 'text-blue-600 font-semibold': $page.props.ziggy.route_name === 'account.index' }">
                                Profile information
                            </Link>
                        </li>
                        <li v-if="$page.props.features.security">
                            <Link :href="route('account.security.index')" class="text-gray-900 flex text-sm" :class="{ 'text-blue-600 font-semibold': $page.props.ziggy.route_name === 'account.security.index' }">
                                Security
                            </Link>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="col-span-3 p-3 pt-5">
                <slot />
            </div>
        </div>
    </div>
</template>
