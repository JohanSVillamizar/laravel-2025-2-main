<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, computed, watch, onMounted, onBeforeUnmount } from 'vue';


const props = defineProps({
  events: Array,
  venues: Array,
  filters: Object,
});

const search = ref('');
const onlyUpcoming = ref(false);

// Filtrado local (puedes migrar a backend si usas paginación o colas grandes)
const filteredEvents = computed(() => {
  return props.events.filter(e => {
    const q = search.value.toLowerCase();
    const byName = (e.event_name ?? '').toLowerCase().includes(q);
    const byVenue = (e.venue?.venue_name ?? '').toLowerCase().includes(q);
    const bySpeaker = (e.event_speaker_name ?? '').toLowerCase().includes(q);

    let dateOk = true;
    if (onlyUpcoming.value) {
      dateOk = new Date(e.event_date) >= new Date();
    }
    return (byName || byVenue || bySpeaker) && dateOk;
  });
});

const showConfirm = ref(false);
const pendingId = ref(null);

const askDelete = (id) => {
  pendingId.value = id;
  showConfirm.value = true;
};

const doDelete = () => {
  if (!pendingId.value) return;
  router.delete(route('events.destroy', pendingId.value), {
    onFinish: () => {
      showConfirm.value = false;
      pendingId.value = null;
    },
  });
};

const confirmDelete = (id) => askDelete(id);

const modalShow = ref(false);
watch(showConfirm, v => (modalShow.value = v));
watch(modalShow, v => (showConfirm.value = v));

const onKey = (e) => {
  if (e.key === 'Escape' && modalShow.value) modalShow.value = false;
};
onMounted(() => window.addEventListener('keydown', onKey));
onBeforeUnmount(() => window.removeEventListener('keydown', onKey));

// Formatea fecha (puedes adaptarlo a tu región)
const fmtDate = d => {
  return new Date(d).toLocaleDateString('es-CO', {
    month: 'short', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit'
  });
};
</script>

