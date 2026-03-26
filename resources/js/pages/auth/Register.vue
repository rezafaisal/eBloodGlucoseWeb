<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

const form = useForm({
    name: '',
    age: '',
    gender: '',
    blood_type: '',
    height: '',
    weight: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <AuthBase
        title="Buat Akun"
        description="Masukkan data Anda di bawah ini untuk membuat akun"
        singleColumn
    >
        <Head title="Daftar" />

        <form @submit.prevent="submit" class="flex flex-col gap-4">
            <div class="grid gap-3">
                <div class="grid gap-2">
                    <Label for="name">Nama</Label>
                    <Input id="name" type="text" required autofocus v-model="form.name" placeholder="Nama lengkap" />
                    <InputError :message="form.errors.name" />
                </div>

                <div class="grid gap-2">
                    <Label for="age">Usia</Label>
                    <Input id="age" type="number" inputmode="numeric" min="1" max="120" required v-model.number="form.age" placeholder="mis. 30" />
                    <InputError :message="form.errors.age" />
                </div>

                <div class="grid gap-2">
                    <Label for="gender">Jenis Kelamin</Label>
                    <Select v-model="form.gender">
                        <SelectTrigger id="gender" class="w-full">
                            <SelectValue placeholder="Pilih jenis kelamin" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectItem value="male">Laki-laki</SelectItem>
                                <SelectItem value="female">Perempuan</SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                    <InputError class="mt-2" :message="form.errors.gender" />
                </div>

                <div class="grid gap-2">
                    <Label for="blood_type">Golongan Darah</Label>
                    <Select v-model="form.blood_type">
                        <SelectTrigger id="blood_type" class="w-full">
                            <SelectValue placeholder="Pilih golongan darah" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectItem value="A">A</SelectItem>
                                <SelectItem value="B">B</SelectItem>
                                <SelectItem value="AB">AB</SelectItem>
                                <SelectItem value="O">O</SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                    <InputError class="mt-2" :message="form.errors.blood_type" />
                </div>

                <div class="grid gap-2">
                    <Label for="height">Tinggi (cm)</Label>
                    <Input
                        id="height"
                        type="number"
                        inputmode="numeric"
                        min="30"
                        max="300"
                        required
                        v-model.number="form.height"
                        placeholder="mis. 170"
                    />
                    <InputError :message="form.errors.height" />
                </div>

                <div class="grid gap-2">
                    <Label for="weight">Berat (kg)</Label>
                    <Input
                        id="weight"
                        type="number"
                        inputmode="numeric"
                        min="30"
                        max="150"
                        required
                        v-model.number="form.weight"
                        placeholder="mis. 60"
                    />
                    <InputError :message="form.errors.weight" />
                </div>

                <div class="grid gap-2">
                    <Label for="email">Alamat email</Label>
                    <Input id="email" type="email" required v-model="form.email" placeholder="email@example.com" />
                    <InputError :message="form.errors.email" />
                </div>

                <div class="grid gap-2">
                    <Label for="password">Kata sandi</Label>
                    <Input
                        id="password"
                        type="password"
                        required
                        v-model="form.password"
                        placeholder="Kata sandi"
                    />
                    <InputError :message="form.errors.password" />
                </div>

                <div class="grid gap-2">
                    <Label for="password_confirmation">Konfirmasi kata sandi</Label>
                    <Input
                        id="password_confirmation"
                        type="password"
                        required
                        v-model="form.password_confirmation"
                        placeholder="Konfirmasi kata sandi"
                    />
                    <InputError :message="form.errors.password_confirmation" />
                </div>

                <Button type="submit" class="mt-2 w-full" tabindex="5" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Daftar
                </Button>
            </div>

            <div class="text-center text-sm text-muted-foreground">
                Sudah memiliki akun?
                <TextLink :href="route('login')" class="underline underline-offset-4" :tabindex="6">Masuk disini</TextLink>
            </div>
        </form>
    </AuthBase>
</template>
