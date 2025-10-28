<script setup>
import { Head, Link } from '@inertiajs/vue3'

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
})
</script>

<template>
    <Head title="Bienvenido" />

    <div class="relative min-h-screen flex flex-col bg-gradient-to-b from-indigo-50 via-white to-gray-100 dark:from-gray-900 dark:to-black text-gray-800 dark:text-white">
        <!-- Header -->
        <header class="absolute top-0 left-0 w-full flex justify-between items-center px-8 py-6 z-10 backdrop-blur-sm bg-white/60 dark:bg-gray-900/50 shadow-sm">
            <div class="flex items-center space-x-3">
                <svg class="w-10 h-10 text-indigo-600 dark:text-indigo-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3 10l9-7 9 7v11H3z"/>
                </svg>
                <span class="text-2xl font-bold text-indigo-700 dark:text-indigo-300">
                    Eventia
                </span>
            </div>

            <nav v-if="canLogin" class="flex items-center space-x-4">
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard')"
                    class="px-5 py-2.5 rounded-lg bg-indigo-600 text-white font-medium hover:bg-indigo-700 transition-all"
                >
                    Panel principal
                </Link>

                <template v-else>
                    <Link
                        :href="route('login')"
                        class="px-5 py-2.5 rounded-lg border border-indigo-600 text-indigo-600 hover:bg-indigo-600 hover:text-white font-medium transition-all"
                    >
                        Iniciar sesión
                    </Link>

                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="px-5 py-2.5 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 font-medium transition-all"
                    >
                        Registrarse
                    </Link>
                </template>
            </nav>
        </header>

        <!-- Hero section -->
        <main class="flex flex-col justify-center items-center text-center min-h-screen px-6">
            <div class="max-w-3xl">
                <h1 class="text-4xl sm:text-6xl font-extrabold mb-6 text-indigo-700 dark:text-indigo-300">
                    Gestiona tus espacios y eventos con facilidad
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-300 mb-10 leading-relaxed">
                    Bienvenido a <strong>Eventia</strong>, la plataforma que te permite administrar 
                    lugares o ubicaciones, eventos y capacidades de manera centralizada.
                    Organiza, controla y optimiza cada detalle desde un solo lugar.
                </p>

                <div class="flex flex-wrap justify-center gap-6">
                    <Link
                        :href="route('dashboard')"
                        class="px-6 py-3 bg-indigo-600 text-white font-medium rounded-xl shadow-md hover:-translate-y-1 hover:shadow-lg hover:bg-indigo-700 transition-all"
                    >
                        Ir al Panel
                    </Link>
                    <a
                        href="https://laravel.com/docs"
                        target="_blank"
                        class="px-6 py-3 bg-white dark:bg-zinc-900 font-medium rounded-xl border border-gray-200 dark:border-zinc-700 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all"
                    >
                        Conocer más
                    </a>
                </div>
            </div>

            <div class="mt-16 text-sm text-gray-500 dark:text-gray-400">
                Laravel v{{ laravelVersion }} • PHP v{{ phpVersion }}
            </div>
        </main>

        <!-- Background decorative -->
        <div class="absolute inset-0 -z-10 opacity-10 dark:opacity-20 bg-[url('/images/venues-bg.svg')] bg-cover bg-center"></div>
    </div>
</template>