<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3'; // <-- Tambahkan router
import AdminLayout from '@/components/AdminLayout.vue';
import { reactive, ref } from 'vue'; // <-- Tambahkan ref
import Swal from 'sweetalert2'; // <-- Tambahkan SweetAlert2

const form = reactive({
    event_name: '',
    start_event: '',
    end_event: '',
    location: '',
    detail: '',
});

const isProcessing = ref(false);

const submit = async () => {
    // Validasi kosong
    if (
        !form.event_name ||
        !form.start_event ||
        !form.end_event ||
        !form.location ||
        !form.detail
    ) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Semua field wajib diisi!',
        });
        return;
    }

    // Validasi tanggal
    if (form.end_event < form.start_event) {
        Swal.fire({
            icon: 'warning',
            title: 'Tanggal Tidak Valid',
            text: 'Tanggal selesai tidak boleh mendahului tanggal mulai!',
        });
        return;
    }

    isProcessing.value = true;

    try {
        await fetch('/api/jadwal-kegiatan', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(form),
        });

        // Alert Sukses
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Jadwal kegiatan baru berhasil ditambahkan.',
            showConfirmButton: false,
            timer: 1500,
        }).then(() => {
            router.get('/admin/jadwal'); // Pindah mulus
        });
    } catch (error) {
        isProcessing.value = false;
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'Terjadi kesalahan pada server.',
        });
    }
};
</script>

<template>
    <Head title="Tambah Jadwal Kegiatan" />

    <AdminLayout title="Jadwal Kegiatan">
        <div class="flex min-h-screen items-center justify-center">
            <div class="w-full max-w-3xl rounded-xl bg-white p-10 shadow-md">
                <h1 class="mb-2 text-center text-2xl font-bold text-red-600">
                    Tambah Jadwal Kegiatan
                </h1>
                <p class="mb-8 text-center text-sm text-gray-500">
                    Isi form di bawah untuk menambahkan jadwal kegiatan baru
                </p>

                <form @submit.prevent="submit" class="space-y-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                            >
                                Nama Kegiatan
                            </label>
                            <input
                                type="text"
                                v-model="form.event_name"
                                class="mt-1 w-full rounded-lg border p-2 focus:ring-2 focus:ring-red-500"
                                placeholder="Contoh: Donor Darah PMI"
                            />
                        </div>

                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                            >
                                Lokasi
                            </label>
                            <input
                                type="text"
                                v-model="form.location"
                                class="mt-1 w-full rounded-lg border p-2 focus:ring-2 focus:ring-red-500"
                                placeholder="Contoh: Mall Jakarta"
                            />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                            >
                                Tanggal Mulai
                            </label>
                            <input
                                type="date"
                                v-model="form.start_event"
                                class="mt-1 w-full rounded-lg border p-2 focus:ring-2 focus:ring-red-500"
                            />
                        </div>

                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                            >
                                Tanggal Selesai
                            </label>
                            <input
                                type="date"
                                v-model="form.end_event"
                                class="mt-1 w-full rounded-lg border p-2 focus:ring-2 focus:ring-red-500"
                            />
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Detail Kegiatan
                        </label>
                        <textarea
                            v-model="form.detail"
                            rows="4"
                            class="mt-1 w-full rounded-lg border p-2 focus:ring-2 focus:ring-red-500"
                            placeholder="Deskripsi kegiatan"
                        ></textarea>
                    </div>

                    <button
                        type="submit"
                        :disabled="isProcessing"
                        class="w-full rounded-lg bg-red-600 py-2 text-white transition hover:bg-red-700 disabled:bg-slate-400"
                    >
                        {{ isProcessing ? 'Menyimpan...' : 'Simpan' }}
                    </button>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
