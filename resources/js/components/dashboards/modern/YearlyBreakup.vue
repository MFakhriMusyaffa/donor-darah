<script setup lang="ts">
import { ref } from 'vue'
import VueApexCharts from 'vue3-apexcharts'
import { Icon } from '@iconify/vue'

import Card from '@/components/ui/card/Card.vue'

// The data structure, same as React version
const chartOptions: any = ref({
  chart: {
    type: 'donut',
    fontFamily: 'inherit',
    foreColor: '#adb0bb',
    height: 155,
    offsetX: 18,
    toolbar: {
      show: false,
    },
  },
  plotOptions: {
    pie: {
      startAngle: 0,
      endAngle: 360,
      donut: {
        size: '75%',
      },
    },
  },
  stroke: {
    show: false,
  },
  dataLabels: {
    enabled: false,
  },
  legend: {
    show: false,
  },
  colors: [
    'var(--color-primary)',
    'var(--color-lightprimary)',
    'var(--color-secondary)',
  ],
  tooltip: {
    theme: 'dark',
    fillSeriesColor: false,
    y: {
      formatter: (value: number) => {
        return `$${value.toLocaleString()}K`
      },
    },
  },

})

const series = ref([38, 40, 25])
</script>

<template>
  <Card class="h-full">
    <div class="grid grid-cols-12 ">
      <!-- Left portion -->
      <div class="lg:col-span-6 md:col-span-6 col-span-8">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 lg:whitespace-nowrap">Yearly Breakup</h3>
        <p class="text-3xl font-bold text-red-600 dark:text-red-400 mb-3">
          $36,358
        </p>
        <div class="flex items-center mb-3 gap-2">
          <span class="rounded-full p-1 bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
            <Icon icon="tabler:arrow-up-left" class="text-green-600 dark:text-green-400 w-4 h-4" />
          </span>
          <p class="text-sm font-semibold text-green-600 dark:text-green-400 mb-0">+9%</p>
          <p class="text-sm text-gray-600 dark:text-gray-400 mb-0">last year</p>
        </div>
        <div class="flex gap-4 items-center mt-6">
          <div class="flex items-center gap-2">
            <Icon icon="tabler:point-filled" class="text-red-600 dark:text-red-400 w-3 h-3" />
            <span class="text-xs font-medium text-gray-600 dark:text-gray-400">2023</span>
          </div>
          <div class="flex items-center gap-2">
            <Icon icon="tabler:point-filled" class="text-blue-600 dark:text-blue-400 w-3 h-3" />
            <span class="text-xs font-medium text-gray-600 dark:text-gray-400">2024</span>
          </div>
          <div class="flex items-center gap-2">
            <Icon icon="tabler:point-filled" class="text-purple-600 dark:text-purple-400 w-3 h-3" />
            <span class="text-xs font-medium text-gray-600 dark:text-gray-400">2025</span>
          </div>
        </div>
      </div>






      <div class="lg:col-span-6 md:col-span-6 col-span-4">
        <div class="w-full max-w-75">
          <VueApexCharts :options="chartOptions" :series="series" type="donut" />
        </div>
      </div>


    </div>
  </Card>
</template>