<template>

  <Head title="Eventos" />

  <AppLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-gray-200">
        Eventos y Reservas
      </h2>
    </template>

    <div
      class="py-12 bg-gradient-to-br from-indigo-50 via-white to-gray-100 dark:from-gray-900 dark:via-gray-950 dark:to-black min-h-screen">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-900 shadow-xl sm:rounded-2xl p-8 border border-gray-200 dark:border-gray-800">

          <!-- Header y acciones -->
          <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
              Lista de eventos registrados
            </h1>
            <Link :href="route('events.create')"
              class="px-5 py-2.5 bg-pink-600 text-white rounded-xl hover:bg-pink-700 transition shadow-md">
            + Nuevo Evento
            </Link>
          </div>

          <!-- Filtros -->
          <div class="mb-6 flex flex-col sm:flex-row gap-4 items-center">
            <input v-model="search" type="text" placeholder="Buscar por nombre, speaker o venue..."
              class="w-full sm:w-1/3 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 focus:ring-2 focus:ring-pink-500 outline-none transition" />
            <label class="inline-flex items-center gap-2 cursor-pointer">
              <input type="checkbox" class="accent-pink-600 rounded" v-model="onlyUpcoming">
              <span class="text-sm text-gray-700 dark:text-gray-300">Solo próximos</span>
            </label>
          </div>

          <!-- Tabla -->
          <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
              <thead class="bg-pink-100 dark:bg-pink-800/30">
                <tr>
                  <th class="px-6 py-3 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">#</th>
                  <th class="px-6 py-3 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Evento</th>
                  <th class="px-6 py-3 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Fecha</th>
                  <th class="px-6 py-3 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Ponente</th>
                  <th class="px-6 py-3 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Lugar</th>
                  <th class="px-6 py-3 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Modalidad</th>
                  <th class="px-6 py-3 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase text-right">
                    Acciones
                  </th>
                </tr>
              </thead>

              <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                <tr v-for="e in filteredEvents" :key="e.id"
                  class="hover:bg-pink-50 dark:hover:bg-pink-900/20 transition">
                  <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ e.id }}</td>
                  <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">
                    <Link :href="route('events.show', e.id)" class="hover:underline text-pink-700 dark:text-pink-300">
                    {{ e.event_name }}
                    </Link>
                  </td>
                  <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ fmtDate(e.event_date) }}</td>
                  <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ e.event_speaker_name || '—' }}</td>
                  <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ e.venue?.venue_name || e.event_location_name
                    ||
                    '—' }}</td>
                  <td class="px-6 py-4">
                    <span class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full text-xs font-semibold"
                      :class="e.event_is_virtual ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300' : 'bg-fuchsia-100 text-fuchsia-700 dark:bg-fuchsia-900/30 dark:text-fuchsia-300'">
                      <span class="h-2.5 w-2.5 rounded-full"
                        :class="e.event_is_virtual ? 'bg-indigo-500' : 'bg-fuchsia-500'" />
                      {{ e.event_is_virtual ? 'Virtual' : 'Presencial' }}
                    </span>
                  </td>
                  <td class="px-6 py-4 text-right flex justify-end items-center gap-3">
                    <Link :href="route('events.show', e.id)"
                      class="p-2 rounded-lg bg-gray-100 dark:bg-gray-800/40 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700 transition"
                      title="Ver detalle">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                      <path
                        d="M12 5c-4.5 0-8.4 2.6-10 7 1.6 4.4 5.5 7 10 7s8.4-2.6 10-7c-1.6-4.4-5.5-7-10-7zm0 12a5 5 0 110-10 5 5 0 010 10zm0-2.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                    </svg>
                    </Link>
                    <Link :href="route('events.edit', e.id)"
                      class="p-2 rounded-lg bg-pink-100 dark:bg-pink-800/40 text-pink-600 dark:text-pink-300 hover:bg-pink-200 dark:hover:bg-pink-700 transition"
                      title="Editar">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                      stroke="currentColor" class="w-5 h-5">
                      <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.862 4.487l1.688 1.687a1.5 1.5 0 010 2.121l-8.486 8.486a1.5 1.5 0 01-.53.35l-3.182 1.061a.75.75 0 01-.949-.95l1.061-3.182a1.5 1.5 0 01.35-.53l8.486-8.486a1.5 1.5 0 012.121 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 19.5h-6" />
                    </svg>
                    </Link>
                    <button @click="confirmDelete(e.id)"
                      class="p-2 rounded-lg bg-red-100 dark:bg-red-800/40 text-red-600 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-700 transition"
                      title="Eliminar">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                      </svg>
                    </button>
                  </td>
                </tr>
                <tr v-if="filteredEvents.length === 0">
                  <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                    No se encontraron resultados.
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- Modal de confirmación (inline) -->
          <transition name="fade">
            <div v-if="modalShow" class="fixed inset-0 z-50 flex items-center justify-center" role="dialog"
              aria-modal="true">
              <div class="absolute inset-0 bg-black/50" @click="modalShow = false" />
              <div
                class="relative w-full max-w-md mx-4 rounded-xl shadow-2xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800">
                <div class="px-6 py-5">
                  <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                    Confirmar eliminación
                  </h3>
                  <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                    Esta acción eliminará el evento #{{ pendingId ?? '' }}. ¿Deseas continuar?
                  </p>
                </div>
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/40 rounded-b-xl flex justify-end gap-3">
                  <button type="button" @click="modalShow = false"
                    class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200">
                    Cancelar
                  </button>
                  <button type="button" @click="doDelete"
                    class="px-4 py-2 rounded-lg text-white bg-red-600 hover:bg-red-700">
                    Eliminar
                  </button>
                </div>
              </div>
            </div>
          </transition>
        </div>
      </div>
    </div>
  </AppLayout>
</template>