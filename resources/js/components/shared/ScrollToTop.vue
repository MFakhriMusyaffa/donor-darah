<script setup lang="tsx">
import { usePage } from '@inertiajs/vue3'
import { watch } from 'vue'

const page = usePage()

watch(
  () => page.url,
  () => {
    window.scrollTo({
      top: 0,
      left: 0,
      behavior: 'smooth',
    })
  }
)

</script>

<template>
     <slot />
</template>