<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AdminLayout from '@/components/AdminLayout.vue';
import { reactive, onMounted } from 'vue';
import AdminLayout from '@/layouts/AdminLayout.vue';

const form = reactive({
    id: null as number | null,
    event_name: '',
    start_event: '',
    end_event: '',
    location: '',
    detail: '',
});

const getId = () => {
    const path = window.location.pathname;
    return path.split('/').pop();
};

const fetchData = async () => {
    const id = getId();
    const res = await fetch(`/api/jadwal-kegiatan/${id}`);
    const result = await res.json();

    const data = result.data; // 🔥 penting!

    form.id = data.id;
    form.event_name = data.event_name;
    form.start_event = data.start_event;
    form.end_event = data.end_event;
    form.location = data.location;
    form.detail = data.detail;
};

onMounted(fetchData);

const submit = async () => {
    await fetch(`/api/jadwal-kegiatan/${form.id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(form),
    });

    alert('Berhasil diupdate!');
    window.location.href = '/admin/jadwal';
};
</script>

<template>
    <Head title="Edit Jadwal Kegiatan" />

<<<<<<< HEAD
    <AdminLayout>
        <div class="flex items-center justify-center">
        <div class="w-full max-w-3xl rounded-xl bg-white p-10 shadow-md">
            <h1 class="mb-2 text-center text-2xl font-bold text-red-600">
                Edit Jadwal Kegiatan
            </h1>
            <p class="mb-8 text-center text-sm text-gray-500">
                Perbarui informasi Jadwal Kegiatan yang akan ditampilkan
            </p>

            <p class="mb-4 text-center text-sm text-gray-500">
                Sedang mengedit: <b>{{ form.event_name }}</b>
            </p>
            <form @submit.prevent="submit" class="space-y-6">
                <div class="grid grid-cols-2 gap-6 text-gray-800">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Nama Kegiatan
                        </label>
                        <input
                            type="text"
                            v-model="form.event_name"
                            class="mt-1 w-full rounded-lg border p-2 focus:ring-2 focus:ring-red-500"
                            placeholder="Contoh: Donor Darah PMI"
                        />
=======
    <AdminLayout title="Jadwal Kegiatan">
        <div class="flex min-h-screen items-center justify-center">
            <div class="w-full max-w-3xl rounded-xl bg-white p-10 shadow-md">
                <h1 class="mb-2 text-center text-2xl font-bold text-red-600">
                    Edit Jadwal Kegiatan
                </h1>
                <p class="mb-8 text-center text-sm text-gray-500">
                    Perbarui informasi Jadwal Kegiatan yang akan ditampilkan
                </p>

                <p class="mb-4 text-center text-sm text-gray-500">
                    Sedang mengedit: <b>{{ form.event_name }}</b>
                </p>
                <form @submit.prevent="submit" class="space-y-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
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
                            <label class="block text-sm font-medium text-gray-700">
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
                            <label class="block text-sm font-medium text-gray-700">
                                Tanggal Mulai
                            </label>
                            <input
                                type="date"
                                v-model="form.start_event"
                                class="mt-1 w-full rounded-lg border p-2 focus:ring-2 focus:ring-red-500"
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Tanggal Selesai
                            </label>
                            <input
                                type="date"
                                v-model="form.end_event"
                                class="mt-1 w-full rounded-lg border p-2 focus:ring-2 focus:ring-red-500"
                            />
                        </div>
>>>>>>> egi
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Detail Kegiatan
                        </label>
                        <textarea
                            v-model="form.detail"
                            rows="4"
                            class="mt-1 w-full rounded-lg border p-2 focus:ring-2 focus:ring-red-500"
<<<<<<< HEAD
                            placeholder="Contoh: Mall Jakarta"
                        />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6 text-gray-800">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Tanggal Mulai
                        </label>
                        <input
                            type="date"
                            v-model="form.start_event"
                            class="mt-1 w-full rounded-lg border p-2 focus:ring-2 focus:ring-red-500"
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
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
                        class="mt-1 w-full rounded-lg border p-2 text-gray-800 focus:ring-2 focus:ring-red-500"
                        placeholder="Deskripsi kegiatan"
                    ></textarea>
                </div>

                <button
                    type="submit"
                    class="w-full rounded-lg bg-red-600 py-2 text-white transition hover:bg-red-700"
                >
                    Simpan
                </button>
            </form>
        </div>
    </div>
=======
                            placeholder="Deskripsi kegiatan"
                        ></textarea>
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-lg bg-red-600 py-2 text-white transition hover:bg-red-700"
                    >
                        Simpan
                    </button>
                </form>
            </div>
        </div>
>>>>>>> egi
    </AdminLayout>
</template>
