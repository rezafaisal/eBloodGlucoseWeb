<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Tabs, TabsList, TabsTrigger, TabsContent } from '@/components/ui/tabs';
import { Card, CardContent, CardHeader } from '@/components/ui/card';
import { DonutChart } from '@/components/ui/chart-donut';
import AppLayout from '@/layouts/AppLayout.vue';
import { useDateFormat } from '@/composables/useDateFormat'
import { BarChart } from '@/components/ui/chart-bar';

const { formatDateTime } = useDateFormat()

defineProps<{
    patient: { name: string; age: number; height: number; gender: string; blood_type: string, latest_weight: any };
    summary: { average: number; low: number; normal: number; high: number; total: number };
    readings: {
        id: number;
        blood_glucose: number;
        context_label: string;
        reading_time: string;
        created_at: string;
    }[];
    dailyReadings: { name: string; glucose: number }[];
}>();

const valueFormatter = () => {
    return '';
};
</script>

<template>
    <Head :title="`Detail ${patient.name}`" />

    <AppLayout>
        <div class="mt-4 flex flex-col gap-6">
            <div class="rounded-lg bg-white p-4 shadow">
                <div class="grid gap-4 md:grid-cols-5 text-md">
                    <div class="rounded-md bg-primary px-4 py-2 text-white text-center">
                        Nama : {{ patient.name }}
                    </div>
                    <div class="rounded-md bg-primary px-4 py-2 text-white text-center">
                        Usia : {{ patient.age }}
                    </div>
                    <div class="rounded-md bg-primary px-4 py-2 text-white text-center">
                        Tinggi : {{ patient.height }} cm
                    </div>
                    <div class="rounded-md bg-primary px-4 py-2 text-white text-center">
                        Berat : {{ patient.latest_weight?.weight ?? '-' }} kg
                    </div>
                    <div class="rounded-md bg-primary px-4 py-2 text-white text-center">
                        Golongan Darah : {{ patient.blood_type }}
                    </div>
                </div>
            </div>

            <Tabs default-value="chart">
                <div class="grid gap-6 md:grid-cols-4 mt-4">
                    <Card class="flex flex-col items-center p-4">
                        <CardHeader class="relative flex flex-col items-center py-0">
                            <DonutChart
                                index="name"
                                category="glucose"
                                :data="[
                                    { name: 'Rendah', glucose: summary.low },
                                    { name: 'Normal', glucose: summary.normal },
                                    { name: 'Tinggi', glucose: summary.high },
                                ]"
                                :colors="['#a855f7', '#22c55e', '#ef4444']"
                                :value-formatter="valueFormatter"
                                class="h-60 w-60"
                            />
                            <div class="pointer-events-none absolute inset-0 flex flex-col items-center justify-center">
                                <span class="text-sm text-gray-600">Rata-Rata</span>
                                <span class="text-2xl font-bold">{{ summary.average }}</span>
                                <span class="text-xs text-gray-500">mg/dL</span>
                            </div>
                        </CardHeader>

                        <CardContent class="mt-4 text-md w-full pb-0">
                            <div class="flex justify-between border-b py-1">
                                <span>Rendah</span>
                                <span class="text-purple-600">{{ summary.low }}</span>
                            </div>
                            <div class="flex justify-between border-b py-1">
                                <span>Normal</span>
                                <span class="text-green-600">{{ summary.normal }}</span>
                            </div>
                            <div class="flex justify-between border-b py-1">
                                <span>Tinggi</span>
                                <span class="text-red-600">{{ summary.high }}</span>
                            </div>
                            <div class="flex justify-between font-semibold py-1">
                                <span>Total</span>
                                <span>{{ summary.total }}</span>
                            </div>
                        </CardContent>
                    </Card>

                    <div class="md:col-span-3 rounded-lg bg-white p-4 shadow">
                        <TabsList>
                            <TabsTrigger value="chart">Grafik</TabsTrigger>
                            <TabsTrigger value="table">Tabel</TabsTrigger>
                        </TabsList>

                        <TabsContent value="chart" class="mt-4">
                            <div v-if="dailyReadings.length > 0" class="p-4 shadow">
                                <BarChart
                                    :data="dailyReadings"
                                    index="name"
                                    :categories="['glucose']"
                                    class="h-80 w-full"
                                    :show-legend="false"
                                    :rounded-corners="4"
                                    :colors="['#27a1bc']"
                                    style="--vis-text-color: 0 0% 20%;"
                                />
                            </div>
                            <p v-else class="ml-2 text-gray-500">Belum ada data gula darah dibulan ini</p>
                        </TabsContent>


                        <TabsContent value="table" class="mt-4">
                            <div class="overflow-x-auto rounded-lg bg-white shadow">
                                <table class="w-full border text-center text-sm">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th class="p-2">Tanggal</th>
                                        <th class="p-2">Jam</th>
                                        <th class="p-2">Glukosa (mg/dl)</th>
                                        <th class="p-2">Periode</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr
                                        v-for="r in readings"
                                        :key="r.id"
                                        class="border-t"
                                    >
                                        <td class="p-2">{{ formatDateTime(r.reading_time).day }}</td>
                                        <td class="p-2">{{ formatDateTime(r.reading_time).hour }}</td>
                                        <td class="p-2 font-semibold">{{ r.blood_glucose }}</td>
                                        <td class="p-2">{{ r.context_label }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </TabsContent>
                    </div>
                </div>
            </Tabs>
        </div>
    </AppLayout>
</template>
