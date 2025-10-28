<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <Head title="Recuperar contraseña" />

    <div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 px-6">
        <div class="w-full max-w-md bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-8">
            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <AuthenticationCardLogo class="w-16 h-16 text-[#AE00A0]" />
            </div>

            <!-- Encabezado -->
            <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-gray-100 mb-2">
                ¿Olvidaste tu contraseña?
            </h2>
            <p class="text-center text-gray-600 dark:text-gray-400 text-sm mb-6">
                No te preocupes. Ingresa el correo electrónico asociado a tu cuenta y te enviaremos un enlace para restablecer tu contraseña.
            </p>

            <!-- Estado -->
            <div
                v-if="status"
                class="mb-4 font-medium text-sm text-green-600 dark:text-green-400 text-center"
            >
                {{ status }}
            </div>

            <!-- Formulario -->
            <form @submit.prevent="submit" class="space-y-5">
                <div>
                    <InputLabel for="email" value="Correo electrónico" />
                    <TextInput
                        id="email"
                        v-model="form.email"
                        type="email"
                        class="mt-1 block w-full border border-[#AE00A0]/30 focus:border-[#AE00A0] focus:ring-[#AE00A0] rounded-lg"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="ejemplo@correo.com"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <PrimaryButton
                    class="w-full justify-center py-3 bg-[#AE00A0] hover:bg-[#93008A] text-white font-semibold rounded-lg transition-all"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    ENVIAR ENLACE DE RECUPERACIÓN
                </PrimaryButton>
            </form>

            <!-- Enlace inferior -->
            <div class="mt-6 text-center">
                <a
                    :href="route('login')"
                    class="text-sm text-[#AE00A0] hover:underline font-medium"
                >
                    ← Volver al inicio de sesión
                </a>
            </div>
        </div>
    </div>
</template>