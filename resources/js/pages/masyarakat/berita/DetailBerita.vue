<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';

// Menangkap 1 data berita secara spesifik
defineProps<{
    berita: {
        id: number;
        title: string;
        publish_date: string;
        thumbnail?: string | null;
        content: string;
    };
}>();

// Helper untuk format tanggal
const formatDate = (dateString: string) => {
    const options: Intl.DateTimeFormatOptions = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    };
    return new Date(dateString).toLocaleDateString('id-ID', options);
};

// Helper untuk Path Gambar
const getImageUrl = (path?: string | null) => {
    if (!path) return '/images/default-thumbnail.jpg';
    if (path.startsWith('http')) return path;
    return `/storage/${path}`;
};
const breadcrumbs: BreadcrumbItem[] = [];
</script>

<template>
    <Head :title="berita.title" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <div class="mb-6">
                    <Link
                        href="/berita"
                        class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition-colors hover:text-red-600 dark:text-slate-400 dark:hover:text-red-400"
                    >
                        <svg
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"
                            ></path>
                        </svg>
                        Kembali ke Daftar Berita
                    </Link>
                </div>

                <article
                    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900"
                >
                    <header
                        class="border-b border-slate-100 p-8 pb-6 dark:border-zinc-800"
                    >
                        <div
                            class="mb-4 flex items-center gap-2 text-sm font-medium text-red-600 dark:text-red-500"
                        >
                            <span
                                class="rounded-full bg-red-100 px-3 py-1 dark:bg-red-900/30"
                                >Informasi PMI</span
                            >
                            <span class="text-slate-400 dark:text-slate-500"
                                >•</span
                            >
                            <time
                                :datetime="berita.publish_date"
                                class="text-slate-500 dark:text-slate-400"
                            >
                                {{ formatDate(berita.publish_date) }}
                            </time>
                        </div>

                        <h1
                            class="text-3xl leading-tight font-extrabold text-slate-900 sm:text-4xl dark:text-white"
                        >
                            {{ berita.title }}
                        </h1>
                    </header>

                    <div class="w-full bg-slate-100 dark:bg-zinc-800">
                        <img
                            :src="getImageUrl(berita.thumbnail)"
                            :alt="berita.title"
                            class="max-h-128 w-full object-cover"
                        />
                    </div>

                    <div class="p-8 sm:p-12">
                        <div
                            class="text-base leading-relaxed whitespace-pre-wrap text-slate-700 sm:text-lg dark:text-slate-300"
                        >
                            {{ berita.content }}
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </AppLayout>
</template>
