<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { reactive, onMounted } from 'vue';
import AdminLayout from '@/layouts/AdminLayout.vue';

const form = reactive({
    id: null as number | null,
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

// ambil id dari URL
const getId = () => {
    const path = window.location.pathname;
    return path.split('/').pop();
};

const fetchData = async () => {
    const id = getId();
    const res = await fetch(`/api/berita/${id}`);
    const data = await res.json();

    console.log(data); // debug

    form.id = data.id;
    form.title = data.title;
    form.content = data.content;
    form.publish_date = data.publish_date;
};

onMounted(fetchData);
const submit = async () => {
    const formData = new FormData();

    formData.append('title', form.title);
    formData.append('content', form.content);
    formData.append('publish_date', form.publish_date);

    if (form.thumbnail) {
        formData.append('thumbnail', form.thumbnail);
    }

    await fetch(`/api/berita/${form.id}`, {
        method: 'POST', // Laravel butuh ini untuk PUT file
        body: formData,
        headers: {
            'X-HTTP-Method-Override': 'PUT',
        },
    });

    alert('Berhasil diupdate!');
    window.location.href = '/admin/berita';
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
                    Update Berita
                </button>
            </form>
        </div>
    </div>
    </AdminLayout>
</template>
