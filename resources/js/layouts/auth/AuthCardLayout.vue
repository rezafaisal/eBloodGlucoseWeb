<script setup lang="ts">
import { Link } from '@inertiajs/vue3'

defineProps<{
    title?: string
    description?: string
    singleColumn?: boolean
}>()
</script>

<template>
    <div class="min-h-svh w-full bg-muted/40 flex items-center justify-center p-4 md:p-10">
        <div
            class="w-full rounded-2xl shadow-lg bg-white dark:bg-neutral-900 overflow-hidden grid"
            :class="[ singleColumn ? 'max-w-lg grid-cols-1' : 'max-w-6xl grid-cols-1 md:grid-cols-2' ]"
        >
            <Link
                :href="route('home')"
                class="relative flex items-center justify-center md:justify-start"
            >
                <div
                    class="w-full h-full bg-primary text-white px-8 py-10 md:py-0 flex items-center justify-center"
                    :class="[ singleColumn ? 'md:min-h-[200px]' : 'md:min-h-[400px]' ]"
                >
                    <img class="w-80" src="/logo.png" alt="Logo" />
                </div>

            </Link>

            <div class="p-6 sm:p-8 md:p-10 flex items-center justify-center">
                <div class="w-full max-w-md">
                    <header class="text-center md:text-left">
                        <h2 class="text-2xl font-semibold">
                            {{ title || 'Silakan Masuk' }}
                        </h2>
                        <p v-if="description" class="mt-1 text-sm text-muted-foreground">
                            {{ description }}
                        </p>
                    </header>

                    <div class="mt-6">
                        <slot />
                    </div>

                    <div class="mt-6 text-center text-sm text-muted-foreground">
                        <slot name="footer" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
