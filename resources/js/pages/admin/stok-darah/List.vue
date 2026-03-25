<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

// data dummy yezz
import { ref } from 'vue';

const stok = ref([
    { id: 1, golongan: 'A', rhesus: '+', jumlah: 20 },
    { id: 2, golongan: 'B', rhesus: '-', jumlah: 15 },
    { id: 3, golongan: 'O', rhesus: '+', jumlah: 30 },
]);

const handleDelete = (id: number) => {
    if (!confirm('Yakin mau hapus data ini?')) return;

    stok.value = stok.value.filter((item) => item.id !== id);

    alert('Data berhasil dihapus');
};
</script>

<template>
    <Head title="Stok Darah" />

    <div class="min-h-screen bg-gray-100 p-10">
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
                            {{ item.golongan }}
                        </td>
                        <td class="border p-2 text-center">
                            {{ item.rhesus }}
                        </td>
                        <td class="border p-2 text-center">
                            {{ item.jumlah }}
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
