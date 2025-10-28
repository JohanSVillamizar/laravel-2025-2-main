<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Checkbox from '@/Components/Checkbox.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Iniciar sesión" />

    <div class="min-h-screen flex bg-gradient-to-br from-indigo-100 via-white to-gray-100 dark:from-gray-900 dark:via-gray-950 dark:to-black">
        <!-- Panel ilustrativo -->
        <div class="hidden lg:flex lg:w-1/2 bg-indigo-700 dark:bg-indigo-900 text-white flex-col justify-center items-center px-12">
            <div class="text-center max-w-md">
                <AuthenticationCardLogo class="w-24 h-24 mx-auto mb-6 text-white opacity-90" />

                <h2 class="text-3xl font-bold mb-4">Bienvenido a Eventia</h2>
                <p class="text-indigo-100 leading-relaxed">
                    Administra tus <strong>espacios</strong>, <strong>eventos</strong> y <strong>capacidad</strong> desde un solo lugar.
                    Simplifica la organización de tus actividades con una plataforma moderna y fácil de usar.
                </p>
            </div>
        </div>

        <!-- Panel de formulario -->
        <div class="flex flex-col justify-center items-center w-full lg:w-1/2 px-6 sm:px-12 py-16">
            <div class="w-full max-w-md bg-white dark:bg-gray-900 rounded-2xl shadow-xl p-8">
                <div class="flex flex-col items-center mb-8">
                    <AuthenticationCardLogo class="w-20 h-20 text-indigo-600 dark:text-indigo-400" />
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mt-4">Inicia sesión</h1>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">Accede a tu panel de administración</p>
                </div>

                <div v-if="status" class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                    {{ status }}
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <div>
                        <InputLabel for="email" value="Correo electrónico" />
                        <TextInput
                            id="email"
                            v-model="form.email"
                            type="email"
                            class="mt-1 block w-full"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="usuario@ejemplo.com"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div>
                        <InputLabel for="password" value="Contraseña" />
                        <TextInput
                            id="password"
                            v-model="form.password"
                            type="password"
                            class="mt-1 block w-full"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••"
                        />
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <Checkbox v-model:checked="form.remember" name="remember" />
                            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Recordarme</span>
                        </label>

                        <Link
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline"
                        >
                            ¿Olvidaste tu contraseña?
                        </Link>
                    </div>

                    <PrimaryButton
                        class="w-full justify-center py-3 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-800 transition-all"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Ingresar
                    </PrimaryButton>

                    <div class="text-center mt-6 text-sm text-gray-500 dark:text-gray-400">
                        ¿No tienes cuenta?
                        <Link :href="route('register')" class="text-indigo-600 dark:text-indigo-400 hover:underline ml-1">
                            Regístrate aquí
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>