<template>
    <div class="grid grid-cols-2 gap-8 text-center w-52 md:w-72 mx-auto" :class="{'grid-cols-4 w-72' : fourCols }" data-aos="zoom-in">
        <div v-for="unit in timeUnits" :key="unit.label" class="flex flex-col items-center justify-center p-4 sm:p-6 md:p-8 rounded-lg" :class="{ [`bg-${color}`] : color }">
            <div class="text-5xl md:text-5xl font-bold mb-2">{{ unit.value }}</div>
            <div class="text-sm sm:text-md md:text-lg">{{ unit.label }}</div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue';

const {targetDate, fourCols} = defineProps(['targetDate', 'color', 'fourCols']);

const days = ref(0);
const hours = ref(0);
const minutes = ref(0);
const seconds = ref(0);

const timeUnits = computed(() => [
    { label: 'Hari', value: days.value },
    { label: 'Jam', value: hours.value },
    { label: 'Menit', value: minutes.value },
    { label: 'Detik', value: seconds.value },
]);

let timer: any = null;

const startCountdown = () => {
    const target = new Date(targetDate).getTime();
    timer = setInterval(() => {
        const now = new Date().getTime();
        const distance = target - now;

        days.value = Math.floor(distance / (1000 * 60 * 60 * 24));
        hours.value = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        minutes.value = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        seconds.value = Math.floor((distance % (1000 * 60)) / 1000);

        if (distance < 0) {
            clearInterval(timer);
            days.value = hours.value = minutes.value = seconds.value = 0;
        }
    }, 1000);
};

onMounted(() => {
    startCountdown();
});
</script>

