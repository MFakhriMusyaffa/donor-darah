<script setup lang="ts">
import { ref, onMounted } from 'vue';
import axios from 'axios';

interface Berita {
    id: number;
    title: string;
    content: string;
    publish_date: string;
    thumbnail?: string;
    created_at: string;
}

const beritaList = ref<Berita[]>([]);
const loading = ref(true);

onMounted(async () => {
    try {
        const response = await axios.get('/api/berita');
        // Handle both response formats
        beritaList.value = Array.isArray(response.data)
            ? response.data
            : response.data.data || [];
    } catch (error) {
        console.error('Error fetching berita:', error);
    } finally {
        loading.value = false;
    }
});

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    });
};

const getThumbnailUrl = (path: string | undefined) => {
    if (!path) return '';
    if (path.startsWith('http')) return path;
    return path.startsWith('/') ? path : `/storage/${path}`;
};

const truncateContent = (content: string, maxLength: number = 100) => {
    if (content.length > maxLength) {
        return content.substring(0, maxLength) + '...';
    }
    return content;
};
</script>

<template>
    <div
        class="rounded-xl border border-slate-200 bg-gradient-to-br from-white to-slate-50 p-6 shadow-lg dark:border-slate-700 dark:from-slate-800 dark:to-slate-900"
    >
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white">
                    Berita Terbaru
                </h3>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                    Informasi donor darah dan kesehatan
                </p>
            </div>
            <div class="text-3xl font-bold text-red-500">📰</div>
        </div>

        <div v-if="loading" class="flex h-96 items-center justify-center">
            <div
                class="h-12 w-12 animate-spin rounded-full border-b-2 border-red-500"
            ></div>
        </div>

        <div
            v-else-if="beritaList.length === 0"
            class="py-12 text-center text-slate-500 dark:text-slate-400"
        >
            <p>Belum ada berita tersedia</p>
        </div>

        <div v-else class="max-h-96 space-y-4 overflow-y-auto pr-2">
            <div
                v-for="berita in beritaList"
                :key="berita.id"
                class="group rounded-lg border border-slate-300 bg-slate-100 p-4 transition-all duration-300 hover:border-red-500/50 hover:bg-slate-200 dark:border-slate-600 dark:bg-slate-700/50 dark:hover:bg-slate-700"
            >
                <div class="flex gap-4">
                    <div v-if="berita.thumbnail" class="flex-shrink-0">
                        <img
                            :src="getThumbnailUrl(berita.thumbnail)"
                            :alt="berita.title"
                            class="h-20 w-20 rounded-lg bg-slate-200 object-cover dark:bg-slate-700"
                            @error="
                                (e) =>
                                    ((
                                        e.target as HTMLImageElement
                                    ).style.display = 'none')
                            "
                        />
                    </div>
                    <div class="min-w-0 flex-1">
                        <h4
                            class="line-clamp-2 font-semibold text-slate-900 transition-colors group-hover:text-red-600 dark:text-white dark:group-hover:text-red-400"
                        >
                            {{ berita.title }}
                        </h4>
                        <p
                            class="mt-2 line-clamp-2 text-sm text-slate-700 dark:text-slate-300"
                        >
                            {{ truncateContent(berita.content) }}
                        </p>
                        <div class="mt-3 flex items-center justify-between">
                            <span
                                class="text-xs text-slate-600 dark:text-slate-400"
                            >
                                📅 {{ formatDate(berita.publish_date) }}
                            </span>
                            <a
                                href="#"
                                class="text-xs font-medium text-red-600 transition-colors hover:text-red-700 dark:text-red-500 dark:hover:text-red-400"
                            >
                                Baca selengkapnya →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-track {
    background: rgba(71, 85, 105, 0.2);
    border-radius: 3px;
}

::-webkit-scrollbar-thumb {
    background: rgba(239, 68, 68, 0.4);
    border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
    background: rgba(239, 68, 68, 0.6);
}
</style>
