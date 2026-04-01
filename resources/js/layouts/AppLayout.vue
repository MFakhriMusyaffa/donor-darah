<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItem } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

type Props = {
    breadcrumbs?: BreadcrumbItem[];
};
const page = usePage();
const flashSuccess = computed(() => page.props.flash.success);
const flashError = computed(() => page.props.flash.error);

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            v-if="flashSuccess"
            class="absolute top-5 right-5 mb-4 rounded-md bg-green-500 p-4 text-white shadow-md"
        >
            {{ flashSuccess }}
        </div>

        <div
            v-if="flashError"
            class="absolute top-5 right-5 mb-4 rounded-md bg-red-500 p-4 text-white shadow-md"
        >
            {{ flashError }}
        </div>
        <slot />
    </AppLayout>
</template>
