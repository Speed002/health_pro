<script setup>
import { ref, computed, watch } from 'vue'
import { Head, useForm, usePage } from '@inertiajs/vue3'
import Default from '@/Layouts/Default.vue'
import Account from '@/Layouts/Account.vue'

defineOptions({ layout: [Default, Account] })

const form = useForm({
    name: '',
})

const storeTeam = () => {
    form.post(route('team.store'), {
        onSuccess: () => {
            form.reset()
        }
    })
}
</script>

<template>
    <div class="w-96">
        <h2 class="font-bold text-gray-900 font-mono">Create new team</h2>
        <span class="text-gray-500 tracking-tighter">Create new team under this user</span>
        <form v-on:submit.prevent="storeTeam">
            <div class="space-x-6">
                <div>
                    <label for="name" class="sr-only text-sm font-medium text-gray-900">Hospital name</label>
                    <div class="mt-2">
                        <input type="text" name="name" class="w-full py-2 text-gray-900 border-gray-300 text-sm rounded-md" v-model="form.name" placeholder="Team name">
                        <div class="text-sm text-red-500 mt-2">
                            {{ form.errors.name }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3 space-x-6">
                <div>
                    <button type="submit" class="flex justify-center bg-blue-500 px-3 py-2 text-sm font-semibold text-white disabled:opacity-50 rounded-md">
                        Create
                    </button>
                </div>
            </div>

        </form>
    </div>

    <Head title="Profile information" />
</template>
