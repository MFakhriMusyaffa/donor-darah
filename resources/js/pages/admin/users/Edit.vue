<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import { router, usePage } from '@inertiajs/vue3'
import AdminLayout from '@/components/AdminLayout.vue'
import Toast from '@/components/Toast.vue'
import { ref, onMounted } from 'vue'

interface User {
    id: number
    name: string
    email: string
    role: string
}

const props = defineProps<{
    id: number
}>()

const name = ref('')
const email = ref('')
const password = ref('')
const role = ref('masyarakat')
const errors = ref<Record<string, string>>({})
const isLoading = ref(false)
const validationError = ref('')
const isLoadingData = ref(true)

onMounted(async () => {
    try {
        const response = await fetch(`/admin/users/${props.id}/data`)
        const user: User = await response.json()
        name.value = user.name
        email.value = user.email
        role.value = user.role
    } catch (error) {
        validationError.value = 'Gagal memuat data user'
        console.error('Error fetching user:', error)
    } finally {
        isLoadingData.value = false
    }
})

const handleSubmit = async () => {
    isLoading.value = true
    errors.value = {}
    validationError.value = ''

    // Basic client-side validation
    if (!name.value.trim()) {
        validationError.value = 'Nama tidak boleh kosong'
        isLoading.value = false
        return
    }
    if (!email.value.trim()) {
        validationError.value = 'Email tidak boleh kosong'
        isLoading.value = false
        return
    }
    if (password.value && password.value.length < 8) {
        validationError.value = 'Password minimal 8 karakter'
        isLoading.value = false
        return
    }

    router.put(`/admin/users/${props.id}`, {
        name: name.value,
        email: email.value,
        password: password.value,
        role: role.value,
    }, {
        onError: (errorsBag) => {
            errors.value = errorsBag as Record<string, string>
            const firstError = Object.values(errorsBag)[0]
            validationError.value = Array.isArray(firstError) ? firstError[0] : firstError
            isLoading.value = false
        }
    })
}
</script>

<template>
    <Head title="Edit User" />

    <AdminLayout title="User Admin">
        <div class="min-h-screen bg-gray-100 p-10">
            <div class="mx-auto max-w-3xl rounded-xl bg-white p-8 shadow-md">
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-red-600">Edit User</h1>
                    <p class="mt-1 text-sm text-slate-500">Perbarui data user ID {{ props.id }}.</p>
                </div>

                <!-- Loading state -->
                <div v-if="isLoadingData" class="text-center py-8">
                    <p class="text-slate-600">Memuat data user...</p>
                </div>

                <!-- Client-side validation error -->
                <Toast v-if="validationError" type="error" :message="validationError" :duration="5000" />

                <form v-if="!isLoadingData" @submit.prevent="handleSubmit" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Nama</label>
                        <input 
                            v-model="name" 
                            type="text" 
                            class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900" 
                            placeholder="Perbarui nama"
                            :class="{ 'border-red-500 bg-red-50': errors.name }"
                        />
                        <p v-if="errors.name" class="mt-1 text-sm text-red-500">{{ errors.name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Email</label>
                        <input 
                            v-model="email" 
                            type="email" 
                            class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900" 
                            placeholder="Perbarui email"
                            :class="{ 'border-red-500 bg-red-50': errors.email }"
                        />
                        <p v-if="errors.email" class="mt-1 text-sm text-red-500">{{ errors.email }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Password (Kosongkan jika tidak ingin mengubah)</label>
                        <input 
                            v-model="password" 
                            type="password" 
                            class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900" 
                            placeholder="Minimal 8 karakter (opsional)"
                            :class="{ 'border-red-500 bg-red-50': errors.password }"
                        />
                        <p v-if="errors.password" class="mt-1 text-sm text-red-500">{{ errors.password }}</p>
                        <p v-if="password" class="mt-1 text-xs text-slate-500">{{ password.length }} / 8 karakter minimum</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Role</label>
                        <select 
                            v-model="role" 
                            class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900"
                            :class="{ 'border-red-500 bg-red-50': errors.role }"
                        >
                            <option value="admin">Admin</option>
                            <option value="masyarakat">Masyarakat</option>
                        </select>
                        <p v-if="errors.role" class="mt-1 text-sm text-red-500">{{ errors.role }}</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <button 
                            type="submit" 
                            :disabled="isLoading"
                            class="rounded-xl bg-rose-600 px-5 py-3 text-sm font-semibold text-white hover:bg-rose-700 disabled:bg-slate-400"
                        >
                            {{ isLoading ? 'Menyimpan...' : 'Update User' }}
                        </button>
                        <a href="/admin/users" class="text-sm text-slate-600 hover:text-slate-900">Kembali ke Daftar User</a>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
