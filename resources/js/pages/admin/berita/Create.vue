<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3'; // <-- Tambahkan router
import AdminLayout from '@/components/AdminLayout.vue';
import { reactive, ref } from 'vue';
import Swal from 'sweetalert2';

const form = reactive({
    title: '',
    content: '',
    publish_date: '',
    thumbnail: null as File | null,
});

const previewUrl = ref<string | null>(null);
const isProcessing = ref(false); // Untuk disable tombol

const handleFile = (e: Event) => {
    const target = e.target as HTMLInputElement;

    if (target.files && target.files[0]) {
        const file = target.files[0];
        const maxSize = 5 * 1024 * 1024; // 5MB

        if (file.size > maxSize) {
            Swal.fire({
                icon: 'error',
                title: 'Ukuran File Terlalu Besar!',
                text: 'Maksimal ukuran thumbnail adalah 5MB.',
                confirmButtonColor: '#dc2626',
            });

            target.value = '';
            form.thumbnail = null;
            previewUrl.value = null;
            return;
        }

        form.thumbnail = file;
        previewUrl.value = URL.createObjectURL(file);
    }
};

const submit = async () => {
    if (!form.title || !form.content || !form.publish_date || !form.thumbnail) {
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan',
            text: 'Semua field (termasuk thumbnail) wajib diisi!',
            confirmButtonColor: '#dc2626',
        });
        return;
    }

    isProcessing.value = true;
    const formData = new FormData();
    formData.append('title', form.title);
    formData.append('content', form.content);
    formData.append('publish_date', form.publish_date);
    formData.append('thumbnail', form.thumbnail);

    try {
        await fetch('/api/berita', {
            method: 'POST',
            body: formData,
        });

        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Berita berhasil ditambahkan.',
            showConfirmButton: false,
            timer: 1500,
        }).then(() => {
            router.get('/admin/berita'); // <-- Pindah mulus
        });
    } catch (error) {
        isProcessing.value = false;
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
        <div class="flex min-h-screen items-center justify-center py-10">
            <div class="w-full max-w-3xl rounded-xl bg-white p-8 shadow-md">
                <div class="mb-8 text-center">
                    <h1 class="text-2xl font-bold text-red-600">
                        Tambah Berita
                    </h1>
                    <p class="text-sm text-gray-500">
                        Isi form di bawah untuk menambahkan berita baru
                    </p>
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700"
                            >Judul</label
                        >
                        <input
                            type="text"
                            v-model="form.title"
                            class="mt-1 w-full rounded-lg border p-2 focus:border-red-500 focus:ring focus:ring-red-200"
                            placeholder="Masukkan Judul Berita"
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700"
                            >Content</label
                        >
                        <textarea
                            v-model="form.content"
                            rows="4"
                            class="mt-1 w-full rounded-lg border p-2 focus:border-red-500 focus:ring focus:ring-red-200"
                            placeholder="Deskripsi Content"
                        ></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700"
                            >Tanggal Publish</label
                        >
                        <input
                            type="date"
                            v-model="form.publish_date"
                            class="mt-1 w-full rounded-lg border p-2 focus:border-red-500 focus:ring focus:ring-red-200"
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700"
                            >Thumbnail</label
                        >
                        <input
                            type="file"
                            @change="handleFile"
                            accept="image/*"
                            class="mt-1 w-full text-sm text-slate-500 file:mr-4 file:rounded-full file:border-0 file:bg-red-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-red-700 hover:file:bg-red-100"
                        />

                        <div v-if="previewUrl" class="mt-4">
                            <p class="mb-2 text-xs text-slate-500">
                                Preview Gambar:
                            </p>
                            <img
                                :src="previewUrl"
                                alt="Preview Thumbnail"
                                class="h-48 w-auto rounded-lg border border-slate-200 object-cover shadow-sm"
                            />
                        </div>
                    </div>

                    <button
                        type="submit"
                        :disabled="isProcessing"
                        class="w-full rounded-lg bg-red-600 py-2 text-white transition hover:bg-red-700 disabled:bg-slate-400"
                    >
                        {{ isProcessing ? 'Menyimpan...' : 'Simpan Berita' }}
                    </button>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
