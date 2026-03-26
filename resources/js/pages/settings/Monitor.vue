<script setup lang="ts">
import { Head, useForm, usePage } from '@inertiajs/vue3';
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { type BreadcrumbItem } from '@/types';
import { LoaderCircle } from 'lucide-vue-next';

interface Props {
    settings: {
        fasting_start_at: string | null;
        breakfast_at: string | null;
        updated_at: string;
    };
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Pengaturan Puasa',
        href: '/settings/monitor',
    },
];

const form = useForm({
    fasting_start_at: props.settings.fasting_start_at ?? '',
    breakfast_at: props.settings.breakfast_at ?? '',
});

const submit = () => {
    form.patch(route('monitor.update'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Pengaturan Monitoring" />

        <SettingsLayout>
            <div class="flex flex-col space-y-6">
                <HeadingSmall
                    title="Pengaturan Jadwal Puasa"
                    description="Atur jadwal mulai puasa dan waktu sarapan"
                />

                <form @submit.prevent="submit" class="space-y-6">
                    <div class="grid gap-2">
                        <Label for="fasting_start_at">Mulai Puasa</Label>
                        <Input
                            id="fasting_start_at"
                            type="time"
                            v-model="form.fasting_start_at"
                        />
                        <InputError :message="form.errors.fasting_start_at" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="breakfast_at">Waktu Sarapan</Label>
                        <Input
                            id="breakfast_at"
                            type="time"
                            v-model="form.breakfast_at"
                        />
                        <InputError :message="form.errors.breakfast_at" />
                    </div>

                    <div class="flex items-center gap-4">
                        <Button :disabled="form.processing">
                            <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                            Simpan
                        </Button>

                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0"
                        >
                            <p
                                v-show="form.recentlySuccessful"
                                class="text-sm text-neutral-600"
                            >
                                Tersimpan.
                            </p>
                        </Transition>
                    </div>
                </form>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
