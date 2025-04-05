<script setup>
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { ChevronDownIcon, ChevronUpIcon } from '@heroicons/vue/24/outline';
import { Head, router, useForm, usePage, Link } from '@inertiajs/vue3'
import Default from '@/Layouts/Default.vue'
import Account from '@/Layouts/Account.vue'

defineOptions({ layout: [Default, Account] })

const page = usePage()
const current_team = page.props.auth.user.current_team

const form = useForm({
    id:current_team.id,
    name: current_team.name,
})
const updateTeam = (id) => {
    form.patch(route('team.update', `${id}`),  {
        preserveScroll: true,
        onSuccess: () => {
            router.visit(route('team.edit'), { replace: true }); // Refreshes without full reload
        },
        onError: (errors) => {
            console.error('Failed to remove member:', errors);
        }
    })
}
const leaveTeam = () => {
    router.post(route('team.leave', `${current_team.id}`),  {
        preserveScroll: true,
        onSuccess: () => {
            router.visit(route('team.edit'), { replace: true }); // Refreshes without full reload
        },
        onError: (errors) => {
            console.error('Failed to remove member:', errors);
        }
    })
}

const removeTeamMember = (team_id, member_id) => {
    router.delete(route('remove.team.member', [`${team_id}`, `${member_id}`]), {
        preserveScroll: true,
        onSuccess: () => {
            router.visit(route('team.edit'), { replace: true }); // Refreshes without full reload
        },
        onError: (errors) => {
            console.error('Failed to remove member:', errors);
        }
    });
}

const inviteForm = useForm({
    email:''
})

const InviteToTeam = () => {
    inviteForm.post(route('team.invites.store', `${current_team.id}`), {
        preserveScroll: true,
        onSuccess: () => {
            inviteForm.reset(); // Clear the form after success
            router.visit(route('team.edit'), { replace: true, preserveScroll:true }); // Refreshes without full reload
        },
        onError: (errors) => {
            console.error("Error:", errors);
        }
    });
};

const revokeInvitation = (invite) => {
    // console.log(123)
    router.delete(route('team.invites.destroy', [`${current_team.id}`, `${invite}`]), {
        preserveScroll: true,
        onSuccess: () => {
            router.visit(route('team.edit'), { replace: true, preserveScroll:true }); // Refreshes without full reload
        },
        onError: (errors) => {
            console.error('Failed to revoke invitation:', errors);
        }
    });
};

</script>

