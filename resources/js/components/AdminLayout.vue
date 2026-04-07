<script setup lang="ts">
import { Form } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import AdminSidebar from '@/components/AdminSidebar.vue'

withDefaults(
    defineProps<{
        title: string
    }>(),
    {
        title: 'Admin',
    }
)
</script>

<template>
    <div class="min-h-screen bg-slate-50">
        <div class="flex min-h-screen">
            <AdminSidebar :active="title" />

            <!-- Main Content -->
            <main class="flex-1 md:ml-72 p-6 md:p-8">
                <slot />
            </main>
        </div>
    </div>
</template>
