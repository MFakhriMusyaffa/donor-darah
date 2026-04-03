<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

interface Jadwal {
    id: number;
    event_name: string;
    start_event: string;
    end_event: string;
    location: string;
    detail: string;
}

const jadwal = ref<Jadwal[]>([]);

const fetchData = async () => {
    const res = await fetch('/api/jadwal-kegiatan');
    const data = await res.json();
    jadwal.value = data.data;
};

onMounted(fetchData);

const showModal = ref(false);
const selectedId = ref<number | null>(null);

const openModal = (id: number) => {
    selectedId.value = id;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    selectedId.value = null;
};

const confirmDelete = async () => {
    if (!selectedId.value) return;

    await fetch(`/api/jadwal-kegiatan/${selectedId.value}`, {
        method: 'DELETE',
    });

    closeModal();
    fetchData();
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

                        <td class="border p-2">
                            {{ item.detail.slice(0, 30) }}...
                        </td>

                        <!-- AKSI -->
                        <td class="border p-2 text-center">
                            <div class="flex justify-center gap-2">
                                <a
                                    :href="`/admin/jadwal/edit/${item.id}`"
                                    class="rounded bg-blue-500 px-3 py-1 text-white"
                                >
                                    Edit
                                </a>

                                <button
                                    @click="openModal(item.id)"
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
    <div
        v-if="showModal"
        class="fixed inset-0 flex items-center justify-center bg-black/30"
    >
        <div class="w-full max-w-sm rounded-xl bg-white p-6 shadow-lg">
            <h2 class="mb-4 text-lg font-bold text-gray-800">
                Konfirmasi Hapus
            </h2>

            <p class="mb-6 text-sm text-gray-600">
                Yakin mau hapus data ini? Data tidak bisa dikembalikan.
            </p>

            <div class="flex justify-end gap-3">
                <button
                    @click="closeModal"
                    class="rounded-lg border px-4 py-2 text-gray-600 hover:bg-gray-100"
                >
                    Batal
                </button>

                <button
                    @click="confirmDelete"
                    class="rounded-lg bg-red-600 px-4 py-2 text-white hover:bg-red-700"
                >
                    Hapus
                </button>
            </div>
        </div>
    </div>
</template>
