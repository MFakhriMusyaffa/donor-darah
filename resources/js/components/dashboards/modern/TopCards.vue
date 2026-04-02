<script setup lang="ts">
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Autoplay } from 'swiper/modules'
import Card from '@/components/ui/card/Card.vue'

import { Link } from '@inertiajs/vue3'

import {TopCardInfo}  from '../../../_mockApis/dashboardData/modernData'

import 'swiper/css'

</script>

<template>
  <div class="w-full overflow-x-auto">
    <Swiper
      :modules="[Autoplay]"
      :slides-per-view="6"
      spaceBetween="24"
      :loop="true"
      freeMode
      :speed="5000"
      grabCursor
      :autoplay="{ delay: 0, disableOnInteraction: false }"
      :breakpoints="{
        0: { slidesPerView: 1, spaceBetween: 10 },
        640: { slidesPerView: 2, spaceBetween: 14 },
        768: { slidesPerView: 3, spaceBetween: 18 },
        1030: { slidesPerView: 4, spaceBetween: 18 },
        1200: { slidesPerView: 6, spaceBetween: 24 }
      }"
      class="mySwiper w-full"
    >
      <SwiperSlide v-for="item in TopCardInfo" :key="item.key" class="!w-auto">
        <Link :href="item.url" class="block min-w-max group">
          <Card :class="`${item.bgcolor} w-full border-none rounded-xl shadow-md hover:shadow-lg transition-all duration-300 group-hover:scale-105`">
            <div class="text-center py-2">
              <div class="flex justify-center mb-3">
                <img
                  :src="item.img"
                  width="50"
                  height="50"
                  class="mb-0"
                  alt="card-image"
                />
              </div>
              <p :class="`text-xs font-medium ${item.textclr} mb-2 opacity-75 uppercase tracking-wide`">{{ item.title }}</p>
              <h5 :class="`text-2xl font-bold ${item.textclr} mb-0`">{{ item.desc }}</h5>
            </div>
          </Card>
        </Link>
      </SwiperSlide>
    </Swiper>
  </div>
</template>
