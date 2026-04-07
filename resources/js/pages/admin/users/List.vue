<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

const props = defineProps<{
    users: Array<{
        id: number;
        name: string;
        email: string;
        role: string;
        created_at: string;
    }>;
}>();
</script>

<template>
    <Head title="User Admin" />

    <div class="min-h-screen bg-gray-100 p-10">
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
                            <td class="px-4 py-3">{{ user.role }}</td>
                            <td class="px-4 py-3">
                                {{
                                    new Date(
                                        user.created_at,
                                    ).toLocaleDateString()
                                }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="inline-flex items-center gap-2">
                                    <a
                                        :href="`/admin/users/edit/${user.id}`"
                                        class="rounded bg-blue-500 px-3 py-1 text-sm text-white hover:bg-blue-600"
                                    >
                                        Edit
                                    </a>
                                    <button
                                        class="rounded bg-red-500 px-3 py-1 text-sm text-white hover:bg-red-600"
                                        disabled
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
    </div>
</template>
