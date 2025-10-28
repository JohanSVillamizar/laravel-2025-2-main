<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div class="min-h-screen flex flex-col bg-gradient-to-b from-indigo-50 via-white to-gray-100 dark:from-gray-900 dark:to-black text-gray-800 dark:text-white">
        <Head :title="title" />

        <!-- HEADER -->
        <header class="w-full flex justify-between items-center px-8 py-5 shadow-sm bg-white/70 dark:bg-gray-900/60 backdrop-blur-md sticky top-0 z-50">
            <div class="flex items-center space-x-3">
                <ApplicationMark class="w-10 h-10 text-indigo-600 dark:text-indigo-400" />
                <span class="text-2xl font-bold text-indigo-700 dark:text-indigo-300">Eventia</span>
            </div>

            <nav class="hidden md:flex items-center space-x-6">
                <NavLink
                    :href="route('dashboard')"
                    :active="route().current('dashboard')"
                    class="font-medium text-indigo-700 dark:text-indigo-300 hover:text-indigo-900 dark:hover:text-indigo-100 transition"
                >
                    Inicio
                </NavLink>
                <NavLink
                    :href="route('profile.show')"
                    :active="route().current('profile.show')"
                    class="font-medium text-indigo-700 dark:text-indigo-300 hover:text-indigo-900 dark:hover:text-indigo-100 transition"
                >
                    Perfil
                </NavLink>

                <Dropdown align="right" width="48">
                    <template #trigger>
                        <button
                            class="flex items-center text-sm font-medium text-indigo-700 dark:text-indigo-300 hover:text-indigo-500 dark:hover:text-indigo-100 transition focus:outline-none"
                        >
                            {{ $page.props.auth.user.name }}
                            <svg
                                class="ml-2 w-4 h-4"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                    </template>

                    <template #content>
                        <DropdownLink :href="route('profile.show')">Perfil</DropdownLink>

                        <div class="border-t border-gray-200 dark:border-gray-700 my-1" />

                        <form @submit.prevent="logout">
                            <DropdownLink as="button">Cerrar sesión</DropdownLink>
                        </form>
                    </template>
                </Dropdown>
            </nav>

            <!-- BOTÓN MÓVIL -->
            <div class="md:hidden">
                <button
                    @click="showingNavigationDropdown = !showingNavigationDropdown"
                    class="text-indigo-700 dark:text-indigo-300 focus:outline-none"
                >
                    <svg v-if="!showingNavigationDropdown" xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </header>

        <!-- MENÚ RESPONSIVO -->
        <div v-show="showingNavigationDropdown" class="md:hidden bg-white/80 dark:bg-gray-900/70 backdrop-blur-md border-t border-gray-200 dark:border-gray-700">
            <div class="px-4 py-3 space-y-2">
                <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                    Inicio
                </ResponsiveNavLink>
                <ResponsiveNavLink :href="route('profile.show')" :active="route().current('profile.show')">
                    Perfil
                </ResponsiveNavLink>
                <form @submit.prevent="logout">
                    <ResponsiveNavLink as="button">Cerrar sesión</ResponsiveNavLink>
                </form>
            </div>
        </div>

        <!-- CONTENIDO PRINCIPAL -->
        <main class="flex-1 px-6 py-10">
            <div v-if="$slots.header" class="mb-8 text-center">
                <slot name="header" />
            </div>

            <div class="max-w-7xl mx-auto">
                <slot />
            </div>
        </main>

        <!-- FOOTER -->
        <footer class="py-6 text-center text-sm text-gray-500 dark:text-gray-400 border-t border-gray-200 dark:border-gray-800">
            © {{ new Date().getFullYear() }} Eventia — Gestiona tus eventos y espacios
        </footer>

        <!-- FONDO DECORATIVO -->
        <div class="absolute inset-0 -z-10 opacity-10 dark:opacity-20 bg-[url('/images/venues-bg.svg')] bg-cover bg-center"></div>
    </div>
</template>