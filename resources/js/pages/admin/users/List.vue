<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import AdminLayout from '@/components/AdminLayout.vue'
import { ref } from 'vue'

const props = defineProps<{
    users: Array<{
        id: number
        name: string
        email: string
        role: string
        created_at: string
    }>
}>()

const showDeleteModal = ref(false)
const userToDelete = ref<typeof props.users[0] | null>(null)
const isDeleting = ref(false)

const openDeleteModal = (user: typeof props.users[0]) => {
    userToDelete.value = user
    showDeleteModal.value = true
}

const closeDeleteModal = () => {
    showDeleteModal.value = false
    userToDelete.value = null
}

const confirmDelete = () => {
    if (!userToDelete.value) return
    
    isDeleting.value = true
    router.delete(`/admin/users/${userToDelete.value.id}`, {
        onFinish: () => {
            isDeleting.value = false
            closeDeleteModal()
        }
    })
}
</script>

<template>
    <Head title="User Admin" />

    <AdminLayout title="User Admin">
        <div class="mx-auto max-w-6xl rounded-xl bg-white p-8 shadow-md">
            <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-red-600">Daftar Pengguna</h1>
                    <p class="mt-1 text-sm text-slate-500">Kelola akun admin dan masyarakat di sistem.</p>
                </div>
                <a
                    href="/admin/users/create"
                    class="rounded-lg bg-red-600 px-4 py-2 text-white hover:bg-red-700"
                >
                    + Tambah User
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-left text-sm text-slate-700">
                    <thead class="bg-slate-50 text-slate-900">
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
                            <td class="px-4 py-3">
                                <span class="rounded-full bg-slate-200 px-3 py-1 text-xs font-medium text-slate-800">
                                    {{ user.role }}
                                </span>
                            </td>
                            <td class="px-4 py-3">{{ new Date(user.created_at).toLocaleDateString('id-ID') }}</td>
                            <td class="px-4 py-3 text-center">
                                <div class="inline-flex items-center gap-2">
                                    <a
                                        :href="`/admin/users/edit/${user.id}`"
                                        class="rounded bg-blue-500 px-3 py-1 text-sm text-white hover:bg-blue-600"
                                    >
                                        Edit
                                    </a>
                                    <button
                                        @click="openDeleteModal(user)"
                                        class="rounded bg-red-500 px-3 py-1 text-sm text-white hover:bg-red-600"
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

        <!-- Delete Confirmation Modal -->
        <div v-if="showDeleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="rounded-lg bg-white p-6 shadow-xl">
                <h2 class="text-lg font-bold text-slate-900">Konfirmasi Hapus</h2>
                <p class="mt-2 text-slate-600">
                    Apakah Anda yakin ingin menghapus user <strong>{{ userToDelete?.name }}</strong> ({{ userToDelete?.email }})?
                </p>
                <p class="mt-2 text-sm text-red-600">Tindakan ini tidak dapat dibatalkan.</p>
                
                <div class="mt-6 flex items-center justify-end gap-3">
                    <button
                        @click="closeDeleteModal"
                        :disabled="isDeleting"
                        class="rounded-lg border border-slate-300 px-4 py-2 text-slate-700 hover:bg-slate-100 disabled:opacity-50"
                    >
                        Batal
                    </button>
                    <button
                        @click="confirmDelete"
                        :disabled="isDeleting"
                        class="rounded-lg bg-red-600 px-4 py-2 text-white hover:bg-red-700 disabled:bg-slate-400"
                    >
                        {{ isDeleting ? 'Menghapus...' : 'Hapus' }}
                    </button>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
