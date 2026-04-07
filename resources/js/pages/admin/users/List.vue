<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';
import Swal from 'sweetalert2'; // Import SweetAlert2

const props = defineProps<{
    users: Array<{
        id: number;
        name: string;
        email: string;
        role: string;
        created_at: string;
    }>;
}>();

// Fungsi untuk menghapus dengan SweetAlert2
const deleteUser = (id: number) => {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: 'Data pengguna ini akan dihapus secara permanen!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626', // Warna merah Tailwind (red-600)
        cancelButtonColor: '#64748b', // Warna abu-abu Tailwind (slate-500)
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) {
            // Gunakan router Inertia agar halaman otomatis refresh datanya!
            router.delete(`/admin/users/${id}`, {
                preserveScroll: true, // Agar layar tidak loncat ke atas
                onSuccess: () => {
                    Swal.fire({
                        title: 'Terhapus!',
                        text: 'Data pengguna berhasil dihapus.',
                        icon: 'success',
                        confirmButtonColor: '#16a34a', // Warna hijau Tailwind
                    });
                },
            });
        }
    });
};
</script>

<template>
    <Head title="User Admin" />

    <AdminLayout>
        <div class="mx-auto max-w-6xl rounded-xl bg-white p-8 shadow-md">
            <div
                class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between"
            >
                <div>
                    <h1 class="text-2xl font-bold text-red-600">
                        Daftar Pengguna
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Kelola akun admin dan masyarakat di sistem.
                    </p>
                </div>
                <a
                    href="/admin/users/create"
                    class="rounded-lg bg-red-600 px-4 py-2 text-white hover:bg-red-700"
                >
                    + Tambah User
                </a>
            </div>

            <div class="overflow-x-auto">
                <table
                    class="min-w-full divide-y divide-slate-200 text-left text-sm text-slate-700"
                >
                    <thead class="bg-pink-50 text-slate-900">
                        <tr>
                            <th class="px-4 py-3">Nama</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Role</th>
                            <th class="px-4 py-3">Dibuat</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        <tr v-for="user in props.users" :key="user.id">
                            <td class="px-4 py-3">{{ user.name }}</td>
                            <td class="px-4 py-3">{{ user.email }}</td>
                            <td class="px-4 py-3 font-medium">
                                {{ user.role }}
                            </td>
                            <td class="px-4 py-3">
                                {{
                                    new Date(
                                        user.created_at,
                                    ).toLocaleDateString('id-ID')
                                }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="inline-flex items-center gap-2">
                                    <a
                                        :href="`/admin/users/edit/${user.id}`"
                                        class="rounded bg-blue-500 px-3 py-1 text-sm text-white transition-colors hover:bg-blue-600"
                                    >
                                        Edit
                                    </a>
                                    <button
                                        @click="deleteUser(user.id)"
                                        class="rounded bg-red-500 px-3 py-1 text-sm text-white transition-colors hover:bg-red-600"
                                    >
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>
