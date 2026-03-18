<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Tambah Berita" />

    <div class="flex min-h-screen items-center justify-center bg-gray-100">
        <div class="w-full max-w-3xl rounded-xl bg-white p-8 shadow-md">
            <div class="mb-8 text-center">
                <h1 class="text-2xl font-bold text-red-600">Tambah Berita</h1>
                <p class="text-sm text-gray-500">
                    Isi form di bawah untuk menambahkan berita baru
                </p>
            </div>

            <form class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Judul
                    </label>
                    <input
                        type="text"
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
                        class="mt-1 w-full rounded-lg border p-2 focus:border-red-500 focus:ring focus:ring-red-200"
                    />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Thumbnail
                    </label>
                    <input type="file" class="mt-1 w-full" />
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
</template>
