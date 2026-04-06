<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'; // Saya tambahkan import Link di sini
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import Footer from '@/components/dashboards/modern/Footer.vue';

defineProps<{
    berita: Array<{
        id: number;
        title: string;
        publish_date: string;
        thumbnail?: string | null;
        content?: string;
    }>;
}>();

const formatDate = (dateString: string) => {
    const options: Intl.DateTimeFormatOptions = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    };
    return new Date(dateString).toLocaleDateString('id-ID', options);
};

const breadcrumbs: BreadcrumbItem[] = [];
const getImageUrl = (path?: string | null) => {
    if (!path) return '/images/default-thumbnail.jpg';
    if (path.startsWith('http')) return path;
    return `/storage/${path}`;
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Berita & Informasi PMI" />

        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12">
                <div class="py-12">
                    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                        <div class="mb-10 text-center sm:text-left">
                            <h1
                                class="text-3xl font-extrabold text-slate-900 dark:text-white"
                            >
                                Berita &
                                <span class="text-red-600">Informasi PMI</span>
                            </h1>
                            <p
                                class="mt-2 max-w-2xl text-base text-slate-500 dark:text-slate-400"
                            >
                                Ikuti perkembangan terbaru, artikel kesehatan,
                                dan liputan kegiatan seputar Palang Merah
                                Indonesia.
                            </p>
                        </div>

                        <div>
                            <div
                                v-if="!berita || berita.length === 0"
                                class="flex flex-col items-center justify-center rounded-2xl border border-slate-200 bg-white p-16 text-center shadow-sm dark:border-zinc-800 dark:bg-zinc-900"
                            >
                                <svg
                                    class="mb-4 h-16 w-16 text-slate-300 dark:text-zinc-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"
                                    ></path>
                                </svg>
                                <h3
                                    class="text-xl font-semibold text-slate-900 dark:text-white"
                                >
                                    Belum ada berita
                                </h3>
                                <p
                                    class="mt-2 text-slate-500 dark:text-slate-400"
                                >
                                    Silakan periksa kembali nanti untuk
                                    informasi terbaru dari PMI.
                                </p>
                            </div>

                            <div
                                v-else
                                class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3"
                            >
                                <article
                                    v-for="item in berita"
                                    :key="item.id"
                                    class="group relative flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-red-200 hover:shadow-lg dark:border-zinc-800 dark:bg-zinc-900 dark:hover:border-red-900/50"
                                >
                                    <div
                                        class="relative h-56 w-full overflow-hidden bg-slate-100 dark:bg-zinc-800"
                                    >
                                        <img
                                            :src="getImageUrl(item.thumbnail)"
                                            :alt="item.title"
                                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                        />
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-60"
                                        ></div>

                                        <span
                                            class="absolute bottom-4 left-4 rounded-full bg-red-600 px-3 py-1 text-xs font-bold text-white shadow-sm"
                                        >
                                            Berita Terkini
                                        </span>
                                    </div>

                                    <div class="flex flex-1 flex-col p-6">
                                        <div
                                            class="flex items-center gap-x-4 text-xs"
                                        >
                                            <time
                                                :datetime="item.publish_date"
                                                class="flex items-center gap-1 font-medium text-slate-500 dark:text-slate-400"
                                            >
                                                <svg
                                                    class="h-3.5 w-3.5"
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
                                                {{
                                                    formatDate(
                                                        item.publish_date,
                                                    )
                                                }}
                                            </time>
                                        </div>

                                        <div class="mt-3">
                                            <h3
                                                class="line-clamp-2 text-xl leading-tight font-bold text-slate-900 transition-colors group-hover:text-red-600 dark:text-white dark:group-hover:text-red-400"
                                            >
                                                <Link
                                                    :href="`/berita/${item.id}`"
                                                >
                                                    <span
                                                        class="absolute inset-0"
                                                    ></span>
                                                    {{ item.title }}
                                                </Link>
                                            </h3>

                                            <p
                                                class="mt-3 line-clamp-3 text-sm leading-relaxed text-slate-600 dark:text-slate-400"
                                            >
                                                {{
                                                    item.content ||
                                                    'Klik untuk membaca selengkapnya mengenai berita dan informasi kegiatan donor darah ini...'
                                                }}
                                            </p>
                                        </div>

                                        <Link
                                            :href="`/berita/${item.id}`"
                                            class="mt-auto flex items-center gap-x-2 pt-6 text-sm font-semibold text-red-600 dark:text-red-500"
                                        >
                                            Baca selengkapnya
                                            <svg
                                                class="h-4 w-4 transition-transform group-hover:translate-x-1"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M14 5l7 7m0 0l-7 7m7-7H3"
                                                ></path>
                                            </svg>
                                        </Link>
                                    </div>
                                </article>
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
