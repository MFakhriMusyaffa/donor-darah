<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AdminLayout from '@/components/AdminLayout.vue';
import { reactive, ref } from 'vue';
import Swal from 'sweetalert2';

const form = reactive({
    title: '',
    content: '',
    publish_date: '',
    thumbnail: null as File | null,
});

// State untuk menyimpan URL gambar sementara
const previewUrl = ref<string | null>(null);

// Handle file input event
const handleFile = (e: Event) => {
    const target = e.target as HTMLInputElement;

    if (target.files && target.files[0]) {
        const file = target.files[0];
        const maxSize = 5 * 1024 * 1024; // 5MB dalam satuan bytes

        // Validasi ukuran file
        if (file.size > maxSize) {
            Swal.fire({
                icon: 'error',
                title: 'Ukuran File Terlalu Besar!',
                text: 'Maksimal ukuran thumbnail adalah 5MB.',
                confirmButtonColor: '#dc2626',
            });

            // Reset input file
            target.value = '';
            form.thumbnail = null;
            previewUrl.value = null; // Hapus preview jika file dibatalkan
            return;
        }

        // Jika aman, masukkan ke state form
        form.thumbnail = file;

        // Buat URL sementara untuk memunculkan preview gambar
        previewUrl.value = URL.createObjectURL(file);
    }
};

const submit = async () => {
    // Validasi input kosong dengan SweetAlert
    if (!form.title || !form.content || !form.publish_date || !form.thumbnail) {
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan',
            text: 'Semua field (termasuk thumbnail) wajib diisi!',
            confirmButtonColor: '#dc2626',
        });
        return;
    }

    const formData = new FormData();
    formData.append('title', form.title);
    formData.append('content', form.content);
    formData.append('publish_date', form.publish_date);
    formData.append('thumbnail', form.thumbnail); // Thumbnail pasti ada karena sudah divalidasi di atas

    try {
        await fetch('/api/berita', {
            method: 'POST',
            body: formData,
        });

        // Sukses SweetAlert
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Berita berhasil ditambahkan.',
            showConfirmButton: false,
            timer: 1500,
        }).then(() => {
            window.location.href = '/admin/berita';
        });
    } catch (error) {
        // Error handling jika gagal fetch ke backend
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'Terjadi kesalahan saat menghubungi server.',
            confirmButtonColor: '#dc2626',
        });
    }
};
</script>

<template>
    <Head title="Tambah Berita" />

    <AdminLayout title="Berita">
        <div class="flex min-h-screen items-center justify-center">
            <div class="w-full max-w-3xl rounded-xl bg-white p-8 shadow-md">
                <div class="mb-8 text-center">
                    <h1 class="text-2xl font-bold text-red-600">Tambah Berita</h1>
                    <p class="text-sm text-gray-500">
                        Isi form di bawah untuk menambahkan berita baru
                    </p>
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Judul
                        </label>
                        <input
                            type="text"
                            v-model="form.title"
                            class="mt-1 w-full rounded-lg border p-2 ..."
                            placeholder="Masukkan Judul Berita"
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Content
                        </label>
                        <textarea
                            v-model="form.content"
                            rows="4"
                            class="mt-1 w-full rounded-lg border p-2 ..."
                            placeholder="Deskripsi Content"
                        ></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Tanggal Publish
                        </label>
                        <input
                            type="date"
                            v-model="form.publish_date"
                            class="mt-1 w-full rounded-lg border p-2 ..."
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Thumbnail
                        </label>
                        <input
                            type="file"
                            @change="handleFile"
                            class="mt-1 w-full"
                        />
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-lg bg-red-600 py-2 text-white transition hover:bg-red-700"
                    >
                        Simpan Berita
                    </button>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
