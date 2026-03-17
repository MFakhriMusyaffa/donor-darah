<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Berita" />

    <div class="min-h-screen bg-gray-100 p-10">
        <div class="mx-auto max-w-5xl rounded-xl bg-white p-8 shadow-md">
            <div class="mb-6 flex items-center justify-between">
                <h1 class="text-2xl font-bold text-red-600">Daftar Berita</h1>

                <a
                    href="/admin/berita/create"
                    class="rounded-lg bg-red-600 px-4 py-2 text-white hover:bg-red-700"
                >
                    + Tambah Berita
                </a>
            </div>

            <table class="w-full border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2 text-left">Judul</th>
                        <th class="border p-2 text-left">Tanggal</th>
                        <th class="border p-2 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td class="border p-2">Donor Darah Minggu</td>
                        <td class="border p-2">2026-03-10</td>
                        <td class="space-x-2 border p-2 text-center">
                            <a
                                href="/admin/berita/edit/1"
                                class="rounded bg-blue-500 px-3 py-1 text-sm text-white hover:bg-blue-600"
                            >
                                Edit
                            </a>

                            <button
                                class="rounded bg-red-500 px-3 py-1 text-sm text-white hover:bg-red-600"
                            >
                                Hapus
                            </button>
                        </td>
                    </tr>

                    <tr>
                        <td class="border p-2">Stok Darah Menipis</td>
                        <td class="border p-2">2026-03-08</td>
                        <td class="space-x-2 border p-2 text-center">
                            <a
                                href="/admin/berita/edit/1"
                                class="rounded bg-blue-500 px-3 py-1 text-sm text-white hover:bg-blue-600"
                            >
                                Edit
                            </a>

                            <button
                                class="rounded bg-red-500 px-3 py-1 text-sm text-white hover:bg-red-600"
                            >
                                Hapus
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
