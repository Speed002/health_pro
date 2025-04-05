<script setup>
import { ref, computed, watch } from 'vue'
import { Head, useForm, usePage } from '@inertiajs/vue3'
import Default from '@/Layouts/Default.vue'
import Account from '@/Layouts/Account.vue'

defineOptions({ layout: [Default, Account] })

const page = usePage()

const form = useForm({
    _method: 'PUT',
    email: page.props.auth.user.email,
    name: page.props.auth.user.hospitals[0].name,
})

const submit = () => {
    form.post(route('user-profile-information.update'), {
        preserveScroll: true
    })
}

</script>

<template>
    <div class="w-96">
        <h2 class="font-bold text-gray-900 font-mono">Hospital information</h2>
        <form class="mt-5 space-y-6 " v-on:submit.prevent="submit">
            <div>
                <label for="name" class="sr-only text-sm font-medium text-gray-900">Hospital name</label>
                <div class="mt-2">
                    <input type="text" id="name" class="w-full py-2 text-gray-900 border-gray-300 text-sm" v-model="form.name">
                    <div v-if="form.errors.name" class="text-sm text-red-500 mt-2">
                        {{ form.errors.name }}
                    </div>
                </div>
            </div>

            <div>
                <button type="submit" class="flex w-full justify-center bg-blue-500 px-3 py-2 text-sm font-semibold text-white disabled:opacity-50" :disabled="form.processing">
                    Update
                </button>
            </div>
        </form>
    </div>

    <Head title="Profile information" />
</template>
