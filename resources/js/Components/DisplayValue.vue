<script setup>
  defineProps({
    item: {
      type: Object,
      default: {
        type: '',
        value: {},
      }
    }
  });
</script>

<template>
  <div class="bg-gray-50 dark:bg-gray-800">
    <table class="border-collapse w-full border border-slate-400 dark:border-slate-500 bg-white dark:bg-slate-800 text-sm shadow-sm">
      <thead>
        <tr>
          <th
            v-if="item.type != 'String'"
            class="w-1/2 border border-slate-300 dark:border-slate-600 font-semibold p-2 text-slate-700 dark:text-slate-200"
            v-text="item.type == 'ZSet' ? 'Score' : 'Key'"
          ></th>
          <th class="w-1/2 border border-slate-300 dark:border-slate-600 font-semibold p-2 text-slate-700 dark:text-slate-200">
            Value
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-if="item.type != 'String'" v-for="(val, key) in item.value">
          <td class="border border-slate-300 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">{{ val.score || key }}</td>
          <td class="border border-slate-300 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">{{ val.value || val }}</td>
        </tr>
        <tr v-else>
          <td class="border border-slate-300 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">{{ item.value }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
