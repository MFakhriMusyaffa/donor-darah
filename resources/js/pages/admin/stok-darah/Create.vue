<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3'; // <-- Tambahkan router
import AdminLayout from '@/components/AdminLayout.vue';
import { reactive, ref } from 'vue'; // <-- Tambahkan ref
import Swal from 'sweetalert2'; // <-- Tambahkan SweetAlert2

const form = reactive({
    golongan_darah: '',
    rhesus: '',
    jumlah_kantong: 0,
});

// Status loading untuk tombol
const isProcessing = ref(false);

const submit = async () => {
    if (!form.golongan_darah || !form.rhesus || form.jumlah_kantong <= 0) {
        // Alert Error Keren
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'Semua field harus diisi dan jumlah tidak boleh 0!',
        });
        return;
    }

    // Kunci tombol saat memproses
    isProcessing.value = true;

    try {
        await fetch('/api/stok-darah', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(form),
        });

        // Alert Sukses Keren (Hilang otomatis dalam 1.5 detik)
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Stok Darah berhasil ditambahkan!',
            showConfirmButton: false,
            timer: 1500,
        }).then(() => {
            // Pindah halaman tanpa kedip
            router.get('/admin/stok-darah');
        });
    } catch (error) {
        isProcessing.value = false;
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'Terjadi kesalahan koneksi server.',
        });
    }
};
</script>

<template>
    <Head title="Tambah Stok Darah" />

    <AdminLayout title="Stok Darah">
        <div class="flex min-h-screen items-center justify-center">
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
                        :disabled="isProcessing"
                        class="w-full rounded-lg bg-red-600 py-2 text-white transition-colors hover:bg-red-700 disabled:bg-slate-400"
                    >
                        {{ isProcessing ? 'Menyimpan...' : 'Simpan' }}
                    </button>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
