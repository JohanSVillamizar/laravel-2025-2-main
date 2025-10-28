<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
  event: Object,
  venues: Array,
});

const toDatetimeLocal = (date) => {
  if (!date) return '';
  const dt = new Date(date);
  dt.setMinutes(dt.getMinutes() - dt.getTimezoneOffset());
  return dt.toISOString().slice(0,16);
};


const form = useForm({
  event_name: props.event.event_name || '',
  fk_venue_event: props.event.fk_venue_event || null,
  event_date: toDatetimeLocal(props.event.event_date) || '',
  event_max_capacity: props.event.event_max_capacity || null,
  event_speaker_name: props.event.event_speaker_name || '',
  event_location_name: props.event.event_location_name || '',
  event_meetup_url: props.event.event_meetup_url || '',
  event_is_virtual: props.event.event_is_virtual || false,
});

const submit = () => {
  form.put(route('events.update', props.event.id));
};
</script>

<template>
  <Head title="Editar Evento" />
  <AppLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Editar evento
      </h2>
    </template>

    <form @submit.prevent="submit" class="max-w-3xl mx-auto p-6 bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow space-y-6">
      <div>
        <label for="event_name" class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Nombre del evento</label>
        <input id="event_name" v-model="form.event_name" type="text" class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100" />
        <span v-if="form.errors.event_name" class="text-red-500 text-sm">{{ form.errors.event_name }}</span>
      </div>

      <div>
        <label for="fk_venue_event" class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Ubicación</label>
        <select id="fk_venue_event" v-model="form.fk_venue_event" class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
          <option :value="null" disabled>Seleccione una ubicación</option>
          <option v-for="venue in venues" :key="venue.id" :value="venue.id">{{ venue.venue_name }}</option>
        </select>
        <span v-if="form.errors.fk_venue_event" class="text-red-500 text-sm">{{ form.errors.fk_venue_event }}</span>
      </div>

      <div>
        <label for="event_date" class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Fecha</label>
        <input id="event_date" v-model="form.event_date" type="datetime-local" class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100" />
        <span v-if="form.errors.event_date" class="text-red-500 text-sm">{{ form.errors.event_date }}</span>
      </div>

      <div>
        <label for="event_max_capacity" class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Capacidad máxima</label>
        <input id="event_max_capacity" v-model="form.event_max_capacity" type="number" min="1" class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100" />
        <span v-if="form.errors.event_max_capacity" class="text-red-500 text-sm">{{ form.errors.event_max_capacity }}</span>
      </div>

      <div>
        <label for="event_speaker_name" class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Nombre del ponente</label>
        <input id="event_speaker_name" v-model="form.event_speaker_name" type="text" class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100" />
        <span v-if="form.errors.event_speaker_name" class="text-red-500 text-sm">{{ form.errors.event_speaker_name }}</span>
      </div>

      <div>
        <label for="event_location_name" class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Lugar del evento</label>
        <input id="event_location_name" v-model="form.event_location_name" type="text" class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100" />
        <span v-if="form.errors.event_location_name" class="text-red-500 text-sm">{{ form.errors.event_location_name }}</span>
      </div>

      <div>
        <label for="event_meetup_url" class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">URL Meetup</label>
        <input id="event_meetup_url" v-model="form.event_meetup_url" type="url" class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100" />
        <span v-if="form.errors.event_meetup_url" class="text-red-500 text-sm">{{ form.errors.event_meetup_url }}</span>
      </div>

      <div class="flex items-center gap-3">
        <label for="event_is_virtual" class="font-semibold text-gray-700 dark:text-gray-300">Virtual</label>
        <input id="event_is_virtual" type="checkbox" v-model="form.event_is_virtual" class="accent-pink-600 rounded" />
        <span v-if="form.errors.event_is_virtual" class="text-red-500 text-sm">{{ form.errors.event_is_virtual }}</span>
      </div>

      <div class="flex justify-end gap-4 pt-6">
        <Link :href="route('events.index')" class="btn cancel">Cancelar</Link>
        <button type="submit" class="btn primary" :disabled="form.processing">
          Guardar
        </button>
      </div>
    </form>
  </AppLayout>
</template>

<style scoped>
.btn.primary {
  @apply px-4 py-2 rounded bg-pink-600 hover:bg-pink-700 text-white transition;
}
.btn.cancel {
  @apply px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-900 transition;
}
</style>