<script setup lang="ts">
import { Head, Form } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
</script>

<template>
    <Head title="Admin Workspace" />

    <div class="flex h-screen bg-slate-50 font-sans">
        
        <aside class="w-64 bg-white border-r border-slate-200 flex flex-col shadow-sm hidden md:flex">
            <div class="h-16 flex items-center px-6 border-b border-slate-100">
                <div class="flex items-center gap-2 text-rose-600 font-bold text-xl tracking-tight">
                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    BloodCare
                </div>
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