<script setup>
import { Link } from '@inertiajs/vue3';
import { FolderIcon, DocumentIcon, ChevronDownIcon, ChevronRightIcon, TrashIcon } from '@heroicons/vue/24/outline'
import TreeList from "@/components/TreeList.vue";

defineProps({
  name: String,
  count: { type: Number, default: -1 },
  itemKey: String,
  children: Object,
  show: { type: Boolean, default: false },
  croute: String,
});
</script>

<template>
  <li class="whitespace-nowrap">
    <div class="flex items-center justify-between w-full hover:bg-gray-700">
      <button
        v-if="children"
        type="button"
        class="text-xs flex items-center text-left text-base font-normal text-white"
        aria-controls="dropdown-pages"
        data-collapse-toggle="dropdown-pages"
        @click="show = ! show"
      >
        <ChevronRightIcon
          v-if="! show"
          class="w-4 h-4 mr-1 transition duration-75 text-gray-400"
        />
        <ChevronDownIcon
          v-else
          class="w-4 h-4 mr-1 transition duration-75 text-gray-400"
        />
        <FolderIcon
          class="w-5 h-5 mr-1 transition duration-75 text-blue-400"
        />
        <span class="flex-1 whitespace-nowrap">
          {{ name }}
        </span>
      </button>

      <Link
        v-else
        :only="['item']"
        :href="route('show', { selectedConnection: $page.props.selectedConnection, key: itemKey })"
        class="text-xs flex items-center pl-2 text-base font-normal text-white"
      >
        <DocumentIcon
          @click="show = ! show"
          class="w-4 h-4 text-yellow-400 transition duration-75 mr-1"
        />
        <span class="flex-1 text-left whitespace-nowrap">
          {{ name }}
          <span
            v-if="count > -1"
            class="bg-gray-700 text-gray-300 text-xs font-medium ml-2 px-1 py-0.5 rounded">
            {{ count }}
          </span>
        </span>
      </Link>

      <button
        type="button"
        class="text-xs text-base font-normal text-white"
        aria-controls="dropdown-pages"
        data-collapse-toggle="dropdown-pages"
        @click="show = ! show"
      >
        <TrashIcon class="w-3 h-3 text-red-500" />
      </button>
    </div>

    <Transition
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      enter-active-class="transition duration-300"
      leave-active-class="transition duration-100"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <TreeList v-if="children && show" class="ml-2" :tree="children" />
    </Transition>
  </li>
</template>
