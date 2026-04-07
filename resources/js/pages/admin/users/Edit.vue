<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import { ref } from 'vue'
import AdminLayout from '@/layouts/AdminLayout.vue'

const props = defineProps<{
    id: number
}>()

const name = ref('')
const email = ref('')
const role = ref('masyarakat')

const handleSubmit = () => {
    alert(`Form edit user dummy: user id ${props.id}. Implement backend PUT /admin/users/${props.id} untuk menyimpan pembaruan.`)
}
</script>

<template>
    <Head title="Edit User" />

    <AdminLayout>
        <div class="mx-auto max-w-3xl rounded-xl bg-white p-8 shadow-md">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-red-600">Edit User</h1>
                <p class="mt-1 text-sm text-slate-500">Perbarui data user ID {{ props.id }}.</p>
            </div>

            <form @submit.prevent="handleSubmit" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Nama</label>
                    <input v-model="name" type="text" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3" placeholder="Perbarui nama" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Email</label>
                    <input v-model="email" type="email" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3" placeholder="Perbarui email" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Role</label>
                    <select v-model="role" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3">
                        <option value="admin">admin</option>
                        <option value="masyarakat">masyarakat</option>
                    </select>
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit" class="rounded-xl bg-rose-600 px-5 py-3 text-sm font-semibold text-white hover:bg-rose-700">
                        Update User
                    </button>
                    <a href="/admin/users" class="text-sm text-slate-600 hover:text-slate-900">Kembali ke Daftar User</a>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
