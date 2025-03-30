<script setup>
import { Head, Link } from '@inertiajs/vue3'
import Default from '@/Layouts/Default.vue'
import { HomeIcon, MoonIcon, PaperAirplaneIcon } from '@heroicons/vue/24/outline';

defineOptions({ layout: Default })
</script>

<template>
    <div class="h-screen flex items-center justify-center">
        <div class="max-w-3xl mx-auto">
            <div class="border border-gray-200 rounded-md p-1 m-8 md:flex md:justify-between md:space-x-1 sm:flex sm:flex-cols">
                <!-- Left Section -->
                <div class="bg-gray-200 w-full h-full p-8 space-y-5 rounded-md">
                    <div class="flex items-center justify-start space-x-6">
                        <HomeIcon class="h-5 w-5"/>
                        <MoonIcon class="h-5 w-5"/>
                        <PaperAirplaneIcon class="h-5 w-5"/>
                    </div>
                    <div class="text-md">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur consectetur beatae fugit pariatur earum.
                    </div>
                </div>

                <!-- Right Section -->
                <div class="w-full m-6 flex flex-col items-center space-y-6">
                    <span>Health pro</span>
                    <div v-if="!$page.props.auth.user" class="flex items-center space-x-3">
                        <Link :href="route('auth.login')" class="inline-flex items-center border border-blue-600 text-sm font-medium text-gray-900 rounded-md p-2 w-fit">
                            Sign in
                        </Link>
                        <!-- <Link :href="route('auth.register')" class="inline-flex items-center border border-gray-300 text-sm font-medium text-gray-900 rounded-md p-2 w-fit" v-if="$page.props.features.registration">
                            Create an account
                        </Link> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <Head title="Home" />
</template>

