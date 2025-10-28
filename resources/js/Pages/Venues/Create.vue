<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
  venue_name: '',
  venue_max_capacity: '',
  venue_address: '',
  venue_status: true, // por defecto Activo
});

const submit = () => {
  form.post(route('venues.store'));
};
</script>

<template>
  <Head title="Nuevo Lugar" />
  <AppLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-gray-200">Nuevo Lugar</h2>
    </template>

    <div class="py-12 bg-gradient-to-br from-indigo-50 via-white to-gray-100 dark:from-gray-900 dark:via-gray-950 dark:to-black min-h-screen">
      <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-900 shadow-xl sm:rounded-2xl p-8 border border-gray-200 dark:border-gray-800">
          <form @submit.prevent="submit" class="space-y-6">
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

            <!-- Toggle de estado -->
            <div class="flex items-center justify-between">
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estado</label>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                  {{ form.venue_status ? 'Activo' : 'Inactivo' }}
                </p>
              </div>
              <button
                type="button"
                @click="form.venue_status = !form.venue_status"
                class="relative inline-flex h-6 w-11 items-center rounded-full transition focus:outline-none"
                :class="form.venue_status ? 'bg-green-600' : 'bg-gray-300 dark:bg-gray-600'"
              >
                <span
                  class="inline-block h-5 w-5 transform rounded-full bg-white shadow transition"
                  :class="form.venue_status ? 'translate-x-5' : 'translate-x-1'"
                />
              </button>
            </div>

            <div class="flex justify-end gap-4">
              <Link :href="route('venues.index')" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200">
                Cancelar
              </Link>
              <button type="submit" class="px-4 py-2 rounded-lg bg-fuchsia-600 hover:bg-fuchsia-700 text-white">
                Guardar
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>