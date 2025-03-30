<script setup>
import { Head } from '@inertiajs/vue3'
import Default from '@/Layouts/Default.vue'
import Account from '@/Layouts/Account.vue'

defineOptions({ layout: [Default, Account] })
</script>

<template>
    <div class="max-w-7xl mx-auto">
        Dashboard
    </div>
    <Head title="Dashboard" />
</template>
