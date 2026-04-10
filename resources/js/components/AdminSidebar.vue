<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { clearRememberedEmail } from '@/lib/rememberMe';

withDefaults(
    defineProps<{
        active?: string;
    }>(),
    {
        active: 'Dashboard',
    },
);

const handleLogout = () => {
    clearRememberedEmail();
    router.post('/logout');
};
</script>

<template>
    <aside
        class="fixed hidden h-screen w-72 flex-col overflow-y-auto border-r border-slate-200 bg-white shadow-sm md:flex"
    >
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

        <nav class="flex-1 space-y-1 px-4 py-6 text-sm text-slate-700">
            <Link
                href="/admin/dashboard"
                class="block rounded-2xl px-4 py-3 hover:bg-slate-100"
                :class="
                    active === 'Dashboard'
                        ? 'bg-slate-100 font-medium text-slate-900'
                        : ''
                "
            >
                🏠 Dashboard
            </Link>
            <Link
                href="/admin/users"
                class="block rounded-2xl px-4 py-3 hover:bg-slate-100"
                :class="
                    active === 'User Admin'
                        ? 'bg-slate-100 font-medium text-slate-900'
                        : ''
                "
            >
                👥 User
            </Link>
            <Link
                href="/admin/stok-darah"
                class="block rounded-2xl px-4 py-3 hover:bg-slate-100"
                :class="
                    active === 'Stok Darah'
                        ? 'bg-slate-100 font-medium text-slate-900'
                        : ''
                "
            >
                🩸 Stok Darah
            </Link>
            <Link
                href="/admin/jadwal"
                class="block rounded-2xl px-4 py-3 hover:bg-slate-100"
                :class="
                    active === 'Jadwal Kegiatan'
                        ? 'bg-slate-100 font-medium text-slate-900'
                        : ''
                "
            >
                📅 Jadwal Kegiatan
            </Link>
            <Link
                href="/admin/berita"
                class="block rounded-2xl px-4 py-3 hover:bg-slate-100"
                :class="
                    active === 'Berita'
                        ? 'bg-slate-100 font-medium text-slate-900'
                        : ''
                "
            >
                📰 Berita
            </Link>
        </nav>

        <div class="px-4 pb-6">
            <button
                type="button"
                @click="handleLogout"
                class="w-full rounded-lg bg-red-600 px-4 py-3 text-white hover:bg-red-700"
            >
                Logout
            </button>
        </div>
    </aside>
</template>
