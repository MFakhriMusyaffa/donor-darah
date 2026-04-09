<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import AdminLayout from '@/components/AdminLayout.vue';
import { reactive, onMounted, ref } from 'vue';
import Swal from 'sweetalert2';

// Tangkap ID langsung dari Laravel Router
const props = defineProps<{
    id: string | number;
}>();

const form = reactive({
    id: null as number | null,
    event_name: '',
    start_event: '',
    end_event: '',
    location: '',
    detail: '',
});

const isProcessing = ref(false);

const fetchData = async () => {
    try {
        const res = await fetch(`/api/jadwal-kegiatan/${props.id}`);
        const result = await res.json();
        const data = result.data; // 🔥 penting!

        form.id = data.id;
        form.event_name = data.event_name;
        form.start_event = data.start_event;
        form.end_event = data.end_event;
        form.location = data.location;
        form.detail = data.detail;
    } catch (error) {
        console.error('Gagal mengambil data', error);
    }
};

onMounted(fetchData);

const submit = async () => {
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
        await fetch(`/api/jadwal-kegiatan/${form.id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(form),
        });

        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Jadwal kegiatan berhasil diupdate.',
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
    <Head title="Edit Jadwal Kegiatan" />

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
                        {{ isProcessing ? 'Menyimpan...' : 'Update' }}
                    </button>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
