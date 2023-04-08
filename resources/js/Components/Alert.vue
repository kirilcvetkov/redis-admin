<script setup>
  import { ExclamationCircleIcon } from '@heroicons/vue/24/outline'
  const props = defineProps({
    status: { type: Boolean, default: true },
  });
</script>

<template>
  <div>
    <div
    class="flex p-4 mb-4 text-sm rounded-lg"
    :class="{
      'bg-gray-800 text-green-400': status,
      'bg-gray-800 text-red-400': ! status,
    }"
    role="alert">
      <ExclamationCircleIcon class="flex-shrink-0 inline w-5 h-5 mr-3" />
      <div>
        <span class="font-bold mr-2">{{ status ? 'Success' : 'Error' }}</span>
        <slot />
      </div>
    </div>
  </div>
</template>