<template>
    <div class="w-96">
        <h2 class="font-bold text-gray-900 font-mono">Team information</h2>
        <div class="space-y-6">
            <div v-if="page.props.auth.user.permissions.update_team" class="w-96">
                <!-- <h2 class="font-bold text-gray-900 font-mono">Update team information</h2> -->
                <span class="text-gray-500 tracking-tighter">Update your team's information</span>
                <form v-on:submit.prevent="updateTeam(form.id)">
                    <div>
                        <label for="name" class="sr-only text-sm font-medium text-gray-900">Hospital name</label>
                        <div class="mt-2">
                            <input type="text" name="name" class="w-full py-2 text-gray-900 border-gray-300 text-sm rounded-md" v-model="form.name">
                            <div v-if="form.errors.name" class="text-sm text-red-500 mt-2">
                                {{ form.errors.name }}
                            </div>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="mt-3 rounded-md flex justify-center bg-blue-500 px-3 py-2 text-sm font-semibold text-white disabled:opacity-50" :disabled="form.processing">
                            Update
                        </button>
                    </div>
                </form>
            </div>

            <div v-if="page.props.auth.user.permissions.leave_team">
                <form v-on:submit.prevent="leaveTeam">
                    <button class="mt-3 text-rose-500 text-sm font-semibold" type="submit">
                        Leave team
                    </button>
                </form>
            </div>

            <div v-if="page.props.auth.user.permissions.view_team_members">
                <!-- <h2 class="font-bold text-gray-900 font-mono">Team members</h2> -->
                <span v-if="current_team.members.length" class="text-gray-500 tracking-tighter">Team members</span>
                <ul class="text-sm divide-y divide-gray-100">
                    <li v-for="member in current_team.members" class="py-4 flex justify-between">
                        <!-- move these to components -->
                        <div>
                            <div class="flex items-center space-x-2">
                                <img :src="member.avatar_url" alt="" class="h-8 w-8 rounded-full">
                                <div class="text-sm text-gray-700 flex-auto">
                                    <!-- {{ member.name }} -->
                                    <span class="font-semibold">{{ member.name }} ({{ member.email }})</span>
                                    <div class="text-sm text-gray-500">
                                        <span class="text-gray-500 italic">
                                            Role: <span class="font-semibold">{{ member.roles.length ? member.roles.map(role => role.name).join(', ') : 'No Role' }}</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                        <Menu v-if="page.props.auth.user.permissions.change_and_remove_members_and_roles" as="div" class="relative mr-3">
                            <MenuButton v-slot="{ open }" class="flex items-center text-sm space-x-3">
                                <ChevronDownIcon v-if="!open" class="w-4 h-4"/>
                                <ChevronUpIcon v-if="open" class="w-4 h-4"/>
                            </MenuButton>
                            <MenuItems class="absolute right-0 z-10 mt-2 w-48 bg-white border border-b-slate-200 focus:outline-none rounded-md">
                                <MenuItem v-slot="{ active }">
                                    <button v-on:click="removeTeamMember(current_team.id, member.id)" class="block px-4 py-2 text-sm text-gray-500 w-full text-left" :class="{ 'bg-gray-100': active }">
                                        Remove team member
                                    </button>
                                </MenuItem>
                                <MenuItem v-slot="{ active }">
                                    <Link :href="route('team.members.role', [`${current_team.id}`, `${member.id}`])" class="block px-4 py-2 text-sm text-gray-500 w-full text-left" :class="{ 'bg-gray-100': active }">
                                        Change team member
                                    </Link>
                                </MenuItem>
                            </MenuItems>
                        </Menu>
                        </div>
                    </li>
                </ul>
            </div>

            <div v-if="page.props.auth.user.permissions.invite_to_team">
                <span v-if="current_team.invites.length" class="text-gray-500 tracking-tighter">Team invites</span>
                <ul class="text-sm divide-y divide-gray-100 mb-5">
                    <!-- {{ current_team.invites }} -->
                    <li v-for="invite in current_team.invites" class="py-4 flex justify-between">
                        <!-- move these to components -->
                        <div>
                            <div class="flex items-center space-x-2">
                                <img :src="invite.avatar_url" alt="" class="h-8 w-8 rounded-full">
                                <div class="text-sm text-gray-700 flex-auto">
                                    <!-- {{ member.name }} -->
                                    <span class="font-semibold">{{ invite.email }}</span>
                                    <div class="text-sm text-gray-500">
                                        <span class="text-gray-700 italic">
                                            <!-- Role: {{ member.roles.length ? member.roles.map(role => role.name).join(', ') : 'No Role' }} -->
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- v-if="page.props.auth.user.permissions.revoke_invitation" is covered by invite_to_team permission -->
                        <div>
                        <Menu as="div" class="relative mr-3">
                            <MenuButton v-slot="{ open }" class="flex items-center text-sm space-x-3">
                                <ChevronDownIcon v-if="!open" class="w-4 h-4"/>
                                <ChevronUpIcon v-if="open" class="w-4 h-4"/>
                            </MenuButton>
                            <MenuItems class="absolute right-0 z-10 mt-2 w-48 bg-white border border-b-slate-200 focus:outline-none rounded-md">
                                <MenuItem v-if="page.props.auth.user.permissions.remove_team_members" v-slot="{ active }">
                                    <button v-on:click="revokeInvitation(invite.id)" class="block px-4 py-2 text-sm text-gray-500 w-full text-left" :class="{ 'bg-gray-100': active }">
                                        Revoke invite
                                    </button>
                                </MenuItem>
                            </MenuItems>
                        </Menu>
                        </div>
                    </li>
                </ul>

                <!-- <h2 class="font-bold text-gray-900 font-mono">Team invitations</h2> -->
                <span class="text-gray-500 tracking-tighter">Invite to team</span>
                <form v-on:submit.prevent="InviteToTeam">
                    <!-- {{ inviteForm }} -->
                    <div>
                        <label for="email" class="sr-only text-sm font-medium text-gray-900">Email</label>
                        <div class="mt-2">
                            <input type="email" placeholder="Email" v-model="inviteForm.email" class="w-full py-2 text-gray-900 border-gray-300 text-sm rounded-md">
                        </div>
                        <div v-if="inviteForm.errors.email" class="text-sm text-red-500 mt-2">
                                {{ inviteForm.errors.email }}
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="mt-3 flex rounded-md justify-center bg-blue-500 px-3 py-2 text-sm font-semibold text-white disabled:opacity-50" :disabled="form.processing">
                            Invite
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <Head title="Profile information" />
</template>
