<script setup lang="ts">
import { ref, onMounted } from 'vue'
import axios from 'axios'

interface JadwalKegiatan {
  id: number
  event_name: string
  start_event: string
  end_event: string
  location: string
  detail: string
  created_at: string
}

const jadwalList = ref<JadwalKegiatan[]>([])
const loading = ref(true)

onMounted(async () => {
  try {
    const response = await axios.get('/api/jadwal-kegiatan')
    // Handle response format from controller
    jadwalList.value = response.data.data || response.data || []
  } catch (error) {
    console.error('Error fetching jadwal kegiatan:', error)
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

const formatTime = (date: string) => {
  return new Date(date).toLocaleTimeString('id-ID', {
    hour: '2-digit',
    minute: '2-digit'
  })
}

const isUpcoming = (startDate: string) => {
  return new Date(startDate) > new Date()
}

const getStatusColor = (startDate: string) => {
  if (isUpcoming(startDate)) {
    return 'bg-green-100 dark:bg-green-500/20 text-green-700 dark:text-green-400'
  }
  return 'bg-slate-300 dark:bg-slate-500/20 text-slate-700 dark:text-slate-400'
}

const getStatusText = (startDate: string) => {
  return isUpcoming(startDate) ? 'Mendatang' : 'Selesai'
}
</script>

<template>
  <div class="bg-gradient-to-br from-white to-slate-50 dark:from-slate-800 dark:to-slate-900 rounded-xl p-6 shadow-lg border border-slate-200 dark:border-slate-700">
    <div class="flex items-center justify-between mb-6">
      <div>
        <h3 class="text-2xl font-bold text-slate-900 dark:text-white">Jadwal Kegiatan</h3>
        <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Program donor darah & kegiatan</p>
      </div>
      <div class="text-red-500 text-3xl font-bold">📅</div>
    </div>

    <div v-if="loading" class="flex justify-center items-center h-96">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-red-500"></div>
    </div>

    <div v-else-if="jadwalList.length === 0" class="text-center py-12 text-slate-500 dark:text-slate-400">
      <p>Belum ada jadwal kegiatan</p>
    </div>

    <div v-else class="space-y-4 max-h-96 overflow-y-auto pr-2">
      <div
        v-for="jadwal in jadwalList"
        :key="jadwal.id"
        class="group bg-slate-100 hover:bg-slate-200 dark:bg-slate-700/50 dark:hover:bg-slate-700 rounded-lg p-4 transition-all duration-300 border border-slate-300 dark:border-slate-600 hover:border-red-500/50"
      >
        <div class="flex items-start justify-between gap-4">
          <div class="flex-1 min-w-0">
            <div class="flex items-center gap-3 mb-2">
              <h4 class="font-semibold text-slate-900 dark:text-white group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors line-clamp-1">
                {{ jadwal.event_name }}
              </h4>
              <span :class="['text-xs px-2 py-1 rounded-full font-medium', getStatusColor(jadwal.start_event)]">
                {{ getStatusText(jadwal.start_event) }}
              </span>
            </div>

            <div class="space-y-2 text-sm">
              <div class="flex items-center gap-2 text-slate-700 dark:text-slate-300">
                <span>🕐</span>
                <span>{{ formatDate(jadwal.start_event) }} at {{ formatTime(jadwal.start_event) }}</span>
              </div>

              <div class="flex items-center gap-2 text-slate-700 dark:text-slate-300">
                <span>📍</span>
                <span class="line-clamp-1">{{ jadwal.location }}</span>
              </div>

              <div class="flex items-start gap-2 text-slate-600 dark:text-slate-400">
                <span>ℹ️</span>
                <span class="line-clamp-2">{{ jadwal.detail }}</span>
              </div>
            </div>
          </div>

          <a
            href="#"
            class="text-red-600 dark:text-red-500 hover:text-red-700 dark:hover:text-red-400 font-medium transition-colors text-sm flex-shrink-0 mt-2"
          >
            →
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.line-clamp-1 {
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

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
