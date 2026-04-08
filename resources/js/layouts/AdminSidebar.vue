<script setup lang="ts">
import { Link, Form } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { clearRememberedEmail } from '@/lib/rememberMe';

const handleLogout = () => {
    clearRememberedEmail();
};
</script>

<template>
    <aside
        class="hidden w-72 flex-col border-r border-slate-200 bg-white shadow-sm md:flex"
    >
        <!-- Header -->
        <div class="flex h-16 items-center border-b border-slate-100 px-6">
            <div
                class="flex items-center gap-3 text-xl font-bold tracking-tight text-rose-600"
            >
                <svg class="h-7 w-7" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"
                    />
                </svg>
                <span>BloodCare Admin</span>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="space-y-1 px-4 py-6 text-sm text-slate-700">
            <Link
                href="/admin/dashboard"
                class="block rounded-2xl bg-slate-100 px-4 py-3 font-medium text-slate-900"
            >
                🏠 Dashboard
            </Link>
            <Link
                href="/admin/users"
                class="block rounded-2xl px-4 py-3 hover:bg-slate-100"
            >
                👥 User
            </Link>
            <Link
                href="/admin/stok-darah"
                class="block rounded-2xl px-4 py-3 hover:bg-slate-100"
            >
                🩸 Stok Darah
            </Link>
            <Link
                href="/admin/jadwal"
                class="block rounded-2xl px-4 py-3 hover:bg-slate-100"
            >
                📅 Jadwal Kegiatan
            </Link>
            <Link
                href="/admin/berita"
                class="block rounded-2xl px-4 py-3 hover:bg-slate-100"
            >
                📰 Berita
            </Link>
            <Link
                href="/settings/profile"
                class="block rounded-2xl px-4 py-3 hover:bg-slate-100"
            >
                👤 Profile Admin
            </Link>
        </nav>

        <!-- Logout Button -->
        <div class="mt-auto px-4 pb-6">
            <Form method="POST" action="/logout" @submit="handleLogout">
                <Button
                    type="submit"
                    class="w-full bg-red-600 hover:bg-red-700"
                >
                    Logout
                </Button>
            </Form>
        </div>
    </aside>
</template>
