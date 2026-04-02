<script setup lang="ts">
import { Head, Link, Form } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'

type AdminDashboardProps = {
    counts: {
        users: number
        stokDarah: number
        jadwal: number
        berita: number
    }
    users: Array<{ id: number; name: string; email: string; role: string }>
    stokDarah: Array<{ id: number; golongan_darah: string; rhesus: string; jumlah_kantong: number }>
    jadwal: Array<{ id: number; event_name: string; start_event: string; location: string }>
    berita: Array<{ id: number; title: string; publish_date: string }>
}

const props = defineProps<AdminDashboardProps>()
</script>

<template>
    <Head title="Admin Dashboard" />

    <div class="min-h-screen bg-slate-50">
        <div class="flex min-h-screen">
            <aside class="hidden md:flex w-72 flex-col bg-white border-r border-slate-200 shadow-sm">
                <div class="h-16 flex items-center px-6 border-b border-slate-100">
                    <div class="flex items-center gap-3 text-rose-600 font-bold text-xl tracking-tight">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        <span>BloodCare Admin</span>
                    </div>
                </div>

                <nav class="px-4 py-6 space-y-1 text-sm text-slate-700">
                    <Link href="/admin/dashboard" class="block rounded-2xl px-4 py-3 font-medium text-slate-900 bg-slate-100">
                        🏠 Dashboard
                    </Link>
                    <Link href="/admin/users" class="block rounded-2xl px-4 py-3 hover:bg-slate-100">
                        👥 User
                    </Link>
                    <Link href="/admin/stok-darah" class="block rounded-2xl px-4 py-3 hover:bg-slate-100">
                        🩸 Stok Darah
                    </Link>
                    <Link href="/admin/jadwal" class="block rounded-2xl px-4 py-3 hover:bg-slate-100">
                        📅 Jadwal Kegiatan
                    </Link>
                    <Link href="/admin/berita" class="block rounded-2xl px-4 py-3 hover:bg-slate-100">
                        📰 Berita
                    </Link>
                    <Link href="/settings/profile" class="block rounded-2xl px-4 py-3 hover:bg-slate-100">
                        👤 Profile Admin
                    </Link>
                </nav>

                <div class="mt-auto px-4 pb-6">
                    <Form method="POST" action="/logout">
                        <Button type="submit" class="w-full bg-red-600 hover:bg-red-700">
                            Logout
                        </Button>
                    </Form>
                </div>
            </aside>

            <main class="flex-1 p-6 md:p-8">
                <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-slate-900">Selamat datang, Admin</h1>
                        <p class="mt-2 text-slate-600">Ringkasan data stok darah, jadwal, user, dan berita ditampilkan langsung di dashboard.</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <Link href="/admin/berita" class="inline-flex items-center rounded-2xl bg-rose-600 px-4 py-2 text-sm font-semibold text-white hover:bg-rose-700">
                            Kelola Berita
                        </Link>
                        <Link href="/admin/stok-darah" class="inline-flex items-center rounded-2xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">
                            Kelola Stok Darah
                        </Link>
                    </div>
                </div>

                <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4 mb-8">
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="text-sm font-semibold uppercase tracking-wide text-slate-500">Total User</div>
                        <div class="mt-4 text-4xl font-bold text-slate-900">{{ props.counts.users }}</div>
                        <p class="mt-2 text-sm text-slate-500">Total akun di sistem.</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="text-sm font-semibold uppercase tracking-wide text-slate-500">Stok Darah</div>
                        <div class="mt-4 text-4xl font-bold text-slate-900">{{ props.counts.stokDarah }}</div>
                        <p class="mt-2 text-sm text-slate-500">Jumlah item stok darah.</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="text-sm font-semibold uppercase tracking-wide text-slate-500">Jadwal</div>
                        <div class="mt-4 text-4xl font-bold text-slate-900">{{ props.counts.jadwal }}</div>
                        <p class="mt-2 text-sm text-slate-500">Jumlah jadwal kegiatan.</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="text-sm font-semibold uppercase tracking-wide text-slate-500">Berita</div>
                        <div class="mt-4 text-4xl font-bold text-slate-900">{{ props.counts.berita }}</div>
                        <p class="mt-2 text-sm text-slate-500">Jumlah artikel berita.</p>
                    </div>
                </div>

                <div class="grid gap-6 xl:grid-cols-2">
                    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="mb-4 flex items-center justify-between">
                            <div>
                                <h2 class="text-xl font-semibold text-slate-900">User Terbaru</h2>
                                <p class="text-sm text-slate-500">5 user terbaru di sistem.</p>
                            </div>
                            <Link href="#" class="text-sm text-rose-600 hover:text-rose-700">Lihat semua</Link>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-left text-sm text-slate-600">
                                <thead class="border-b border-slate-200 text-slate-900">
                                    <tr>
                                        <th class="py-3 pr-4">Nama</th>
                                        <th class="py-3 pr-4">Email</th>
                                        <th class="py-3 pr-4">Role</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="user in props.users" :key="user.id" class="border-b border-slate-100 hover:bg-slate-50">
                                        <td class="py-3 pr-4">{{ user.name }}</td>
                                        <td class="py-3 pr-4">{{ user.email }}</td>
                                        <td class="py-3 pr-4">{{ user.role }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="mb-4 flex items-center justify-between">
                            <div>
                                <h2 class="text-xl font-semibold text-slate-900">Berita Terbaru</h2>
                                <p class="text-sm text-slate-500">5 berita terbaru.</p>
                            </div>
                            <Link href="/admin/berita" class="text-sm text-rose-600 hover:text-rose-700">Lihat semua</Link>
                        </div>
                        <ul class="space-y-3 text-slate-700">
                            <li v-for="item in props.berita" :key="item.id" class="rounded-2xl border border-slate-200 p-4 hover:bg-slate-50">
                                <div class="font-semibold">{{ item.title }}</div>
                                <div class="text-sm text-slate-500">{{ item.publish_date || 'Tanggal belum tersedia' }}</div>
                            </li>
                        </ul>
                    </section>
                </div>

                <div class="mt-6 grid gap-6 xl:grid-cols-2">
                    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="mb-4 flex items-center justify-between">
                            <div>
                                <h2 class="text-xl font-semibold text-slate-900">Stok Darah</h2>
                                <p class="text-sm text-slate-500">5 stok darah terakhir.</p>
                            </div>
                            <Link href="/admin/stok-darah" class="text-sm text-slate-600 hover:text-slate-800">Lihat semua</Link>
                        </div>
                        <div class="space-y-3">
                            <div v-for="item in props.stokDarah" :key="item.id" class="rounded-2xl border border-slate-200 p-4 hover:bg-slate-50">
                                <div class="font-semibold">{{ item.golongan_darah }} {{ item.rhesus }}</div>
                                <div class="text-sm text-slate-500">Jumlah kantong: {{ item.jumlah_kantong }}</div>
                            </div>
                        </div>
                    </section>

                    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="mb-4 flex items-center justify-between">
                            <div>
                                <h2 class="text-xl font-semibold text-slate-900">Jadwal Terdekat</h2>
                                <p class="text-sm text-slate-500">5 jadwal kegiatan terbaru.</p>
                            </div>
                            <Link href="/admin/jadwal" class="text-sm text-slate-600 hover:text-slate-800">Lihat semua</Link>
                        </div>
                        <div class="space-y-3">
                            <div v-for="item in props.jadwal" :key="item.id" class="rounded-2xl border border-slate-200 p-4 hover:bg-slate-50">
                                <div class="font-semibold">{{ item.event_name }}</div>
                                <div class="text-sm text-slate-500">{{ item.start_event }} · {{ item.location }}</div>
                            </div>
                        </div>
                    </section>
                </div>
            </main>
        </div>
    </div>
</template>

