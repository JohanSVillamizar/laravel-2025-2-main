<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Checkbox from '@/Components/Checkbox.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Registro" />

    <div class="min-h-screen flex bg-gradient-to-br from-indigo-100 via-white to-gray-100 dark:from-gray-900 dark:via-gray-950 dark:to-black">
        <!-- Panel ilustrativo -->
        <div class="hidden lg:flex lg:w-1/2 bg-indigo-700 dark:bg-indigo-900 text-white flex-col justify-center items-center px-12">
            <div class="text-center max-w-md">
                <AuthenticationCardLogo class="w-24 h-24 mx-auto mb-6 text-white opacity-90" />
                <h2 class="text-3xl font-bold mb-4">Únete a Eventia</h2>
                <p class="text-indigo-100 leading-relaxed">
                    Crea tu cuenta y comienza a gestionar tus <strong>espacios</strong> y <strong>eventos</strong> fácilmente.
                    Administra ubicaciones, capacidades y reservas desde un mismo lugar.
                </p>
            </div>
        </div>

        <!-- Panel de formulario -->
        <div class="flex flex-col justify-center items-center w-full lg:w-1/2 px-6 sm:px-12 py-16">
            <div class="w-full max-w-md bg-white dark:bg-gray-900 rounded-2xl shadow-xl p-8">
                <div class="flex flex-col items-center mb-8">
                    <AuthenticationCardLogo class="w-20 h-20 text-indigo-600 dark:text-indigo-400" />
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mt-4">Crear cuenta</h1>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">
                        Regístrate para acceder al panel de administración
                    </p>
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Nombre -->
                    <div>
                        <InputLabel for="name" value="Nombre completo" />
                        <TextInput
                            id="name"
                            v-model="form.name"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autofocus
                            autocomplete="name"
                            placeholder="Juan Pérez"
                        />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <!-- Correo -->
                    <div>
                        <InputLabel for="email" value="Correo electrónico" />
                        <TextInput
                            id="email"
                            v-model="form.email"
                            type="email"
                            class="mt-1 block w-full"
                            required
                            autocomplete="username"
                            placeholder="usuario@ejemplo.com"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <!-- Contraseña -->
                    <div>
                        <InputLabel for="password" value="Contraseña" />
                        <TextInput
                            id="password"
                            v-model="form.password"
                            type="password"
                            class="mt-1 block w-full"
                            required
                            autocomplete="new-password"
                            placeholder="••••••••"
                        />
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <!-- Confirmar contraseña -->
                    <div>
                        <InputLabel for="password_confirmation" value="Confirmar contraseña" />
                        <TextInput
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            type="password"
                            class="mt-1 block w-full"
                            required
                            autocomplete="new-password"
                            placeholder="••••••••"
                        />
                        <InputError class="mt-2" :message="form.errors.password_confirmation" />
                    </div>

                    <!-- Términos -->
                    <div
                        v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature"
                        class="flex items-start space-x-2 mt-4"
                    >
                        <Checkbox id="terms" v-model:checked="form.terms" name="terms" required />
                        <label for="terms" class="text-sm text-gray-600 dark:text-gray-400">
                            Acepto los
                            <a
                                target="_blank"
                                :href="route('terms.show')"
                                class="text-indigo-600 dark:text-indigo-400 hover:underline"
                            >
                                Términos de servicio
                            </a>
                            y la
                            <a
                                target="_blank"
                                :href="route('policy.show')"
                                class="text-indigo-600 dark:text-indigo-400 hover:underline"
                            >
                                Política de privacidad
                            </a>.
                        </label>
                    </div>

                    <!-- Botones -->
                    <div class="pt-2">
                        <PrimaryButton
                            class="w-full justify-center py-3 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-800 transition-all"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Registrarse
                        </PrimaryButton>

                        <div class="text-center mt-6 text-sm text-gray-500 dark:text-gray-400">
                            ¿Ya tienes cuenta?
                            <Link
                                :href="route('login')"
                                class="text-indigo-600 dark:text-indigo-400 hover:underline ml-1"
                            >
                                Inicia sesión
                            </Link>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>