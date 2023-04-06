<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
defineProps({
  tab: { type: String, default: 'default' }
});
</script>
<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h5 class="text-2xl tracking-tight text-gray-900 dark:text-gray-200">
        Dashboard
      </h5>
    </template>

    <div class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
      <div class="sm:hidden">
        <label for="tabs" class="sr-only">Select tab</label>
        <select id="tabs" class="bg-gray-50 border-0 border-b border-gray-200 text-gray-900 text-sm rounded-t-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
          <option>Server Stats</option>
          <option>Slow Log ({{ $page.props.slowLog.len }})</option>
        </select>
      </div>
      <ul class="hidden text-sm font-medium text-center text-gray-500 divide-x divide-gray-200 rounded-lg sm:flex dark:divide-gray-600 dark:text-gray-400" id="fullWidthTab" data-tabs-toggle="#fullWidthTabContent" role="tablist">
        <li class="w-full">
          <button
            id="stats-tab" data-tabs-target="#stats" type="button" role="tab" aria-controls="stats" aria-selected="true"
            class="inline-block w-full p-4 rounded-tl-lg hover:bg-gray-100 focus:outline-none"
            @click="tab = 'default'"
            :class="{
              'bg-gray-600 text-blue-400 hover:bg-gray-500': tab == 'default',
              'bg-gray-700 hover:bg-gray-500': tab != 'default',
            }"
          >Server Stats</button>
        </li>
        <li class="w-full">
          <button
            id="slow-tab" data-tabs-target="#slow" type="button" role="tab" aria-controls="slow" aria-selected="false"
            class="inline-block w-full p-4 hover:bg-gray-100 focus:outline-none"
            @click="tab = 'slow'"
            :class="{
              'bg-gray-600 text-blue-400 hover:bg-gray-500': tab == 'slow',
              'bg-gray-700 hover:bg-gray-500': tab != 'slow',
            }"
          >
            Slow Logs
            <span class="inline-flex items-center justify-center w-4 h-4 ml-1 text-xs font-semibold text-blue-800 bg-blue-200 rounded-full">
              {{ $page.props.slowLog.len }}
            </span>
          </button>
        </li>
      </ul>
      <div id="fullWidthTabContent" class="border-t border-gray-200 dark:border-gray-600">
        <div v-show="tab == 'default'" class="p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="stats" role="tabpanel" aria-labelledby="stats-tab">
          <dl class="grid max-w-screen-xl grid-cols-1 gap-8 p-4 mx-auto text-gray-900 sm:grid-cols-2 xl:grid-cols-3 dark:text-white sm:p-8">
            <div
              v-for="value in $page.props.stats"
              class="flex flex-col items-center justify-center"
            >
              <dt class="text-gray-500 mt-2 text-4xl font-extrabold">{{ value.value }}</dt>
              <dd>{{ value.name }}</dd>
            </div>
          </dl>
        </div>
        <div v-show="tab == 'slow'" class="p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="slow" role="tabpanel" aria-labelledby="slow-tab">
          <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
              <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                  <th scope="col" class="px-6 py-3">ID</th>
                  <th scope="col" class="px-6 py-3">Timestamp</th>
                  <th scope="col" class="px-6 py-3">Execution time</th>
                  <th scope="col" class="px-6 py-3">Command / Arguments</th>
                  <th scope="col" class="px-6 py-3">CLIENT IP:Port</th>
                  <th scope="col" class="px-6 py-3">CLIENT</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="log in $page.props.slowLog.list"
                  class="bg-white border-b dark:bg-gray-900 dark:border-gray-700"
                >
                  <th scope="row" class="px-6 py-4 font-medium text-gray-200 whitespace-nowrap">{{ log[0] }}</th>
                  <td class="px-6 py-4" :title="log[1]">{{ log['humanTs'] }}</td>
                  <td class="px-6 py-4" :title="log[2]">{{ log['execTime'] }}</td>
                  <td class="px-6 py-4">{{ log[3] }}</td>
                  <td class="px-6 py-4">{{ log[4] }}</td>
                  <td class="px-6 py-4">{{ log[5] }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
