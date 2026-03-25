<script setup lang="ts">
import { Head, Form } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
</script>

<template>
    <Head title="Dashboard Admin" />

    <div class="min-h-screen bg-gray-100 flex items-center justify-center">
        <div class="bg-white p-10 rounded-xl shadow-md text-center">
            <h1 class="text-3xl font-bold text-red-600">
                Dashboard Admin
            </h1>

            <p class="mt-4 text-gray-600">
                Anda login sebagai <strong>ADMIN</strong>
            </p>

            <div class="mt-6 text-sm text-gray-500">
                Sistem Manajemen Donor Darah
            </div>

            <div class="mt-8">
                <Form method="POST" action="/logout">
                    <Button type="submit" class="w-full bg-red-600 hover:bg-red-700">
                        Logout
                    </Button>
                </Form>
            </div>
        </div>
    </div>
</template>