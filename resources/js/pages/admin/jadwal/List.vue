<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const jadwal = ref([
    {
        id: 1,
        event_name: 'Donor Darah PMI',
        start_event: '2026-03-20',
        end_event: '2026-03-20',
        location: 'Mall Jakarta',
        detail: 'Kegiatan donor darah untuk umum',
    },
    {
        id: 2,
        event_name: 'Donor Kampus',
        start_event: '2026-03-25',
        end_event: '2026-03-25',
        location: 'Universitas Gunadarma',
        detail: 'Donor darah mahasiswa',
    },
]);

const handleDelete = (id: number) => {
    if (!confirm('Yakin mau hapus jadwal ini?')) return;

    jadwal.value = jadwal.value.filter((item) => item.id !== id);
};
</script>

<template>
    <Head title="Jadwal Kegiatan" />

    <div class="min-h-screen bg-gray-100 p-10">
        <div class="mx-auto max-w-6xl rounded-xl bg-white p-8 shadow-md">
            <div class="mb-6 flex items-center justify-between">
                <h1 class="text-2xl font-bold text-red-600">
                    Daftar Jadwal Kegiatan
                </h1>

                <a
                    href="/admin/jadwal/create"
                    class="rounded-lg bg-red-600 px-4 py-2 text-white hover:bg-red-700"
                >
                    + Tambah Jadwal Kegiatan
                </a>
            </div>

            <table class="w-full border">
                <thead class="bg-pink-50">
                    <tr>
                        <th class="border p-2">Nama Kegiatan</th>
                        <th class="border p-2">Mulai</th>
                        <th class="border p-2">Selesai</th>
                        <th class="border p-2">Lokasi</th>
                        <th class="border p-2">Detail</th>
                        <th class="border p-2 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="item in jadwal" :key="item.id">
                        <td class="border p-2">{{ item.event_name }}</td>
                        <td class="border p-2 text-center">
                            {{ item.start_event }}
                        </td>
                        <td class="border p-2 text-center">
                            {{ item.end_event }}
                        </td>
                        <td class="border p-2">{{ item.location }}</td>
                        <td class="border p-2">{{ item.detail }}</td>

                        <td class="border p-2 text-center">
                            <div class="flex justify-center gap-2">
                                <a
                                    :href="`/admin/jadwal/edit/${item.id}`"
                                    class="rounded bg-blue-500 px-3 py-1 text-white hover:bg-blue-600"
                                >
                                    Edit
                                </a>

                                <button
                                    @click="handleDelete(item.id)"
                                    class="rounded bg-red-500 px-3 py-1 text-white hover:bg-red-600"
                                >
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
