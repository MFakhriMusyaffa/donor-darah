<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { reactive } from 'vue';
import AdminLayout from '@/layouts/AdminLayout.vue';

const form = reactive({
    golongan_darah: '',
    rhesus: '',
    jumlah_kantong: 0,
});

const submit = async () => {
    if (!form.golongan_darah || !form.rhesus || form.jumlah_kantong <= 0) {
        alert('Semua field harus diisi!');
        return;
    }

    await fetch('/api/stok-darah', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(form),
    });

    alert('Stok Darah Berhasil ditambahkan');

    form.golongan_darah = '';
    form.rhesus = '';
    form.jumlah_kantong = 0;
};
</script>

<template>
    <Head title="Tambah Stok Darah" />

    <AdminLayout>
        <div class="flex items-center justify-center">
        <div class="w-full max-w-3xl rounded-xl bg-white p-8 shadow-md">
            <h1 class="mb-2 text-center text-2xl font-bold text-red-600">
                Tambah Stok Darah
            </h1>
            <p class="mb-8 text-center text-sm text-gray-500">
                Isi form di bawah untuk menambahkan jadwal kegiatan baru
            </p>
            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Golongan Darah
                    </label>
                    <select
                        v-model="form.golongan_darah"
                        class="mt-1 w-full rounded-lg border p-2"
                    >
                        <option value="">-- Pilih Golongan --</option>
                        <option>A</option>
                        <option>B</option>
                        <option>AB</option>
                        <option>O</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Rhesus
                    </label>
                    <select
                        v-model="form.rhesus"
                        class="mt-1 w-full rounded-lg border p-2"
                    >
                        <option value="">-- Pilih Rhesus --</option>
                        <option>+</option>
                        <option>-</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Jumlah Kantong
                    </label>
                    <input
                        type="number"
                        v-model="form.jumlah_kantong"
                        class="mt-1 w-full rounded-lg border p-2"
                    />
                </div>

                <button
                    type="submit"
                    class="w-full rounded-lg bg-red-600 py-2 text-white hover:bg-red-700"
                >
                    Simpan
                </button>
            </form>
        </div>
    </div>
    </AdminLayout>
</template>
