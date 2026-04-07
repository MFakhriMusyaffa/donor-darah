<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AdminLayout from '@/components/AdminLayout.vue';
import { ref, onMounted } from 'vue';

const showModal = ref(false);
const selectedId = ref<number | null>(null);

interface StokDarah {
    id: number;
    golongan_darah: string;
    rhesus: string;
    jumlah_kantong: number;
}

const stok = ref<StokDarah[]>([]);

const fetchData = async () => {
    const res = await fetch('/api/stok-darah');
    const data = await res.json();
    stok.value = data;
};

onMounted(fetchData);

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

    await fetch(`/api/stok-darah/${selectedId.value}`, {
        method: 'DELETE',
    });

    closeModal();
    fetchData();
};
</script>

<template>
    <Head title="Stok Darah" />

    <AdminLayout title="Stok Darah">
        <div class="mx-auto max-w-5xl rounded-xl bg-white p-8 shadow-md">
            <div class="mb-6 flex items-center justify-between">
                <h1 class="text-2xl font-bold text-red-600">
                    Daftar Stok Darah
                </h1>

                <a
                    href="/admin/stok-darah/create"
                    class="rounded-lg bg-red-600 px-4 py-2 text-white hover:bg-red-700"
                >
                    + Tambah Stok Darah
                </a>
            </div>

            <table class="w-full border">
                <thead class="bg-pink-50">
                    <tr>
                        <th class="border p-2">Golongan</th>
                        <th class="border p-2">Rhesus</th>
                        <th class="border p-2">Jumlah Kantong</th>
                        <th class="border p-2 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="item in stok" :key="item.id">
                        <td class="border p-2 text-center">
                            {{ item.golongan_darah }}
                        </td>
                        <td class="border p-2 text-center">
                            {{ item.rhesus }}
                        </td>
                        <td class="border p-2 text-center">
                            {{ item.jumlah_kantong }}
                        </td>

                        <td class="border p-2 text-center">
                            <div class="flex justify-center gap-2">
                                <a
                                    :href="`/admin/stok-darah/edit/${item.id}`"
                                    class="rounded bg-blue-500 px-3 py-1 text-white hover:bg-blue-600"
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
    </AdminLayout>

    <div
        v-if="showModal"
        class="fixed inset-0 flex items-center justify-center bg-black/30 z-50"
    >
        <div
            class="w-full max-w-sm scale-95 rounded-xl bg-white p-6 shadow-lg transition-all duration-200"
        >
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
