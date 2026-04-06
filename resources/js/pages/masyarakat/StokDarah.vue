<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import Footer from '@/components/dashboards/modern/Footer.vue';

const breadcrumbs: BreadcrumbItem[] = [];
defineProps<{
    stokDarah: Array<{
        id: number;
        golongan_darah: string;
        rhesus: string;
        jumlah_kantong: number;
    }>;
}>();
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Stok Darah Masyarakat" />

        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12">
                <div class="py-12">
                    <div class="mx-auto max-w-5xl sm:px-6 lg:px-8">
                        <div class="mb-8">
                            <h1
                                class="text-2xl font-bold text-slate-900 dark:text-white"
                            >
                                Daftar Ketersediaan
                                <span class="text-red-600">Stok Darah</span>
                            </h1>
                            <p
                                class="mt-2 text-sm text-slate-500 dark:text-slate-400"
                            >
                                Pantau jumlah kantong darah yang tersedia secara
                                real-time di PMI.
                            </p>
                        </div>

                        <div
                            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900"
                        >
                            <div class="overflow-x-auto">
                                <table
                                    class="w-full text-left text-sm text-slate-600 dark:text-slate-300"
                                >
                                    <thead
                                        class="border-b border-red-100 bg-red-50 text-red-800 dark:border-red-900/30 dark:bg-red-900/20 dark:text-red-400"
                                    >
                                        <tr>
                                            <th
                                                scope="col"
                                                class="px-6 py-4 font-semibold tracking-wider uppercase"
                                            >
                                                Golongan Darah
                                            </th>
                                            <th
                                                scope="col"
                                                class="px-6 py-4 text-center font-semibold tracking-wider uppercase"
                                            >
                                                Rhesus
                                            </th>
                                            <th
                                                scope="col"
                                                class="px-6 py-4 text-right font-semibold tracking-wider uppercase"
                                            >
                                                Jumlah Kantong
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody
                                        class="divide-y divide-slate-100 dark:divide-zinc-800"
                                    >
                                        <tr
                                            v-if="
                                                !stokDarah ||
                                                stokDarah.length === 0
                                            "
                                        >
                                            <td
                                                colspan="3"
                                                class="px-6 py-12 text-center text-slate-500 dark:text-slate-400"
                                            >
                                                <div
                                                    class="flex flex-col items-center justify-center"
                                                >
                                                    <svg
                                                        class="mb-3 h-10 w-10 text-slate-300"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"
                                                        ></path>
                                                    </svg>
                                                    Belum ada data stok darah
                                                    yang diperbarui.
                                                </div>
                                            </td>
                                        </tr>

                                        <tr
                                            v-else
                                            v-for="item in stokDarah"
                                            :key="item.id"
                                            class="transition-colors hover:bg-slate-50 dark:hover:bg-zinc-800/50"
                                        >
                                            <td class="px-6 py-4">
                                                <div
                                                    class="flex items-center gap-4"
                                                >
                                                    <div
                                                        class="flex h-12 w-12 items-center justify-center rounded-full bg-red-100 text-xl font-black text-red-600 shadow-sm dark:bg-red-900/30 dark:text-red-500"
                                                    >
                                                        {{
                                                            item.golongan_darah
                                                        }}
                                                    </div>
                                                    <span
                                                        class="text-base font-semibold text-slate-900 dark:text-white"
                                                        >Golongan
                                                        {{
                                                            item.golongan_darah
                                                        }}</span
                                                    >
                                                </div>
                                            </td>

                                            <td class="px-6 py-4 text-center">
                                                <span
                                                    class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold"
                                                    :class="
                                                        item.rhesus === '+'
                                                            ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400'
                                                            : 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400'
                                                    "
                                                >
                                                    {{
                                                        item.rhesus === '+'
                                                            ? 'Positif (+)'
                                                            : 'Negatif (-)'
                                                    }}
                                                </span>
                                            </td>

                                            <td class="px-6 py-4 text-right">
                                                <span
                                                    class="text-2xl font-black text-slate-900 dark:text-white"
                                                    >{{
                                                        item.jumlah_kantong
                                                    }}</span
                                                >
                                                <span
                                                    class="ml-1 font-medium text-slate-500 dark:text-slate-400"
                                                    >kantong</span
                                                >
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-12">
                <Footer />
            </div>
        </div>
    </AppLayout>
</template>
