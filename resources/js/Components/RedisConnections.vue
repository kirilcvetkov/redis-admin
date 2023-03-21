<script setup>
import { Link } from '@inertiajs/vue3';
import { CheckCircleIcon } from '@heroicons/vue/24/outline'

defineProps({
  connections: Object,
  selected: {
    type: String,
    default: 'default',
  },
});
</script>

<template>
  <table class="w-full dark:text-gray-300 text-sm shadow-sm">
    <thead>
      <tr class="border-b border-slate-300 dark:border-slate-600 text-left">
        <th class="w-0"></th>
        <th class="p-2">Name</th>
        <th class="p-2">URL</th>
        <th class="p-2">Host</th>
        <th class="p-2">Port</th>
        <th class="p-2">Username</th>
        <th class="p-2">Database</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(connection, name) in connections">
        <td class="p-4 text-slate-500 dark:text-slate-400"
          @click="selected = name"
        >
          <CheckCircleIcon
            class="w-4"
            :class="{
              'text-green-600': selected == name,
              'text-gray-600': selected != name,
            }"
          />
        </td>
        <td class="p-4 text-slate-500 dark:text-slate-400">
          {{ name }}
        </td>
        <td class="p-4 text-slate-500 dark:text-slate-400">
          {{ connection.url }}
        </td>
        <td class="p-4 text-slate-500 dark:text-slate-400">
          {{ connection.host }}
        </td>
        <td class="p-4 text-slate-500 dark:text-slate-400">
          {{ connection.port }}
        </td>
        <td class="p-4 text-slate-500 dark:text-slate-400">
          {{ connection.username }}
        </td>
        <td class="p-4 text-slate-500 dark:text-slate-400">
          {{ connection.database }}
        </td>
        <td>
          <Link :href="route('connect', {name: name})">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
            </svg>
          </Link>
        </td>
      </tr>
    </tbody>
  </table>
</template>
