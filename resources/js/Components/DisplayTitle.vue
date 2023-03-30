<script setup>
import { PencilSquareIcon, TrashIcon, CircleStackIcon } from '@heroicons/vue/24/outline'
defineProps({
  id: { type: String, default: 'Select an item' }
});
</script>

<template>
  <div class="flex gap-6">
    <h5 class="text-2xl tracking-tight text-gray-900 dark:text-gray-200">
      {{ id }}
    </h5>
    <div class="flex items-center justify-center gap-3" v-if="id">
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
