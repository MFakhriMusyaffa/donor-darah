<script setup lang="ts">
import { ref } from 'vue'
import { Head, useForm } from '@inertiajs/vue3'

// Props dummy untuk contoh tampilan (Nantinya dari Laravel Controller)
const props = defineProps({
    stats: {
        type: Object,
        default: () => ({ total_stok: 125, total_pendonor: 450, jadwal_aktif: 3 })
    },
    stokList: {
        type: Array,
        default: () => [
            { id: 1, gol_darah: 'A', rhesus: '+', jumlah_kantong: 35 },
            { id: 2, gol_darah: 'B', rhesus: '+', jumlah_kantong: 42 },
            { id: 3, gol_darah: 'O', rhesus: '-', jumlah_kantong: 8 },
            { id: 4, gol_darah: 'AB', rhesus: '+', jumlah_kantong: 15 },
        ]
    }
})

// State untuk Modal CRUD Stok
const isModalOpen = ref(false)
const isEditing = ref(false)
const form = useForm({
    id: null,
    gol_darah: 'A',
    rhesus: '+',
    jumlah_kantong: 0
})

const openModal = (item = null) => {
    if (item) {
        isEditing.value = true
        form.id = item.id
        form.gol_darah = item.gol_darah
        form.rhesus = item.rhesus
        form.jumlah_kantong = item.jumlah_kantong
    } else {
        isEditing.value = false
        form.reset()
    }
    isModalOpen.value = true
}

const closeModal = () => {
    isModalOpen.value = false
    form.reset()
}

const saveStok = () => {
    // Logika simpan data ke backend via Inertia
    console.log('Menyimpan data:', form.data())
    closeModal()
}

const deleteStok = (id) => {
    if (confirm('Yakin ingin menghapus data ini?')) {
        console.log('Menghapus ID:', id)
    }
}
</script>

<template>
    <Head title="Admin Workspace" />

    <div class="flex h-screen bg-slate-50 font-sans">
        
        <aside class="w-64 bg-white border-r border-slate-200 flex flex-col shadow-sm hidden md:flex">
            <div class="h-16 flex items-center px-6 border-b border-slate-100">
                <div class="flex items-center gap-2 text-rose-600 font-bold text-xl tracking-tight">
                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    BloodCare
                </div>
            </div>
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 bg-rose-50 text-rose-600 rounded-lg font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-slate-600 hover:bg-slate-100 rounded-lg font-medium transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Data Pendonor
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-slate-600 hover:bg-slate-100 rounded-lg font-medium transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Jadwal Kegiatan
                </a>
            </nav>
        </aside>

        <main class="flex-1 flex flex-col h-screen overflow-hidden">
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-8 z-10">
                <h1 class="text-xl font-semibold text-slate-800">Overview</h1>
                <div class="flex items-center gap-4">
                    <div class="w-9 h-9 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center font-bold border border-rose-200">
                        AD
                    </div>
                    <div class="text-sm">
                        <p class="font-medium text-slate-700">Admin Utama</p>
                        <p class="text-xs text-slate-500">Administrator</p>
                    </div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-8">
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-md transition-shadow">
                        <div class="absolute top-0 right-0 p-4 opacity-10 transform group-hover:scale-110 transition-transform text-rose-500">
                            <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        </div>
                        <p class="text-sm font-medium text-slate-500 mb-1">Total Stok Darah</p>
                        <h3 class="text-3xl font-bold text-slate-800">{{ props.stats.total_stok }} <span class="text-lg font-medium text-slate-500">Kantong</span></h3>
                    </div>
                    
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-md transition-shadow">
                        <p class="text-sm font-medium text-slate-500 mb-1">Pendonor Terdaftar</p>
                        <h3 class="text-3xl font-bold text-slate-800">{{ props.stats.total_pendonor }} <span class="text-lg font-medium text-slate-500">Orang</span></h3>
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-md transition-shadow">
                        <p class="text-sm font-medium text-slate-500 mb-1">Jadwal Mendatang</p>
                        <h3 class="text-3xl font-bold text-slate-800">{{ props.stats.jadwal_aktif }} <span class="text-lg font-medium text-slate-500">Event</span></h3>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div>
                            <h2 class="text-lg font-bold text-slate-800">Manajemen Stok Darah</h2>
                            <p class="text-sm text-slate-500">Kelola ketersediaan kantong darah berdasarkan golongan.</p>
                        </div>
                        <button @click="openModal()" class="flex items-center gap-2 bg-rose-600 hover:bg-rose-700 text-white px-5 py-2.5 rounded-xl font-medium transition-colors shadow-sm shadow-rose-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Stok
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/50 text-slate-500 text-sm border-b border-slate-100">
                                    <th class="px-6 py-4 font-medium">Golongan Darah</th>
                                    <th class="px-6 py-4 font-medium">Rhesus</th>
                                    <th class="px-6 py-4 font-medium">Jumlah Kantong</th>
                                    <th class="px-6 py-4 font-medium text-center">Status</th>
                                    <th class="px-6 py-4 font-medium text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-sm">
                                <tr v-for="stok in stokList" :key="stok.id" class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="w-10 h-10 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center font-bold text-lg">
                                            {{ stok.gol_darah }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-slate-700">{{ stok.rhesus }}</td>
                                    <td class="px-6 py-4 font-medium text-slate-800">{{ stok.jumlah_kantong }} Kantong</td>
                                    <td class="px-6 py-4 text-center">
                                        <span v-if="stok.jumlah_kantong > 10" class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold">Aman</span>
                                        <span v-else class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">Kritis</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-3">
                                            <button @click="openModal(stok)" class="text-slate-400 hover:text-blue-600 transition-colors font-medium">Edit</button>
                                            <button @click="deleteStok(stok.id)" class="text-slate-400 hover:text-red-600 transition-colors font-medium">Hapus</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" @click="closeModal"></div>
        
        <div class="relative bg-white w-full max-w-md rounded-2xl shadow-xl overflow-hidden transform transition-all p-6">
            <h3 class="text-xl font-bold text-slate-800 mb-1">{{ isEditing ? 'Edit Stok Darah' : 'Input Stok Baru' }}</h3>
            <p class="text-sm text-slate-500 mb-6">Pastikan data golongan darah dan rhesus sesuai.</p>

            <form @submit.prevent="saveStok" class="space-y-5">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Gol. Darah</label>
                        <select v-model="form.gol_darah" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none transition-all">
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="AB">AB</option>
                            <option value="O">O</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Rhesus</label>
                        <select v-model="form.rhesus" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none transition-all">
                            <option value="+">Positif (+)</option>
                            <option value="-">Negatif (-)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Jumlah Kantong</label>
                    <input type="number" v-model="form.jumlah_kantong" min="0" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none transition-all placeholder-slate-400" placeholder="Masukkan jumlah...">
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                    <button type="button" @click="closeModal" class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-sm transition-colors">
                        {{ isEditing ? 'Simpan Perubahan' : 'Tambahkan Data' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

</template>