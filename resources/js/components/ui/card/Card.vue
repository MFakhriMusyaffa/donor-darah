<script setup lang="ts">
import type { HTMLAttributes } from "vue"
import { cn } from "@/lib/utils"


const props = defineProps<{
  class?: HTMLAttributes["class"]
}>()


</script>

<template>
  <div
    data-slot="card"
    :class="
      cn(
        'bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 flex flex-col gap-6 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-md hover:shadow-lg transition-all duration-300',
        props.class
      )
    "
  >
    <slot />
  </div>
</template>
