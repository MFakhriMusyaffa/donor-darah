<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

interface Berita {
    id: number;
    title: string;
    content: string;
    publish_date: string;
}

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

    await fetch(`/api/berita/${selectedId.value}`, {
        method: 'DELETE',
    });

    closeModal();
    fetchData(); // refresh data
};

const berita = ref<Berita[]>([]);

const fetchData = async () => {
    const res = await fetch('/api/berita');
    const data = await res.json();
    berita.value = data;
};

onMounted(fetchData);

// DELETE (nanti kita upgrade ke modal)
const handleDelete = async (id: number) => {
    if (!confirm('Yakin hapus?')) return;

    await fetch(`/api/berita/${id}`, {
        method: 'DELETE',
    });

    fetchData();
};
</script>

<template>
    <Head title="Berita" />

    <div class="min-h-screen bg-gray-100 p-10">
        <div class="mx-auto max-w-5xl rounded-xl bg-white p-8 shadow-md">
            <div class="mb-6 flex items-center justify-between">
                <h1 class="text-2xl font-bold text-red-600">Daftar Berita</h1>

                <a
                    href="/admin/berita/create"
                    class="rounded-lg bg-red-600 px-4 py-2 text-white hover:bg-red-700"
                >
                    + Tambah Berita
                </a>
            </div>

            <table class="w-full border">
                <thead class="bg-pink-50">
                    <tr>
                        <th class="border p-2 text-left">Judul</th>
                        <th class="border p-2 text-left">Tanggal</th>
                        <th class="border p-2 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="item in berita" :key="item.id">
                        <td class="border p-2">
                            {{ item.title }}
                        </td>

                        <td class="border p-2 text-center">
                            {{ item.publish_date }}
                        </td>

                        <td class="border p-2 text-center">
                            <div class="flex justify-center gap-2">
                                <a
                                    :href="`/admin/berita/edit/${item.id}`"
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
        class="fixed inset-0 flex items-center justify-center bg-black/10"
    >
        <div class="w-full max-w-sm rounded-xl bg-white p-6 shadow-lg">
            <h2 class="mb-4 text-lg font-bold text-gray-800">
                Konfirmasi Hapus
            </h2>

            <p class="mb-6 text-sm text-gray-600">
                Yakin mau hapus berita ini?
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
