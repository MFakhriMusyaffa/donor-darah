<script setup lang="ts">
import { Head, Form } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
</script>

<template>
    <Head title="Dashboard Masyarakat" />

    <div class="min-h-screen bg-gray-100 flex items-center justify-center">
        <div class="bg-white p-10 rounded-xl shadow-md text-center">
            <h1 class="text-3xl font-bold text-green-600">
                Dashboard Masyarakat
            </h1>

            <p class="mt-4 text-gray-600">
                Selamat datang di sistem donor darah
            </p>

            <div class="mt-6 text-sm text-gray-500">
                Silakan melihat informasi donor darah
            </div>

            <div class="mt-8">
                <Form method="POST" action="/logout">
                    <Button type="submit" class="w-full bg-green-600 hover:bg-green-700">
                        Logout
                    </Button>
                </Form>
            </div>
        </div>
    </div>
</template>