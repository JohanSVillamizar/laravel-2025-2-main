<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, computed, watch, onMounted, onBeforeUnmount } from 'vue';

const props = defineProps({
  venues: Array,
});

const search = ref('');

// Filtro por nombre, dirección o estado (activo/inactivo)
const filteredVenues = computed(() =>
  props.venues.filter(v => {
    const q = (search.value ?? '').toLowerCase();
    const name = (v.venue_name ?? '').toLowerCase();
    const addr = (v.venue_address ?? '').toLowerCase();
    const statusText = (!!v.venue_status ? 'activo' : 'inactivo');
    return name.includes(q) || addr.includes(q) || statusText.includes(q);
  })
);

// Modal confirmación
const showConfirm = ref(false);
const pendingId = ref(null);

const askDelete = (id) => {
  pendingId.value = id;
  showConfirm.value = true;
};

const doDelete = () => {
  if (!pendingId.value) return;
  router.delete(route('venues.destroy', pendingId.value), {
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
</script>

<template>
  <Head title="Lugares o Ubicaciones" />

  <AppLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-gray-200">
        Lugares o Ubicaciones
      </h2>
    </template>

    <div
      class="py-12 bg-gradient-to-br from-indigo-50 via-white to-gray-100 dark:from-gray-900 dark:via-gray-950 dark:to-black min-h-screen"
    >
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div
          class="bg-white dark:bg-gray-900 shadow-xl sm:rounded-2xl p-8 border border-gray-200 dark:border-gray-800"
        >
          <!-- Header -->
          <div
            class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4"
          >
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
              Lista de lugares registrados
            </h1>
            <Link
              :href="route('venues.create')"
              class="px-5 py-2.5 bg-fuchsia-600 text-white rounded-xl hover:bg-fuchsia-700 transition shadow-md"
            >
              + Nuevo Lugar
            </Link>
          </div>

          <!-- Filtro -->
          <div class="mb-6">
            <input
              v-model="search"
              type="text"
              placeholder="Buscar por nombre, dirección o estado..."
              class="w-full sm:w-1/2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 focus:ring-2 focus:ring-fuchsia-600 outline-none transition"
            />
          </div>

          <!-- Tabla -->
          <div
            class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700"
          >
            <table
              class="min-w-full divide-y divide-gray-200 dark:divide-gray-700"
            >
              <thead class="bg-fuchsia-100 dark:bg-fuchsia-800/30">
                <tr>
                  <th
                    class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase"
                  >
                    #
                  </th>
                  <th
                    class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase"
                  >
                    Nombre
                  </th>
                  <th
                    class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase"
                  >
                    Capacidad
                  </th>
                  <th
                    class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase"
                  >
                    Dirección
                  </th>
                  <th
                    class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase"
                  >
                    Estado
                  </th>
                  <th
                    class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase text-right"
                  >
                    Acciones
                  </th>
                </tr>
              </thead>

              <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                <tr
                  v-for="venue in filteredVenues"
                  :key="venue.id"
                  class="hover:bg-fuchsia-50 dark:hover:bg-fuchsia-900/20 transition"
                >
                  <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                    {{ venue.id }}
                  </td>

                  <!-- Nombre -> Show -->
                  <td class="px-6 py-4 font-medium">
                    <Link
                      :href="route('venues.show', venue.id)"
                      class="text-fuchsia-600 hover:underline dark:text-fuchsia-300"
                    >
                      {{ venue.venue_name }}
                    </Link>
                  </td>

                  <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                    {{ venue.venue_max_capacity }}
                  </td>
                  <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                    {{ venue.venue_address }}
                  </td>

                  <!-- Estado -->
                  <td class="px-6 py-4">
                    <span
                      class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full text-xs font-semibold"
                      :class="
                        !!venue.venue_status
                          ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300'
                          : 'bg-fuchsia-100 text-fuchsia-700 dark:bg-fuchsia-900/30 dark:text-fuchsia-300'
                      "
                    >
                      <span
                        class="h-2.5 w-2.5 rounded-full"
                        :class="!!venue.venue_status ? 'bg-green-500' : 'bg-fuchsia-500'"
                      />
                      {{ !!venue.venue_status ? 'Activo' : 'Inactivo' }}
                    </span>
                  </td>

                  <!-- Acciones -->
                  <td
                    class="px-6 py-4 text-right flex justify-end items-center gap-3"
                  >
                    <!-- Ver -->
                    <Link
                      :href="route('venues.show', venue.id)"
                      class="p-2 rounded-lg bg-gray-100 dark:bg-gray-800/40 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700 transition"
                      title="Ver detalle"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        class="w-5 h-5"
                      >
                        <path
                          d="M12 5c-4.5 0-8.4 2.6-10 7 1.6 4.4 5.5 7 10 7s8.4-2.6 10-7c-1.6-4.4-5.5-7-10-7zm0 12a5 5 0 110-10 5 5 0 010 10zm0-2.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z"
                        />
                      </svg>
                    </Link>

                    <!-- Editar -->
                    <Link
                      :href="route('venues.edit', venue.id)"
                      class="p-2 rounded-lg bg-fuchsia-100 dark:bg-fuchsia-800/40 text-fuchsia-600 dark:text-fuchsia-300 hover:bg-fuchsia-200 dark:hover:bg-fuchsia-700 transition"
                      title="Editar"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="w-5 h-5"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M16.862 4.487l1.688 1.687a1.5 1.5 0 010 2.121l-8.486 8.486a1.5 1.5 0 01-.53.35l-3.182 1.061a.75.75 0 01-.949-.95l1.061-3.182a1.5 1.5 0 01.35-.53l8.486-8.486a1.5 1.5 0 012.121 0z"
                        />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 19.5h-6" />
                      </svg>
                    </Link>

                    <!-- Eliminar -->
                    <button
                      @click="confirmDelete(venue.id)"
                      class="p-2 rounded-lg bg-red-100 dark:bg-red-800/40 text-red-600 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-700 transition"
                      title="Eliminar"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="w-5 h-5"
                      >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                      </svg>
                    </button>
                  </td>
                </tr>

                <tr v-if="filteredVenues.length === 0">
                  <td
                    colspan="6"
                    class="px-6 py-4 text-center text-gray-500 dark:text-gray-400"
                  >
                    No se encontraron resultados.
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Modal de confirmación (inline) -->
          <transition name="fade">
            <div
              v-if="modalShow"
              class="fixed inset-0 z-50 flex items-center justify-center"
              role="dialog"
              aria-modal="true"
            >
              <div class="absolute inset-0 bg-black/50" @click="modalShow = false" />
              <div
                class="relative w-full max-w-md mx-4 rounded-xl shadow-2xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800"
              >
                <div class="px-6 py-5">
                  <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                    Confirmar eliminación
                  </h3>
                  <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                    Esta acción eliminará el lugar #{{ pendingId ?? '' }}. ¿Deseas continuar?
                  </p>
                </div>
                <div
                  class="px-6 py-4 bg-gray-50 dark:bg-gray-800/40 rounded-b-xl flex justify-end gap-3"
                >
                  <button
                    type="button"
                    @click="modalShow = false"
                    class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200"
                  >
                    Cancelar
                  </button>
                  <button
                    type="button"
                    @click="doDelete"
                    class="px-4 py-2 rounded-lg text-white bg-red-600 hover:bg-red-700"
                  >
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

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.15s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>