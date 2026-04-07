<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'

interface StokDarah {
  id: number
  golongan_darah: string
  rhesus: string
  jumlah_kantong: number
  created_at: string
  updated_at: string
}

const stokList = ref<StokDarah[]>([])
const loading = ref(true)

onMounted(async () => {
  try {
    const response = await axios.get('/api/stok-darah')
    stokList.value = Array.isArray(response.data) ? response.data : (response.data.data || [])
  } catch (error) {
    console.error('Error fetching stok darah:', error)
  } finally {
    loading.value = false
  }
})

const getBloodTypeEmoji = (golonganDarah: string) => {
  const emojis: Record<string, string> = {
    'A': '🔴',
    'B': '🟠',
    'AB': '🟡',
    'O': '🔵'
  }
  return emojis[golonganDarah] || '❓'
}

const getStokStatus = (jumlah: number) => {
  if (jumlah >= 100) return { status: 'Stok Tinggi', color: 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400' }
  if (jumlah >= 50) return { status: 'Stok Cukup', color: 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400' }
  if (jumlah >= 20) return { status: 'Stok Sedang', color: 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400' }
  return { status: 'Stok Rendah', color: 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400' }
}

const totalStok = computed(() => {
  return stokList.value.reduce((sum, item) => sum + item.jumlah_kantong, 0)
})
</script>

<template>
  <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-slate-200 dark:border-slate-700">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
      <div>
        <h3 class="text-2xl font-bold text-slate-900 dark:text-white">Stok Darah</h3>
        <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Status ketersediaan darah saat ini</p>
      </div>
      <div class="text-right">
        <div class="text-red-600 dark:text-red-400 text-3xl font-bold">{{ totalStok }}</div>
        <p class="text-xs text-slate-600 dark:text-slate-400">Total Kantong</p>
      </div>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="flex justify-center items-center py-12">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-red-500"></div>
    </div>

    <!-- Empty State -->
    <div v-else-if="stokList.length === 0" class="text-center py-12 text-slate-500 dark:text-slate-400">
      <p>Belum ada data stok darah</p>
    </div>

    <!-- Table -->
    <div v-else class="overflow-x-auto">
      <table class="w-full">
        <thead>
          <tr class="border-b-2 border-slate-200 dark:border-slate-700">
            <th class="text-left py-3 px-4 font-semibold text-slate-900 dark:text-white text-sm">Golongan Darah</th>
            <th class="text-left py-3 px-4 font-semibold text-slate-900 dark:text-white text-sm">Rhesus</th>
            <th class="text-center py-3 px-4 font-semibold text-slate-900 dark:text-white text-sm">Jumlah</th>
            <th class="text-left py-3 px-4 font-semibold text-slate-900 dark:text-white text-sm">Status</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="stok in stokList"
            :key="stok.id"
            class="border-b border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-700/50 transition-colors duration-200"
          >
            <!-- Golongan Darah -->
            <td class="py-4 px-4">
              <div class="flex items-center gap-3">
                <span class="text-2xl">{{ getBloodTypeEmoji(stok.golongan_darah) }}</span>
                <div>
                  <p class="font-semibold text-slate-900 dark:text-white">{{ stok.golongan_darah }}</p>
                </div>
              </div>
            </td>

            <!-- Rhesus -->
            <td class="py-4 px-4">
              <span class="text-slate-700 dark:text-slate-300 font-medium">
                {{ stok.rhesus }}
              </span>
            </td>

            <!-- Jumlah -->
            <td class="py-4 px-4 text-center">
              <span class="text-lg font-bold text-red-600 dark:text-red-400">{{ stok.jumlah_kantong }}</span>
            </td>

            <!-- Status -->
            <td class="py-4 px-4">
              <span :class="['px-3 py-1 rounded-full text-xs font-semibold', getStokStatus(stok.jumlah_kantong).color]">
                {{ getStokStatus(stok.jumlah_kantong).status }}
              </span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Footer Info -->
    <div v-if="stokList.length > 0" class="mt-6 pt-4 border-t border-slate-200 dark:border-slate-700">
      <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="text-center">
          <p class="text-xs text-slate-600 dark:text-slate-400 mb-1">Total Kantong</p>
          <p class="text-lg font-bold text-red-600 dark:text-red-400">{{ totalStok }}</p>
        </div>
        <div class="text-center">
          <p class="text-xs text-slate-600 dark:text-slate-400 mb-1">Jenis Darah</p>
          <p class="text-lg font-bold text-slate-900 dark:text-white">{{ stokList.length }}</p>
        </div>
        <div class="text-center">
          <p class="text-xs text-slate-600 dark:text-slate-400 mb-1">Rata-rata</p>
          <p class="text-lg font-bold text-slate-900 dark:text-white">{{ Math.round(totalStok / stokList.length) }}</p>
        </div>
        <div class="text-center">
          <p class="text-xs text-slate-600 dark:text-slate-400 mb-1">Status</p>
          <p class="text-lg font-bold text-green-600 dark:text-green-400">✓ Aktif</p>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
table {
  border-collapse: collapse;
}

thead tr {
  background-color: rgba(226, 232, 240, 0.5);
}

:global(.dark) thead tr {
  background-color: rgba(71, 85, 105, 0.2);
}
</style>
