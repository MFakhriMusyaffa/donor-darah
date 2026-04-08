<script setup lang="ts">
import { Form, usePage } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import AdminSidebar from '@/components/AdminSidebar.vue'
import Toast from '@/components/Toast.vue'
import { computed } from 'vue'

withDefaults(
    defineProps<{
        title: string
    }>(),
    {
        title: 'Admin',
    }
)

const page = usePage()

const flashSuccess = computed(() => (page.props.flash as Record<string, any>)?.success)
const flashError = computed(() => (page.props.flash as Record<string, any>)?.error)
</script>

<template>
    <div class="min-h-screen bg-slate-50">
        <!-- Notification Toast Container -->
        <div class="fixed top-4 right-4 z-50 max-w-md space-y-3">
            <Toast v-if="flashSuccess" type="success" :message="flashSuccess" />
            <Toast v-if="flashError" type="error" :message="flashError" />
        </div>

        <div class="flex min-h-screen">
            <AdminSidebar :active="title" />

            <!-- Main Content -->
            <main class="flex-1 md:ml-72 p-6 md:p-8">
                <slot />
            </main>
        </div>
    </div>
</template>
