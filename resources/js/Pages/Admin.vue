<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import TreePanel from "@/components/TreePanel.vue";
import DisplayPanel from "@/components/DisplayPanel.vue";
</script>

<template>
  <Head title="Admin" />

  <AdminLayout>
    <TreePanel />
    <DisplayPanel />

    <!-- <template #navbar>
      <ul class="flex flex-wrap flex-col p-4 mt-4 rounded-lg md:flex-row md:mt-0 md:text-sm md:font-medium">
        <li v-for="(count, letter) in $page.props.alphabet">
          <Link
            :href="route('list', {letter: letter})" :active="route().current('list')"
            class="mr-1 px-3 py-2 text-xs font-medium text-center text-white rounded-lg focus:ring-4 focus:outline-none"
            :title="'Count: ' + count"
            :class="{
              'bg-blue-700 hover:bg-blue-800 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800': count > 0,
              'hidden xl:block bg-gray-700 hover:bg-gray-800 focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800': count == 0,
            }"
            as="button"
            :disabled="count == 0"
            >
            {{ letter }}
          </Link>
        </li>
      </ul>
    </template> -->
  </AdminLayout>
</template>
