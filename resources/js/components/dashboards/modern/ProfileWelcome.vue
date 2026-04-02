

<script setup lang="tsx">

import img1 from '@/assets/images/profile/user-1.jpg'
import customerimg from '@/assets/images/dashboard/customer-support-img.png'

</script>
<template>
    <div class="relative flex items-center justify-between bg-gradient-to-r from-red-50 to-red-100 dark:from-red-950 dark:to-red-900 rounded-xl p-6 shadow-md border border-red-100 dark:border-red-800 transition-colors duration-300">
        <div class="flex items-center gap-4">
            <div>
                <img :src=img1 alt="user-img" width="60" height="60" class="rounded-full border-2 border-red-200 dark:border-red-700 shadow-sm" />
            </div>
            <div class="flex flex-col gap-1">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Welcome back! 👋</h3>
                <p class="text-base font-bold text-red-600 dark:text-red-400">John Doe</p>
            </div>
        </div>
        <div class="hidden sm:block absolute right-8 bottom-0">
            <img :src=customerimg alt="support-img" width="145" height="95" class="opacity-90" />
        </div>
    </div>
</template>