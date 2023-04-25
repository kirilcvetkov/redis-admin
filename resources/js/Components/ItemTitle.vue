<script setup>
import { ref } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import { PencilSquareIcon, ArrowRightCircleIcon, TrashIcon, CircleStackIcon, XCircleIcon } from '@heroicons/vue/24/outline'

const confirmDelete = ref(false);
const showEdit = ref(false);

const props = defineProps({
  id: { type: String, default: '- Select an item -' },
});

const newKeyName = ref(props.id);
</script>

<template>
  <div class="flex gap-6">
    <h5
    v-show="! showEdit"
    id="label"
    class="text-2xl tracking-tight text-gray-200"
    >
      {{ id }}
    </h5>
    <form
    v-show="showEdit"
    @submit.prevent="router.post(route('store', { selectedConnection: $page.props.selectedConnection, key: id, newKey: newKeyName }))"
    class="flex"
    >
      <input
      v-model="newKeyName"
      type="text"
      class="w-96 bg-gray-800 rounded-lg block p-2.5 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500"
      required>
      <button
      title="Save"
      type="submit"
      class="mx-2 text-base font-normal text-green-500 hover:text-green-300"
      >
        <ArrowRightCircleIcon
        class="w-6 h-6 transition duration-75"
        />
      </button>
    </form>
    <div class="flex items-center justify-center gap-3" v-if="id">
      <button
      title="Are you sure?"
      v-show="showEdit"
      @click="showEdit = false"
      >
        <XCircleIcon class="w-6 h-6 text-blue-400 transition duration-75 dark:text-gray-400" />
      </button>
      <button
      v-show="! showEdit"
      @click="showEdit = ! showEdit"
      title="Edit Key Name"
      >
        <PencilSquareIcon
        class="w-6 h-6 text-green-500 transition duration-75"
        />
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
