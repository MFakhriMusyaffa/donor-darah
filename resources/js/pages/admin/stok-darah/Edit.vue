<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { reactive, onMounted } from 'vue';

const form = reactive({
    id: null as number | null,
    golongan_darah: '',
    rhesus: '',
    jumlah_kantong: 0,
});

// ambil ID dari URL
const getId = () => {
    const path = window.location.pathname;
    return path.split('/').pop();
};

// fetch data dari API
const fetchData = async () => {
    const id = getId();
    const res = await fetch(`/api/stok-darah/${id}`);
    const data = await res.json();

    form.id = data.id;
    form.golongan_darah = data.golongan_darah;
    form.rhesus = data.rhesus;
    form.jumlah_kantong = data.jumlah_kantong;
};

onMounted(fetchData);

// SUBMIT UPDATE
const submit = async () => {
    if (!form.golongan_darah || !form.rhesus || form.jumlah_kantong <= 0) {
        alert('Semua field harus diisi!');
        return;
    }

    await fetch(`/api/stok-darah/${form.id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(form),
    });

    alert('Data berhasil diupdate!');
    window.location.href = '/admin/stok-darah';
};
</script>

<template>
    <Head title="Edit Stok Darah" />

    <div class="flex min-h-screen items-center justify-center bg-gray-100">
        <div class="w-full max-w-3xl rounded-xl bg-white p-8 shadow-md">
            <h1 class="mb-2 text-center text-2xl font-bold text-red-600">
                Edit Stok Darah
            </h1>
            <p class="mb-8 text-center text-sm text-gray-500">
                Perbarui informasi Stok Darah yang akan ditampilkan
            </p>

            <form @submit.prevent="submit" class="space-y-6">
                <!-- Golongan -->
                <div>
                    <label class="block text-sm font-medium text-gray-800"
                        >Golongan Darah</label
                    >
                    <select
                        v-model="form.golongan_darah"
                        class="mt-1 w-full rounded-lg border p-2 text-gray-800"
                    >
                        <option>A</option>
                        <option>B</option>
                        <option>AB</option>
                        <option>O</option>
                    </select>
                </div>

                <!-- Rhesus -->
                <div>
                    <label class="block text-sm font-medium text-gray-800"
                        >Rhesus</label
                    >
                    <select
                        v-model="form.rhesus"
                        class="mt-1 w-full rounded-lg border p-2 text-gray-800"
                    >
                        <option>+</option>
                        <option>-</option>
                    </select>
                </div>

                <!-- Jumlah -->
                <div>
                    <label class="block text-sm font-medium text-gray-800"
                        >Jumlah Kantong</label
                    >
                    <input
                        type="number"
                        v-model="form.jumlah_kantong"
                        class="mt-1 w-full rounded-lg border p-2 text-gray-800"
                    />
                </div>

                <button
                    type="submit"
                    class="w-full rounded-lg bg-red-600 py-2 text-white hover:bg-red-700"
                >
                    Update
                </button>
            </form>
        </div>
    </div>
</template>
