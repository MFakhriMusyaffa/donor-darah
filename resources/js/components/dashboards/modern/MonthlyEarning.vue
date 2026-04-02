
<script setup lang="ts">
import { ref } from 'vue'
import { Card } from '@/components/ui/card'  

import {Icon} from '@iconify/vue'  
import  VueApexCharts from 'vue3-apexcharts'
import type { ApexOptions } from 'apexcharts'

const chartSeries = ref([
  {
    name: 'monthly earnings',
    color: 'var(--color-secondary)',
    data: [25, 66, 20, 40, 12, 58, 20],
  },
])

const chartOptions = ref<ApexOptions>({
  chart: {
    id: 'weekly-stats2',
    type: 'area',
    height: 120,
    sparkline: {
      enabled: true,
    },
    group: 'sparklines',
    fontFamily: 'inherit',
    foreColor: '#adb0bb',
  },
  stroke: {
    curve: 'smooth',
    width: 2,
  },
  fill: {
    type: 'gradient',
    gradient: {
      shadeIntensity: 0,
      inverseColors: false,
      opacityFrom: 0.1,
      opacityTo: 0,
      stops: [20, 180],
    },
  },
  markers: {
    size: 0,
  },
  tooltip: {
    theme: 'dark',
    fixed: {
      enabled: true,
      position: 'right',
    },
    x: {
      show: false,
    },
    y: {
      formatter: function (value: number) {
        return `$${value.toLocaleString()}K`
      },
    },
  },
})
</script>



<template>
  <Card class="p-0 h-full border border-gray-200 dark:border-gray-700 shadow-md rounded-xl overflow-hidden">
    <div class="p-6">
      <div class="grid grid-cols-12 gap-6">
        <div class="lg:col-span-8 md:col-span-8 col-span-8">
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Monthly Earnings</h3>
          <p class="text-3xl font-bold text-red-600 dark:text-red-400 mb-3">
            $6,820
          </p>
          <div class="flex items-center mb-3 gap-2">
            <span
              class="rounded-full p-1 bg-red-100 dark:bg-red-900/30 flex items-center justify-center"
            >
              <Icon icon="tabler:arrow-down-right" class="text-red-600 dark:text-red-400 w-4 h-4" />
            </span>
            <p class="text-sm font-semibold text-red-600 dark:text-red-400 mb-0">+9%</p>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-0">last year</p>
          </div>
        </div>
        <div class="lg:col-span-4 md:col-span-4 col-span-4">
          <div class="flex justify-end">
            <div
              class="text-white bg-red-600 dark:bg-red-500 rounded-full h-12 w-12 flex items-center justify-center shadow-md"
            >
              <Icon icon="tabler:currency-dollar" class="w-6 h-6" />
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="border-t border-gray-200 dark:border-gray-700">
      <VueApexCharts
        height="60"
        width="100%"
        type="area"
        :options="chartOptions"
        :series="chartSeries"
      />
    </div>
  </Card>
</template>