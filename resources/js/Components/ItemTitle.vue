<script setup>
  import { ref } from 'vue';
  import { PencilSquareIcon, TrashIcon, CircleStackIcon, XCircleIcon } from '@heroicons/vue/24/outline'

  const confirmDelete = ref(false);

  defineProps({
    id: { type: String, default: '- Select an item -' },
  });
</script>

<template>
  <div class="flex gap-6">
    <h5 class="text-2xl tracking-tight text-gray-900 dark:text-gray-200">
      {{ id }}
    </h5>
    <div class="flex items-center justify-center gap-3" v-if="id">
      <button title="Edit">
        <PencilSquareIcon class="w-6 h-6 text-green-500 transition duration-75" />
      </button>
      <button
      title="Delete Item"
      @click="confirmDelete = true"
      v-show="! confirmDelete"
      >
        <TrashIcon class="w-6 h-6 transition duration-75 text-red-500 hover:text-red-300" />
      </button>
      <div
      v-show="confirmDelete"
      class="flex flex-nowrap"
      >
        <button
        title="Are you sure?"
        @click="confirmDelete = false"
        >
          <XCircleIcon class="w-6 h-6 text-blue-400 transition duration-75 dark:text-gray-400" />
        </button>
        <form @submit.prevent="router.delete(route('delete', { selectedConnection: $page.props.selectedConnection, key: id }))">
          <button
          title="Delete"
          type="submit"
          class="text-xs flex items-center mx-2 w-full text-base font-normal text-red-500 hover:text-red-300"
          >
            <TrashIcon class="w-6 h-6 transition duration-75" />
          </button>
        </form>
      </div>
      <button title="Export">
        <CircleStackIcon class="w-6 h-6 text-blue-400 transition duration-75 dark:text-blue-400" />
      </button>
    </div>
  </div>
</template>
