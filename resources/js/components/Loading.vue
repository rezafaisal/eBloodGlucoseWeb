<template>
    <Transition
        enter-active-class="transition duration-1000 ease-in-out"
        enter-to-class="opacity-0"
        leave-active-class="transition duration-1000 ease-in-out"
        leave-to-class="opacity-0"
    >
        <section v-if="!isLoaded" class="fixed z-[55]">
            <div class="h-screen w-screen bg-white flex items-center justify-center">
                <p class="animate-pulse">Teman Momen</p>
            </div>
        </section>
    </Transition>

    <Dialog :open="isNotGuest" @update:open="(val: any) => isNotGuest = val">
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Pemberitahuan</DialogTitle>
                <DialogDescription>Maaf, Anda tidak terdaftar dalam daftar tamu untuk acara ini.</DialogDescription>
            </DialogHeader>
        </DialogContent>
    </Dialog>
</template>

<script setup lang="ts">
import { Dialog, DialogTitle, DialogDescription, DialogContent, DialogHeader } from '@/components/ui/dialog';
import { ref } from 'vue';

const { isGuest } = defineProps({
    isLoaded: Boolean,
    isGuest: Boolean
})

const isNotGuest = ref(!isGuest);
</script>
