<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';

import TopCards from '@/components/dashboards/modern/TopCards.vue';
import RevenueUpdate from '@/components/dashboards/modern/RevenueUpdate.vue';
import YearlyBreakup from '@/components/dashboards/modern/YearlyBreakup.vue';
import MonthlyEarning from '@/components/dashboards/modern/MonthlyEarning.vue';

import ProfileWelcome from '@/components/dashboards/modern/ProfileWelcome.vue';

import RecentTransaction from '@/components/dashboards/modern/RecentTransaction.vue';
import TopPerformer from '@/components/dashboards/modern/TopPerformer.vue';
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
            <div class="col-span-12">
                <TopCards />
            </div>
            <div class="col-span-12 lg:col-span-8">
                <RevenueUpdate />
            </div>
            <div class="col-span-12 lg:col-span-4">
                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12">
                        <YearlyBreakup />
                    </div>
                    <div class="col-span-12">
                        <MonthlyEarning />
                    </div>
                </div>
            </div>
            <div class="col-span-12 lg:col-span-4">
                <RecentTransaction />
            </div>
            <div class="col-span-12 flex lg:col-span-8">
                <TopPerformer />
            </div>

            <div class="col-span-12">
                <Footer />
            </div>
        </div>
    </AppLayout>
</template>
