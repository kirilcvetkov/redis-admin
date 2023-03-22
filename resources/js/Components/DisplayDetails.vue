<script setup>
  defineProps({
    item: {
      type: Object,
      default: {
        type: 'default',
        ttl: -1,
        encoding: 'default',
        refcount: 0,
      }
    },
  });
</script>

<template>
  <table class="mb-8 border-collapse w-full border border-slate-400 dark:border-slate-500 bg-white dark:bg-slate-800 text-sm shadow-sm">
    <thead>
      <tr>
        <th class="w-1/4 border border-slate-300 dark:border-slate-600 font-semibold p-2 text-slate-700 dark:text-slate-200">Type</th>
        <th class="w-1/4 border border-slate-300 dark:border-slate-600 font-semibold p-2 text-slate-700 dark:text-slate-200">TTL</th>
        <th class="w-1/4 border border-slate-300 dark:border-slate-600 font-semibold p-2 text-slate-700 dark:text-slate-200">Encoding</th>
        <th class="w-1/4 border border-slate-300 dark:border-slate-600 font-semibold p-2 text-slate-700 dark:text-slate-200">Count</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="border border-slate-300 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">{{ item.type }}</td>
        <td class="border border-slate-300 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">{{ item.ttl }}</td>
        <td class="border border-slate-300 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">{{ item.encoding }}</td>
        <td class="border border-slate-300 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">{{ item.refcount }}</td>
      </tr>
    </tbody>
  </table>
</template>
