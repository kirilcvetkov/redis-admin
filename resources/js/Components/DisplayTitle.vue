<script setup>
import { PencilSquareIcon, TrashIcon, CircleStackIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
  id: String,
});
</script>

<template>
  <div class="flex items-center justify-center mb-8 rounded bg-gray-50 dark:bg-gray-800 gap-6">
    <h5 class="text-2xl tracking-tight text-gray-900 dark:text-gray-200">
      {{ id }}
    </h5>
    <div class="flex items-center justify-center gap-3">
      <button title="Edit">
        <PencilSquareIcon class="w-6 h-6 text-green-400 transition duration-75 dark:text-green-400" />
      </button>
      <button title="Delete">
        <TrashIcon class="w-6 h-6 text-red-400 transition duration-75 dark:text-red-400" />
      </button>
      <button title="Export">
        <CircleStackIcon class="w-6 h-6 text-blue-400 transition duration-75 dark:text-blue-400" />
      </button>
    </div>
  </div>
</template>
