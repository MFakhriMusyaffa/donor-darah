<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';

import ProfileWelcome from '@/components/dashboards/modern/ProfileWelcome.vue';
import BeritaList from '@/components/dashboards/modern/BeritaList.vue';
import JadwalKegiatanList from '@/components/dashboards/modern/JadwalKegiatanList.vue';
import StokDarahList from '@/components/dashboards/modern/StokDarahList.vue';

import Footer from '@/components/dashboards/modern/Footer.vue';

const breadcrumbs: BreadcrumbItem[] = [];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Dashboard Masyarakat" />

        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12">
                <ProfileWelcome />
            </div>
            <div class="col-span-12 lg:col-span-8">
                <BeritaList />
            </div>
            <div class="col-span-12 lg:col-span-4">
                <JadwalKegiatanList />
            </div>
            <div class="col-span-12">
                <StokDarahList />
            </div>

            <div class="col-span-12">
                <Footer />
            </div>
        </div>
    </AppLayout>
</template>
