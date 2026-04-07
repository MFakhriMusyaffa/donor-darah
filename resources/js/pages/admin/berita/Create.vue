<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { reactive } from 'vue';
import AdminLayout from '@/layouts/AdminLayout.vue';

const form = reactive({
    title: '',
    content: '',
    publish_date: '',
    thumbnail: null as File | null,
});

const handleFile = (e: Event) => {
    const target = e.target as HTMLInputElement;

    if (target.files && target.files[0]) {
        form.thumbnail = target.files[0];
    }
};

const submit = async () => {
    if (!form.title || !form.content || !form.publish_date) {
        alert('Semua field wajib diisi!');
        return;
    }

    const formData = new FormData();
    formData.append('title', form.title);
    formData.append('content', form.content);
    formData.append('publish_date', form.publish_date);

    if (form.thumbnail) {
        formData.append('thumbnail', form.thumbnail);
    }

    await fetch('/api/berita', {
        method: 'POST',
        body: formData,
    });

    alert('Berhasil ditambahkan!');
    window.location.href = '/admin/berita';
};
</script>

<template>
    <Head title="Tambah Berita" />

    <AdminLayout>
        <div class="flex items-center justify-center">
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
