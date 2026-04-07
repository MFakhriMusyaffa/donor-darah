<script setup lang="ts">
import AdminSidebar from './AdminSidebar.vue'
</script>

<template>
  <div class="min-h-screen bg-slate-50">
    <div class="flex min-h-screen">
      <AdminSidebar />
      <main class="flex-1 p-6 md:p-8">
        <slot />
      </main>
    </div>
  </div>
</template>
