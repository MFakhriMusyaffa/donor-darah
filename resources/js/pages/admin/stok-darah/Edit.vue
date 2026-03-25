<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { reactive } from 'vue';

// dummy data berdasarkan id
const dummyData: any = {
    1: { golongan: 'A', rhesus: '+', jumlah: 20 },
    2: { golongan: 'B', rhesus: '-', jumlah: 15 },
    3: { golongan: 'O', rhesus: '+', jumlah: 30 },
};

// ambil id dari URL
const path = window.location.pathname;
const id = path.split('/').pop() as keyof typeof dummyData;

// form dari dummy
const form = reactive({
    golongan: dummyData[id]?.golongan || '',
    rhesus: dummyData[id]?.rhesus || '',
    jumlah: dummyData[id]?.jumlah || 0,
});
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

            <form class="space-y-6">
                <!-- Golongan -->
                <div>
                    <label class="block text-sm font-medium"
                        >Golongan Darah</label
                    >
                    <select
                        v-model="form.golongan"
                        class="mt-1 w-full rounded-lg border p-2"
                    >
                        <option>A</option>
                        <option>B</option>
                        <option>AB</option>
                        <option>O</option>
                    </select>
                </div>

                <!-- Rhesus -->
                <div>
                    <label class="block text-sm font-medium">Rhesus</label>
                    <select
                        v-model="form.rhesus"
                        class="mt-1 w-full rounded-lg border p-2"
                    >
                        <option>+</option>
                        <option>-</option>
                    </select>
                </div>

                <!-- Jumlah -->
                <div>
                    <label class="block text-sm font-medium"
                        >Jumlah Kantong</label
                    >
                    <input
                        type="number"
                        v-model="form.jumlah"
                        class="mt-1 w-full rounded-lg border p-2"
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
