<script setup lang="ts">
import { ref, onMounted } from 'vue'
import axios from 'axios'

interface Berita {
  id: number
  title: string
  content: string
  publish_date: string
  thumbnail?: string
  created_at: string
}

const beritaList = ref<Berita[]>([])
const loading = ref(true)

onMounted(async () => {
  try {
    const response = await axios.get('/api/berita')
    // Handle both response formats
    beritaList.value = Array.isArray(response.data) ? response.data : (response.data.data || [])
  } catch (error) {
    console.error('Error fetching berita:', error)
  } finally {
    loading.value = false
  }
})

const formatDate = (date: string) => {
  return new Date(date).toLocaleDateString('id-ID', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}

const truncateContent = (content: string, maxLength: number = 100) => {
  if (content.length > maxLength) {
    return content.substring(0, maxLength) + '...'
  }
  return content
}
</script>

<template>
  <div class="bg-gradient-to-br from-white to-slate-50 dark:from-slate-800 dark:to-slate-900 rounded-xl p-6 shadow-lg border border-slate-200 dark:border-slate-700">
    <div class="flex items-center justify-between mb-6">
      <div>
        <h3 class="text-2xl font-bold text-slate-900 dark:text-white">Berita Terbaru</h3>
        <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Informasi donor darah dan kesehatan</p>
      </div>
      <div class="text-red-500 text-3xl font-bold">📰</div>
    </div>

    <div v-if="loading" class="flex justify-center items-center h-96">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-red-500"></div>
    </div>

    <div v-else-if="beritaList.length === 0" class="text-center py-12 text-slate-500 dark:text-slate-400">
      <p>Belum ada berita tersedia</p>
    </div>

    <div v-else class="space-y-4 max-h-96 overflow-y-auto pr-2">
      <div
        v-for="berita in beritaList"
        :key="berita.id"
        class="group bg-slate-100 hover:bg-slate-200 dark:bg-slate-700/50 dark:hover:bg-slate-700 rounded-lg p-4 transition-all duration-300 border border-slate-300 dark:border-slate-600 hover:border-red-500/50"
      >
        <div class="flex gap-4">
          <div v-if="berita.thumbnail" class="flex-shrink-0">
            <img
              :src="berita.thumbnail"
              :alt="berita.title"
              class="w-20 h-20 rounded-lg object-cover"
            />
          </div>
          <div class="flex-1 min-w-0">
            <h4 class="font-semibold text-slate-900 dark:text-white group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors line-clamp-2">
              {{ berita.title }}
            </h4>
            <p class="text-sm text-slate-700 dark:text-slate-300 mt-2 line-clamp-2">
              {{ truncateContent(berita.content) }}
            </p>
            <div class="flex items-center justify-between mt-3">
              <span class="text-xs text-slate-600 dark:text-slate-400">
                📅 {{ formatDate(berita.publish_date) }}
              </span>
              <a
                href="#"
                class="text-xs text-red-600 dark:text-red-500 hover:text-red-700 dark:hover:text-red-400 font-medium transition-colors"
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
