<script setup>
import { onMounted, onBeforeUnmount, ref } from 'vue';

const props = defineProps({
  title: { type: String, default: 'Confirmar acción' },
  message: { type: String, default: '¿Deseas continuar?' },
  confirmText: { type: String, default: 'Eliminar' },
  cancelText: { type: String, default: 'Cancelar' },
  danger: { type: Boolean, default: true },
  show: { type: Boolean, default: false },
});
const emit = defineEmits(['confirm', 'cancel', 'update:show']);

const localShow = ref(props.show);
watch(() => props.show, v => (localShow.value = v));
watch(localShow, v => emit('update:show', v));

// Cerrar con ESC
const onKey = (e) => {
  if (e.key === 'Escape' && localShow.value) localShow.value = false;
};
onMounted(() => window.addEventListener('keydown', onKey));
onBeforeUnmount(() => window.removeEventListener('keydown', onKey));

const confirm = () => emit('confirm');
const cancel = () => {
  localShow.value = false;
  emit('cancel');
};
</script>

<template>
  <transition name="fade">
    <div
      v-if="localShow"
      class="fixed inset-0 z-50 flex items-center justify-center"
      aria-modal="true"
      role="dialog"
    >
      <!-- Backdrop -->
      <div class="absolute inset-0 bg-black/50" @click="cancel" />

      <!-- Dialog -->
      <div class="relative w-full max-w-md mx-4 rounded-xl shadow-2xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800">
        <div class="px-6 py-5">
          <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
            {{ title }}
          </h3>
          <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
            {{ message }}
          </p>
        </div>

        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/40 rounded-b-xl flex justify-end gap-3">
          <button
            type="button"
            @click="cancel"
            class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200"
          >
            {{ cancelText }}
          </button>

          <button
            type="button"
            @click="confirm"
            class="px-4 py-2 rounded-lg text-white"
            :class="danger ? 'bg-red-600 hover:bg-red-700' : 'bg-indigo-600 hover:bg-indigo-700'"
          >
            {{ confirmText }}
          </button>
        </div>
      </div>
    </div>
  </transition>
</template>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: opacity .15s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
</style>
