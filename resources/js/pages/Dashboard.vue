<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Card, CardContent, CardFooter, CardHeader } from '@/components/ui/card';
import { DonutChart } from '@/components/ui/chart-donut';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { SharedData } from '@/types';

defineProps(['patients']);

const page = usePage<SharedData>();

const valueFormatter = () => {
    return '';
};
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout>
        <div class="mt-4 flex flex-col gap-6">
            <div class="rounded-lg bg-white p-4 shadow">
                <p class="font-semibold">Selamat Datang, {{ page.props.auth.user.name }}.</p>
            </div>

            <div class="rounded-lg bg-white p-6 shadow">
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                    <Card v-for="(p, i) in patients" :key="i" class="flex flex-col items-center transition hover:shadow-lg">
                        <Link :href="route('detail', p.name)" class="flex h-full w-full flex-col items-center">
                            <CardHeader class="relative flex flex-col items-center pb-0">
                                <template v-if="p.average">
                                    <DonutChart
                                        index="name"
                                        category="glucose"
                                        :data="p.data"
                                        :value-formatter="valueFormatter"
                                        class="h-60 w-60"
                                        :colors="['#a855f7', '#22c55e', '#ef4444']"
                                    />
                                    <div class="pointer-events-none absolute inset-0 mt-4 flex flex-col items-center justify-center">
                                        <span class="text-sm text-gray-600">Rata-Rata</span>
                                        <span class="text-2xl font-bold">{{ p.average }}</span>
                                        <span class="text-xs text-gray-500">mg/dL</span>
                                    </div>
                                </template>
                                <template v-else>
                                    <div
                                        class="my-4 flex h-52 w-52 flex-col items-center justify-center rounded-full border border-dashed border-gray-300 text-gray-500"
                                    >
                                        <span class="text-sm">Belum ada</span>
                                        <span class="font-semibold">Data</span>
                                    </div>
                                </template>
                            </CardHeader>

                            <CardContent class="space-y-1 text-center text-sm">
                                <template v-if="p.data && p.data.length > 0">
                                    <p><span class="text-purple-600">Rendah</span> {{ p.data[0].blood }}</p>
                                    <p><span class="text-green-600">Normal</span> {{ p.data[1].blood }}</p>
                                    <p><span class="text-red-600">Tinggi</span> {{ p.data[2].blood }}</p>
                                </template>
                                <template v-else>
                                    <p class="italic text-gray-400">Belum ada data untuk ditampilkan</p>
                                </template>
                            </CardContent>

                            <CardFooter class="w-full items-center justify-center bg-gray-100 p-2 font-semibold">
                                {{ p.name }}
                            </CardFooter>
                        </Link>
                    </Card>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
