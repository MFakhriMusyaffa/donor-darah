<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import Footer from '@/components/dashboards/modern/Footer.vue';

defineProps<{
    jadwal: Array<{
        id: number;
        event_name: string;
        start_event: string;
        end_event?: string; // <-- Tambahan data tanggal selesai
        location: string;
        detail?: string;
    }>;
}>();

const breadcrumbs: BreadcrumbItem[] = [];

// Format Tanggal Kotak Kiri (Hanya Start Event)
const getDay = (dateString: string) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', { day: '2-digit' });
};

const getMonthYear = (dateString: string) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', {
        month: 'short',
        year: 'numeric',
    });
};

// Fungsi Pintar untuk Rentang Tanggal (Contoh: 7 Jan - 5 Apr 2026)
const formatDateRange = (startStr: string, endStr?: string) => {
    const startDate = new Date(startStr);
    const startDay = startDate.getDate();
    const startMonth = startDate.toLocaleDateString('id-ID', {
        month: 'short',
    });
    const startYear = startDate.getFullYear();

    // Jika tidak ada tanggal selesai, tampilkan 1 tanggal saja
    if (!endStr) {
        return `${startDay} ${startMonth} ${startYear}`;
    }

    const endDate = new Date(endStr);
    const endDay = endDate.getDate();
    const endMonth = endDate.toLocaleDateString('id-ID', { month: 'short' });
    const endYear = endDate.getFullYear();

    // Logika penggabungan teks
    if (startYear !== endYear) {
        return `${startDay} ${startMonth} ${startYear} - ${endDay} ${endMonth} ${endYear}`;
    } else if (startMonth !== endMonth) {
        return `${startDay} ${startMonth} - ${endDay} ${endMonth} ${startYear}`;
    } else {
        return `${startDay} - ${endDay} ${startMonth} ${startYear}`;
    }
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Jadwal Kegiatan PMI" />

        <div class="flex min-h-[calc(100vh-100px)] flex-col">
            <div class="grow">
                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12">
                        <div class="py-12">
                            <div class="mx-auto max-w-5xl sm:px-6 lg:px-8">
                                <div class="mb-8">
                                    <h1
                                        class="text-2xl font-bold text-slate-900 dark:text-white"
                                    >
                                        Jadwal Kegiatan
                                        <span class="text-red-600"
                                            >Donor Darah</span
                                        >
                                    </h1>
                                    <p
                                        class="mt-2 text-sm text-slate-500 dark:text-slate-400"
                                    >
                                        Temukan lokasi mobil unit PMI atau acara
                                        donor darah terdekat di sekitarmu.
                                    </p>
                                </div>

                                <div class="space-y-4">
                                    <div
                                        v-if="!jadwal || jadwal.length === 0"
                                        class="flex flex-col items-center justify-center rounded-2xl border border-slate-200 bg-white p-12 text-center shadow-sm dark:border-zinc-800 dark:bg-zinc-900"
                                    >
                                        <svg
                                            class="mb-3 h-12 w-12 text-slate-300 dark:text-zinc-600"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                            ></path>
                                        </svg>
                                        <h3
                                            class="mt-2 text-lg font-medium text-slate-900 dark:text-white"
                                        >
                                            Belum ada jadwal kegiatan
                                        </h3>
                                        <p
                                            class="mt-1 text-slate-500 dark:text-slate-400"
                                        >
                                            Saat ini belum ada jadwal donor
                                            darah yang dipublikasikan.
                                        </p>
                                    </div>

                                    <div
                                        v-else
                                        v-for="item in jadwal"
                                        :key="item.id"
                                        class="group flex flex-col items-start rounded-2xl border border-slate-200 bg-white p-6 transition-all duration-200 hover:border-red-200 hover:shadow-md sm:flex-row sm:items-start dark:border-zinc-800 dark:bg-zinc-900 dark:hover:border-red-900/50"
                                    >
                                        <div
                                            class="mb-4 w-full shrink-0 rounded-xl border border-red-100 bg-red-50 p-4 text-center transition-colors group-hover:bg-red-100 sm:mr-6 sm:mb-0 sm:w-28 dark:border-red-900/20 dark:bg-red-900/10 dark:group-hover:bg-red-900/20"
                                        >
                                            <span
                                                class="block text-3xl font-black text-red-600 dark:text-red-500"
                                            >
                                                {{ getDay(item.start_event) }}
                                            </span>
                                            <span
                                                class="mt-1 block text-xs font-bold tracking-wider text-red-800/70 uppercase dark:text-red-400"
                                            >
                                                {{
                                                    getMonthYear(
                                                        item.start_event,
                                                    )
                                                }}
                                            </span>
                                        </div>

                                        <div class="grow">
                                            <h2
                                                class="text-xl font-bold text-slate-900 transition-colors group-hover:text-red-600 dark:text-white dark:group-hover:text-red-400"
                                            >
                                                {{ item.event_name }}
                                            </h2>

                                            <div
                                                class="mt-3 flex flex-col gap-3 text-sm text-slate-600 sm:flex-row sm:items-center sm:gap-6 dark:text-slate-400"
                                            >
                                                <div
                                                    class="flex items-center gap-2"
                                                >
                                                    <svg
                                                        class="h-4 w-4 text-slate-400 dark:text-slate-500"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                                        ></path>
                                                    </svg>
                                                    <span class="font-medium">
                                                        {{
                                                            formatDateRange(
                                                                item.start_event,
                                                                item.end_event,
                                                            )
                                                        }}
                                                    </span>
                                                </div>

                                                <div
                                                    class="flex items-center gap-2"
                                                >
                                                    <svg
                                                        class="h-4 w-4 text-slate-400 dark:text-slate-500"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                                        ></path>
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                                        ></path>
                                                    </svg>
                                                    <span class="font-medium">{{
                                                        item.location
                                                    }}</span>
                                                </div>
                                            </div>

                                            <div
                                                v-if="item.detail"
                                                class="mt-4 border-t border-slate-100 pt-4 dark:border-zinc-800/80"
                                            >
                                                <p
                                                    class="text-sm leading-relaxed whitespace-pre-wrap text-slate-600 dark:text-slate-400"
                                                >
                                                    {{ item.detail }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full">
                <div class="py-6">
                    <Footer />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
