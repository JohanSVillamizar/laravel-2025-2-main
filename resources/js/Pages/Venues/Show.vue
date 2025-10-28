<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
  venue: { type: Object, required: true },
  stats: { type: Object, default: () => ({}) },
});

const statusText = computed(() => (props.venue?.venue_status ? 'Activo' : 'Inactivo'));
const statusClasses = computed(() =>
  props.venue?.venue_status
    ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300'
    : 'bg-fuchsia-100 text-fuchsia-700 dark:bg-fuchsia-900/30 dark:text-fuchsia-300'
);

const mapsUrl = computed(() =>
  props.venue?.venue_address
    ? `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(props.venue.venue_address)}`
    : null
);

const fmtDate = d => {
  return new Date(d).toLocaleDateString('es-CO', {
    month: 'short', day: '2-digit', year: 'numeric',
  });
};
</script>

<template>
  <Head :title="`Lugar: ${props.venue?.venue_name ?? ''}`" />

  <AppLayout>
    <!-- Header centrado SOLO con el nombre -->
    <template #header>
      <div class="flex items-center justify-center">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 text-center">
          {{ props.venue?.venue_name ?? `Lugar #${props.venue?.id}` }}
        </h2>
      </div>
    </template>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
      <!-- Fila superior: a la derecha los botones, alineados sobre la tarjeta Estado -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        <div class="lg:col-span-2"></div>
        <div class="flex justify-end gap-3">
          <Link
            :href="route('venues.index')"
            class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200"
          >
            Volver
          </Link>
          <Link
            :href="route('venues.edit', props.venue.id)"
            class="px-4 py-2 rounded-lg bg-fuchsia-600 hover:bg-fuchsia-700 text-white"
          >
            Editar
          </Link>
        </div>
      </div>

      <!-- Subtítulo sobre la tarjeta Información General -->
      <div>
        <p class="text-sm text-gray-500 dark:text-gray-400">
          Detalle del lugar y acciones disponibles
        </p>
      </div>

      <!-- Grid principal -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Columna izquierda: Información general + Últimos eventos -->
        <div class="lg:col-span-2 space-y-6">
          <section class="rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
            <header class="px-6 py-4 border-b border-gray-100 dark:border-gray-800">
              <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                Información general
              </h3>
            </header>
            <div class="px-6 py-5 grid sm:grid-cols-2 gap-6">
              <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Nombre</p>
                <p class="mt-1 text-base font-medium text-gray-900 dark:text-gray-100">
                  {{ props.venue?.venue_name || '—' }}
                </p>
              </div>
              <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Capacidad Máxima</p>
                <p class="mt-1 text-base font-medium text-gray-900 dark:text-gray-100">
                  {{ props.venue?.venue_max_capacity ?? '—' }}
                </p>
              </div>
              <div class="sm:col-span-2">
                <p class="text-sm text-gray-500 dark:text-gray-400">Dirección</p>
                <div class="mt-1 flex items-center gap-3">
                  <p class="text-base font-medium text-gray-900 dark:text-gray-100">
                    {{ props.venue?.venue_address || '—' }}
                  </p>
                  <a
                    v-if="mapsUrl"
                    :href="mapsUrl"
                    target="_blank"
                    rel="noopener"
                    class="text-indigo-600 hover:underline text-sm"
                    title="Abrir en Google Maps"
                  >
                    Ver mapa
                  </a>
                </div>
              </div>
            </div>
          </section>

          <!-- Últimos eventos -->
          <section class="rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
            <header class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
              <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                Últimos eventos
              </h3>
              <span class="text-xs text-gray-500 dark:text-gray-400">Resumen</span>
            </header>
            <div class="px-6 py-5 divide-y divide-gray-100 dark:divide-gray-800">
              <div v-if="Array.isArray(props.venue?.events) && props.venue.events.length">
                <div
                  v-for="ev in props.venue.events"
                  :key="ev.id"
                  class="py-3 flex items-center justify-between"
                >
                  <div class="min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">
                      {{ ev.event_name }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                      {{ fmtDate(ev.event_date) }}
                    </p>
                  </div>
                  <!-- <Link :href="route('events.show', ev.id)" class="text-indigo-600 hover:underline text-sm">Ver</Link> -->
                </div>
              </div>
              <div v-else class="py-8 text-sm text-gray-500 dark:text-gray-400">
                No hay eventos asociados aún.
              </div>
            </div>
          </section>
        </div>

        <!-- Columna derecha: Estado y Metadatos -->
        <div class="space-y-6">
          <section class="rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
            <header class="px-6 py-4 border-b border-gray-100 dark:border-gray-800">
              <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                Estado
              </h3>
            </header>
            <div class="px-6 py-5">
              <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Estado operativo</p>
              <span
                class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full text-xs font-semibold"
                :class="statusClasses"
              >
                <span
                  class="h-2.5 w-2.5 rounded-full"
                  :class="props.venue?.venue_status ? 'bg-green-500' : 'bg-fuchsia-500'"
                />
                {{ statusText }}
              </span>
            </div>
          </section>

          <section class="rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
            <header class="px-6 py-4 border-b border-gray-100 dark:border-gray-800">
              <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                Metadatos
              </h3>
            </header>
            <div class="px-6 py-5 space-y-3">
              <div class="text-sm">
                <p class="text-gray-500 dark:text-gray-400">ID</p>
                <p class="font-medium text-gray-900 dark:text-gray-100">{{ props.venue?.id }}</p>
              </div>
              <div class="text-sm">
                <p class="text-gray-500 dark:text-gray-400">Creado</p>
                <p class="font-medium text-gray-900 dark:text-gray-100">
                  {{ props.venue?.created_at ?? '—' }}
                </p>
              </div>
              <div class="text-sm">
                <p class="text-gray-500 dark:text-gray-400">Actualizado</p>
                <p class="font-medium text-gray-900 dark:text-gray-100">
                  {{ props.venue?.updated_at ?? '—' }}
                </p>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
  </AppLayout>
</template>