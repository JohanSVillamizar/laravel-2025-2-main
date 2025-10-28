<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({ venue: Object });

// Form reactivo
const form = useForm({
  venue_name: props.venue.venue_name ?? '',
  venue_max_capacity: props.venue.venue_max_capacity ?? '',
  venue_address: props.venue.venue_address ?? '',
  venue_status: !!props.venue.venue_status, // asegurar boolean
});

// Texto de estado solo para mostrar
const statusText = computed(() => (form.venue_status ? 'Activo' : 'Inactivo'));

// Alternar con click/teclado
const toggleStatus = () => {
  form.venue_status = !form.venue_status;
};

const submit = () => {
  form.put(route('venues.update', props.venue.id));
};
</script>

<template>
  <Head title="Editar Lugar" />

  <AppLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-gray-200">
        Editar Lugar
      </h2>
    </template>

    <div class="py-12 bg-gradient-to-br from-indigo-50 via-white to-gray-100 dark:from-gray-900 dark:via-gray-950 dark:to-black min-h-screen">
      <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-900 shadow-xl sm:rounded-2xl p-8 border border-gray-200 dark:border-gray-800">

          <form @submit.prevent="submit" class="space-y-6">
            <!-- Campos existentes -->
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
              <input v-model="form.venue_name" type="text" class="w-full mt-1 px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100" />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Capacidad Máxima</label>
              <input v-model="form.venue_max_capacity" type="number" class="w-full mt-1 px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100" />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dirección</label>
              <textarea v-model="form.venue_address" class="w-full mt-1 px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100"></textarea>
            </div>

            <!-- Switch de estado -->
            <div class="flex items-center justify-between">
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estado</label>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ statusText }}</p>
              </div>

              <!-- Botón switch accesible -->
              <button
                type="button"
                @click="toggleStatus"
                @keydown.space.prevent="toggleStatus"
                @keydown.enter.prevent="toggleStatus"
                role="switch"
                :aria-checked="form.venue_status"
                :aria-label="`Cambiar estado a ${form.venue_status ? 'Inactivo' : 'Activo'}`"
                class="relative inline-flex h-7 w-12 items-center rounded-full transition focus:outline-none focus:ring-2 focus:ring-indigo-500"
                :class="form.venue_status ? 'bg-green-600' : 'bg-gray-300 dark:bg-gray-600'"
              >
                <span
                  class="inline-block h-6 w-6 transform rounded-full bg-white shadow transition"
                  :class="form.venue_status ? 'translate-x-6' : 'translate-x-1'"
                />
              </button>
            </div>

            <div class="flex justify-end gap-4">
              <Link :href="route('venues.index')" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200">
                Cancelar
              </Link>
              <button type="submit" class="px-4 py-2 rounded-lg bg-fuchsia-600 hover:bg-fuchsia-700 text-white" :disabled="form.processing">
                Guardar cambios
              </button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </AppLayout>
</template>