<script setup>
import Modal from '@/Components/Modal.vue'
import { useForm, Head } from '@inertiajs/vue3'

const props = defineProps({
    team:Object,
    user:Object,
    roles:Object
})

const form = useForm({
    role: props.user.roles[0].name,
})

const ChangeRole = () => {
    form.patch(route('team.members.role.update', [`${props.team.id}`, `${props.user.id}`]), {}, {
        onSuccess: () => {
            router.visit(route('team.edit'), { replace: true, preserveScroll:true }); // Refreshes without full reload
        },
        onError: (errors) => {
            console.error('Failed to revoke invitation:', errors);
        }
    })
}
</script>

<template>
    <Modal class="bg-white max-w-md p-12 rounded-md">
        <h5 class="text-gray-900 font-semibold tracking-tight">Change role for {{user.name}} ({{user.email}})</h5>
        <form v-on:submit.prevent="ChangeRole">
            <div class="mt-2">
                <label for="name" class="sr-only">Name</label>
                <select v-if="roles.length"
                        class="px-4 py-1 rounded-md w-full border-slate-300"
                        name="role"
                        v-model="form.role">
                    <option v-for="role in roles" :key="role.id" :value="role.name">
                        {{ role.name }}
                    </option>
                </select>
            </div>
            <div>
                <button type="submit" class="mt-3 flex rounded-md justify-center bg-blue-500 px-3 py-2 text-sm font-semibold text-white disabled:opacity-50">Change role</button>
            </div>
        </form>
    </Modal>

    <Head title="Change user role" />
</template>
