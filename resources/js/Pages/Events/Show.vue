<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
  event: { type: Object, required: true },
});

const statusText = computed(() => {
  // Podrías definir estados si tienes
  return 'Estado no definido';
});

const statusClasses = computed(() => {
  // Define clases si tienes estados
  return 'bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-200';
});

const fmtDate = d =>
  new Date(d).toLocaleDateString('es-CO', {
    month: 'short', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit'
  });
</script>

<template>

  <Head :title="`Evento: ${props.event?.event_name ?? ''}`" />

  <AppLayout>
    <!-- Header centrado con nombre del evento -->
    <template #header>
      <div class="flex items-center justify-center">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 text-center">
          {{ props.event?.event_name ?? `Evento #${props.event?.id}` }}
        </h2>
      </div>
    </template>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

      <!-- Fila superior: botones 'Volver' y 'Editar' a la derecha -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        <div class="lg:col-span-2"></div>
        <div class="flex justify-end gap-3">
          <Link :href="route('events.index')"
            class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200">
          Volver</Link>
          <Link :href="route('events.edit', props.event.id)"
            class="px-4 py-2 rounded-lg bg-pink-600 hover:bg-pink-700 text-white">Editar</Link>
        </div>
      </div>

      <!-- Subtítulo -->
      <div>
        <p class="text-sm text-gray-500 dark:text-gray-400">
          Detalle del evento y acciones disponibles
        </p>
      </div>

      <!-- Grid principal con detalles y estado/metadatos -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Detalles evento -->
        <section class="lg:col-span-2 rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
          <header class="px-6 py-4 border-b border-gray-100 dark:border-gray-800">
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
              Información general
            </h3>
          </header>
          <div class="px-6 py-5 space-y-6">
            <div>
              <p class="text-sm text-gray-500 dark:text-gray-400">Nombre</p>
              <p class="mt-1 text-base font-medium text-gray-900 dark:text-gray-100">
                {{ props.event?.event_name || '—' }}
              </p>
            </div>
            <div>
              <p class="text-sm text-gray-500 dark:text-gray-400">Fecha y hora</p>
              <p class="mt-1 text-base font-medium text-gray-900 dark:text-gray-100">
                {{ fmtDate(props.event?.event_date) || '—' }}
              </p>
            </div>
            <div>
              <p class="text-sm text-gray-500 dark:text-gray-400">Capacidad Máxima</p>
              <p class="mt-1 text-base font-medium text-gray-900 dark:text-gray-100">
                {{ props.event?.event_max_capacity || '—' }}
              </p>
            </div>
            <div>
              <p class="text-sm text-gray-500 dark:text-gray-400">Ponente</p>
              <p class="mt-1 text-base font-medium text-gray-900 dark:text-gray-100">
                {{ props.event?.event_speaker_name || '—' }}
              </p>
            </div>
            <div>
              <p class="text-sm text-gray-500 dark:text-gray-400">Lugar</p>
              <p class="mt-1 text-base font-medium text-gray-900 dark:text-gray-100">
                {{ props.event?.venue?.venue_name || props.event?.event_location_name || '—' }}
              </p>
            </div>
            <div>
              <p class="text-sm text-gray-500 dark:text-gray-400">Meetup URL</p>
              <p class="mt-1 text-blue-600 dark:text-blue-400 hover:underline">
                <a v-if="props.event?.event_meetup_url" :href="props.event.event_meetup_url" target="_blank"
                  rel="noopener">
                  {{ props.event.event_meetup_url }}
                </a>
                <span v-else>—</span>
              </p>
            </div>
            <div>
              <p class="text-sm text-gray-500 dark:text-gray-400">Modalidad</p>
              <p class="mt-1 text-base font-medium text-gray-900 dark:text-gray-100">
                {{ props.event?.event_is_virtual ? 'Virtual' : 'Presencial' }}
              </p>
            </div>
          </div>
        </section>

        <!-- Estado y metadatos -->
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
                class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full text-xs font-semibold bg-pink-100 text-pink-700 dark:bg-pink-900/30 dark:text-pink-300">
                <span class="h-2.5 w-2.5 rounded-full bg-pink-500" />
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
                <p class="font-medium text-gray-900 dark:text-gray-100">{{ props.event?.id }}</p>
              </div>
              <div class="text-sm">
                <p class="text-gray-500 dark:text-gray-400">Creado</p>
                <p class="font-medium text-gray-900 dark:text-gray-100">
                  {{ props.event?.created_at ?? '—' }}
                </p>
              </div>
              <div class="text-sm">
                <p class="text-gray-500 dark:text-gray-400">Actualizado</p>
                <p class="font-medium text-gray-900 dark:text-gray-100">
                  {{ props.event?.updated_at ?? '—' }}
                </p>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
  </AppLayout>
</template>