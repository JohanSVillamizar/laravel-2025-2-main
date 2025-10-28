<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  metrics: {
    type: Object,
    default: () => ({ users: 0, computers: 0, events: 0, venues: 0 }),
  },
  latest: {
    type: Object,
    default: () => ({ venues: [] }),
  },
});
</script>

<template>
  <AppLayout title="Panel principal">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Panel principal
      </h2>
    </template>

    <div
      class="py-12 bg-gradient-to-b from-indigo-50 via-white to-gray-100 dark:from-gray-900 dark:via-gray-950 dark:to-black min-h-screen">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div
          class="bg-white dark:bg-gray-900 overflow-hidden shadow-xl sm:rounded-2xl p-10 border border-gray-100 dark:border-gray-800">

          <!-- Encabezado -->
          <div class="text-center mb-10">
            <h3 class="text-3xl font-bold text-indigo-700 dark:text-indigo-300 mb-2">
              Bienvenido a Eventia 👋
            </h3>
            <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
              Administra usuarios, eventos, equipos y ubicaciones desde este panel central.
            </p>
          </div>

          <!-- Métricas -->
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div
              class="bg-indigo-100 dark:bg-indigo-950 p-6 rounded-2xl shadow-md hover:shadow-lg transition transform hover:-translate-y-1">
              <h2 class="text-sm font-semibold text-indigo-700 dark:text-indigo-300 uppercase mb-2">Usuarios</h2>
              <p class="text-3xl font-bold text-indigo-900 dark:text-indigo-200">{{ props.metrics.users }}</p>
              <p class="text-sm text-gray-700 dark:text-gray-400">Registrados</p>
            </div>

            <div
              class="bg-purple-100 dark:bg-purple-950 p-6 rounded-2xl shadow-md hover:shadow-lg transition transform hover:-translate-y-1">
              <h2 class="text-sm font-semibold text-purple-700 dark:text-purple-300 uppercase mb-2">Computadores</h2>
              <p class="text-3xl font-bold text-purple-900 dark:text-purple-200">{{ props.metrics.computers }}</p>
              <p class="text-sm text-gray-700 dark:text-gray-400">Equipos disponibles</p>
            </div>

            <div
              class="bg-pink-100 dark:bg-pink-950 p-6 rounded-2xl shadow-md hover:shadow-lg transition transform hover:-translate-y-1">
              <h2 class="text-sm font-semibold text-pink-700 dark:text-pink-300 uppercase mb-2">Eventos</h2>
              <p class="text-3xl font-bold text-pink-900 dark:text-pink-200">{{ props.metrics.events }}</p>
              <p class="text-sm text-gray-700 dark:text-gray-400">Programados</p>
            </div>

            <div
              class="bg-fuchsia-100 dark:bg-fuchsia-950 p-6 rounded-2xl shadow-md hover:shadow-lg transition transform hover:-translate-y-1">
              <h2 class="text-sm font-semibold text-fuchsia-700 dark:text-fuchsia-300 uppercase mb-2">Ubicaciones</h2>
              <p class="text-3xl font-bold text-fuchsia-900 dark:text-fuchsia-200">{{ props.metrics.venues }}</p>
              <p class="text-sm text-gray-700 dark:text-gray-400">Registradas</p>
            </div>
          </div>

          <!-- Secciones funcionales -->
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <Link href="#"
              class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-6 rounded-2xl shadow hover:shadow-lg transition flex flex-col justify-between">
            <div>
              <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Usuarios</h2>
              <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Administra los usuarios registrados y sus roles.
              </p>
            </div>
            <span
              class="mt-auto inline-block text-center bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">Administrar
              Usuarios</span>
            </Link>

            <Link href="#"
              class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-6 rounded-2xl shadow hover:shadow-lg transition flex flex-col justify-between">
            <div>
              <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Computadores</h2>
              <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Administra los equipos disponibles, su estado y
                asignaciones.</p>
            </div>
            <span
              class="mt-auto inline-block text-center bg-purple-600 text-white py-2 rounded-lg hover:bg-purple-700 transition">Ver
              Equipos</span>
            </Link>

            <Link :href="route('events.index')"
              class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-6 rounded-2xl shadow hover:shadow-lg transition flex flex-col justify-between">
            <div>
              <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Eventos y Reservas</h2>
              <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Crea, edita y gestiona los eventos programados.
              </p>
            </div>
            <span
              class="mt-auto inline-block text-center bg-pink-600 text-white py-2 rounded-lg hover:bg-pink-700 transition">Gestionar
              Eventos</span>
            </Link>

            <Link :href="route('venues.index')"
              class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-6 rounded-2xl shadow hover:shadow-lg transition flex flex-col justify-between">
            <div>
              <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Lugares o Ubicaciones</h2>
              <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Gestiona las sedes o espacios donde se realizan
                los
                eventos.</p>
            </div>
            <span
              class="mt-auto inline-block text-center bg-fuchsia-600 text-white py-2 rounded-lg hover:bg-fuchsia-700 transition">Ver
              Ubicaciones</span>
            </Link>
          </div>

          <!-- Últimos venues -->
          <div class="mt-12 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div
              class="lg:col-span-2 bg-white dark:bg-gray-800 p-8 rounded-2xl shadow border border-gray-100 dark:border-gray-700">
              <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Estadísticas Recientes</h2>
              <p class="text-gray-600 dark:text-gray-400 mb-4">Visualiza el rendimiento de los equipos, eventos activos
                y
                participación de usuarios.</p>
              <div
                class="bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-10 text-center text-gray-400 dark:text-gray-500 italic">
                [ Gráficos próximamente... ]
              </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow border border-gray-100 dark:border-gray-700">
              <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Últimas ubicaciones</h3>
              <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                <li v-for="v in props.latest.venues" :key="v.id" class="py-3 flex items-center justify-between">
                  <Link :href="route('venues.show', v.id)"
                    class="text-sm text-indigo-600 dark:text-indigo-300 hover:underline">
                  {{ v.venue_name }}
                  </Link>
                  <span class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full text-[11px] font-semibold"
                    :class="v.venue_status ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300' : 'bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-200'">
                    <span class="h-2 w-2 rounded-full" :class="v.venue_status ? 'bg-green-500' : 'bg-gray-400'" />
                    {{ v.venue_status ? 'Activo' : 'Inactivo' }}
                  </span>
                </li>
                <li v-if="props.latest.venues.length === 0" class="py-3 text-sm text-gray-500 dark:text-gray-400">
                  Sin registros recientes.
                </li>
              </ul>
            </div>
          </div>

        </div>
      </div>
    </div>
  </AppLayout>
</template>
