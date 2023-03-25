<script setup>
import { Link } from '@inertiajs/vue3';
import { FolderIcon, DocumentIcon, ChevronDownIcon, ChevronRightIcon } from '@heroicons/vue/24/outline'
import TreeList from "@/components/TreeList.vue";

defineProps({
  name: String,
  count: { type: Number, default: -1 },
  itemKey: String,
  children: Object,
  showChildren: { type: Boolean, default: false },
});
</script>

<template>
  <li>
    <button
      v-if="children"
      type="button"
      class="text-xs flex items-center text-left w-full text-base font-normal text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
      aria-controls="dropdown-pages"
      data-collapse-toggle="dropdown-pages"
      @click="showChildren = ! showChildren"
    >
      <ChevronRightIcon
        v-if="! showChildren"
        class="w-4 h-4 mr-1 text-gray-400 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
      />

      <ChevronDownIcon
        v-if="showChildren"
        class="w-4 h-4 mr-1 text-gray-400 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
      />

      <FolderIcon
        class="w-5 h-5 mr-1 text-blue-400 transition duration-75 dark:text-blue-400 group-hover:text-blue-400 dark:group-hover:text-white"
      />

      <span
        class="flex-1 whitespace-nowrap"
      >{{ name }}</span>
    </button>

    <Link
      :href="route('get', { selectedConnection: $page.props.selectedConnection, key: itemKey })"
      :only="['item']"
      :active="route().current('admin')"
      v-if="! children"
    >
      <button
        v-if="! children"
        role="link"
        type="button"
        class="text-xs flex items-center pl-2 w-full text-base font-normal text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
        aria-controls="dropdown-pages"
        data-collapse-toggle="dropdown-pages"
      >
        <DocumentIcon
          @click="showChildren = ! showChildren"
          class="w-4 h-4 text-yellow-400 transition duration-75 dark:text-yellow-400 group-hover:text-yellow-900 dark:group-hover:text-white mr-1"
        />
        <span class="flex-1 text-left whitespace-nowrap">{{ name }} {{ count === -1 ? '' : '(' + count + ')' }}</span>
      </button>
    </Link>

    <TreeList v-if="children && showChildren" class="ml-2" :tree="children" />
  </li>
</template>
