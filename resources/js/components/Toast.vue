<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { CheckCircle, AlertCircle, X } from 'lucide-vue-next'

interface Props {
    type: 'success' | 'error' | 'info'
    message: string
    duration?: number
}

const props = withDefaults(defineProps<Props>(), {
    duration: 3000,
})

const isVisible = ref(true)

const hide = () => {
    isVisible.value = false
}

onMounted(() => {
    const timer = setTimeout(hide, props.duration)
    return () => clearTimeout(timer)
})

const bgColor = {
    success: 'bg-green-50 border-green-200',
    error: 'bg-red-50 border-red-200',
    info: 'bg-blue-50 border-blue-200',
}

const textColor = {
    success: 'text-green-800',
    error: 'text-red-800',
    info: 'text-blue-800',
}

const iconColor = {
    success: 'text-green-500',
    error: 'text-red-500',
    info: 'text-blue-500',
}
</script>

<template>
    <transition
        enter-active-class="transition ease-out duration-300"
        enter-from-class="opacity-0 translate-y-2"
        enter-to-class="opacity-100 translate-y-0"
        leave-active-class="transition ease-in duration-200"
        leave-from-class="opacity-100 translate-y-0"
        leave-to-class="opacity-0 translate-y-2"
    >
        <div v-if="isVisible" :class="[bgColor[type], 'border rounded-lg p-4 flex items-start gap-3 shadow-md']">
            <div :class="iconColor[type]">
                <CheckCircle v-if="type === 'success'" class="w-5 h-5 flex-shrink-0 mt-0.5" />
                <AlertCircle v-else-if="type === 'error'" class="w-5 h-5 flex-shrink-0 mt-0.5" />
                <AlertCircle v-else class="w-5 h-5 flex-shrink-0 mt-0.5" />
            </div>

            <div class="flex-1">
                <p :class="[textColor[type], 'text-sm font-medium']">{{ message }}</p>
            </div>

            <button
                @click="hide"
                :class="[textColor[type], 'flex-shrink-0 ml-2 hover:bg-white hover:bg-opacity-30 p-1 rounded']"
            >
                <X class="w-4 h-4" />
            </button>
        </div>
    </transition>
</template>
