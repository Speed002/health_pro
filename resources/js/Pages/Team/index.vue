<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3'
import Default from '@/Layouts/Default.vue'
import Account from '@/Layouts/Account.vue'

defineOptions({ layout: [Default, Account] })
</script>

<template>
    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
            <div v-if="hospitals" class="relative overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                <table class="min-w-full table-fixed divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="min-w-[12rem] pl-4 py-3.5 px-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                Name
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                Admin
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                Email
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                Contact
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                Address
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                Package
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                Status
                            </th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                <span class="sr-only">Delete</span>
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                <Link :href="route('hospital.create')" class="text-indigo-600">
                                    Create
                                </Link>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <Head title="Dashboard" />
</template>

<style scoped>
.bordered-table th, .bordered-table td {
    padding: 8px 16px;
    border: 1px solid #cccccc; /* Border color for each cell */
    text-align: left;
    font-size: 14px;
}
</style>
