<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { reactive, onMounted, ref } from 'vue'; // <-- Tambahkan 'ref'
import AdminLayout from '@/layouts/AdminLayout.vue';
import Swal from 'sweetalert2';

const form = reactive({
    id: null as number | null,
    title: '',
    content: '',
    publish_date: '',
    thumbnail: null as File | null,
});

// State untuk menyimpan URL gambar yang akan dipreview
const previewUrl = ref<string | null>(null);

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
            // Jangan hapus preview gambar lama jika file baru ditolak
            return;
        }

        form.thumbnail = file;
        // Buat URL sementara untuk memunculkan preview gambar yang baru di-select
        previewUrl.value = URL.createObjectURL(file);
    }
};

const getId = () => {
    const path = window.location.pathname;
    return path.split('/').pop();
};

const fetchData = async () => {
    try {
        const id = getId();
        const res = await fetch(`/api/berita/${id}`);
        const data = await res.json();

        form.id = data.id;
        form.title = data.title;
        form.content = data.content;
        form.publish_date = data.publish_date;

        // Memunculkan gambar lama dari database
        // Asumsi: API kamu mengembalikan nama file/path di property `thumbnail`
        if (data.thumbnail) {
            // Sesuaikan awalan URL ini dengan struktur storage Laravel kamu
            // Misalnya: `/storage/berita/${data.thumbnail}` atau langsung dari API
            previewUrl.value = `/storage/${data.thumbnail}`;
        }
    } catch (error) {
        console.error('Gagal mengambil data:', error);
    }
};

onMounted(fetchData);

const submit = async () => {
    if (!form.title || !form.content || !form.publish_date) {
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan',
            text: 'Semua field (selain thumbnail) wajib diisi!',
            confirmButtonColor: '#dc2626',
        });
        return;
    }

    const formData = new FormData();

    formData.append('title', form.title);
    formData.append('content', form.content);
    formData.append('publish_date', form.publish_date);

    if (form.thumbnail) {
        formData.append('thumbnail', form.thumbnail);
    }

    try {
        const response = await fetch(`/api/berita/${form.id}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-HTTP-Method-Override': 'PUT',
            },
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Berita berhasil diupdate.',
            showConfirmButton: false,
            timer: 1500,
        }).then(() => {
            window.location.href = '/admin/berita';
        });
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'Terjadi kesalahan saat mengupdate berita.',
            confirmButtonColor: '#dc2626',
        });
    }
};
</script>

<template>
    <Head title="Edit Berita" />

    <AdminLayout>
        <div class="flex items-center justify-center">
            <div class="w-full max-w-3xl rounded-xl bg-white p-8 shadow-md">
                <div class="mb-8 text-center">
                    <h1 class="text-2xl font-bold text-red-600">Edit Berita</h1>
                    <p class="text-sm text-gray-500">
                        Perbarui informasi berita yang akan ditampilkan
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
                            class="mt-1 w-full rounded-lg border p-2 focus:border-red-500 focus:ring focus:ring-red-200"
                            placeholder="Masukkan Judul Berita"
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Content
                        </label>
                        <textarea
                            rows="4"
                            v-model="form.content"
                            class="mt-1 w-full rounded-lg border p-2 focus:border-red-500 focus:ring focus:ring-red-200"
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
                            class="mt-1 w-full rounded-lg border p-2 focus:border-red-500 focus:ring focus:ring-red-200"
                        />
                    </div>

                    <div>
                        <label
                            class="mb-2 block text-sm font-medium text-gray-700"
                        >
                            Thumbnail
                        </label>

                        <div v-if="previewUrl" class="mb-4">
                            <img
                                :src="previewUrl"
                                alt="Preview"
                                class="h-40 w-auto rounded-lg border object-cover shadow"
                            />
                        </div>

                        <input
                            type="file"
                            accept="image/*"
                            @change="handleFile"
                            class="mt-1 w-full text-sm text-gray-500 file:mr-4 file:rounded-md file:border-0 file:bg-red-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-red-700 hover:file:bg-red-100"
                        />
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-lg bg-red-600 py-2 text-white transition hover:bg-red-700"
                    >
                        Update Berita
                    </button>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
