<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { clearRememberedEmail } from '@/lib/rememberMe';

withDefaults(
    defineProps<{
        active?: string;
    }>(),
    {
        active: 'Dashboard',
    }
);

const handleLogout = () => {
    clearRememberedEmail();
    router.post('/logout');
};
</script>

<template>
    <aside class="hidden md:flex w-72 flex-col bg-white border-r border-slate-200 shadow-sm fixed h-screen overflow-y-auto">
        <div class="h-16 flex items-center px-6 border-b border-slate-100">
            <div class="flex items-center gap-3 text-rose-600 font-bold text-xl tracking-tight">
                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                <span>BloodCare Admin</span>
            </div>
        </div>

        <nav class="px-4 py-6 space-y-1 text-sm text-slate-700 flex-1">
            <Link href="/admin/dashboard" class="block rounded-2xl px-4 py-3 hover:bg-slate-100" :class="active === 'Dashboard' ? 'font-medium text-slate-900 bg-slate-100' : ''">
                🏠 Dashboard
            </Link>
            <Link href="/admin/users" class="block rounded-2xl px-4 py-3 hover:bg-slate-100" :class="active === 'User Admin' ? 'font-medium text-slate-900 bg-slate-100' : ''">
                👥 User
            </Link>
            <Link href="/admin/stok-darah" class="block rounded-2xl px-4 py-3 hover:bg-slate-100" :class="active === 'Stok Darah' ? 'font-medium text-slate-900 bg-slate-100' : ''">
                🩸 Stok Darah
            </Link>
            <Link href="/admin/jadwal" class="block rounded-2xl px-4 py-3 hover:bg-slate-100" :class="active === 'Jadwal Kegiatan' ? 'font-medium text-slate-900 bg-slate-100' : ''">
                📅 Jadwal Kegiatan
            </Link>
            <Link href="/admin/berita" class="block rounded-2xl px-4 py-3 hover:bg-slate-100" :class="active === 'Berita' ? 'font-medium text-slate-900 bg-slate-100' : ''">
                📰 Berita
            </Link>
            <Link href="/admin/profile" class="block rounded-2xl px-4 py-3 hover:bg-slate-100" :class="active === 'Profile Admin' ? 'font-medium text-slate-900 bg-slate-100' : ''">
                👤 Profile Admin
            </Link>
        </nav>

        <div class="px-4 pb-6">
            <button 
                type="button"
                @click="handleLogout"
                class="w-full rounded-lg bg-red-600 px-4 py-3 text-white hover:bg-red-700">
                Logout
            </button>
        </div>
    </aside>
</template>
