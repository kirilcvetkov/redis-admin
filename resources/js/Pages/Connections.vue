<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { CheckCircleIcon } from '@heroicons/vue/24/outline'
</script>

<template>
  <AppLayout title="Admin">
    <template #header>
      <div class="flex gap-6">
        <h5 class="text-2xl tracking-tight text-gray-900 dark:text-gray-200">
          Redis Server Connections
        </h5>
      </div>
    </template>

    <div class="flex justify-center w-full">
      <div class="w-full max-w-sm p-4 bg-gray-800 border-gray-700 border border-gray-200 rounded-lg shadow sm:p-6 ">
        <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Select one of the available connections.</p>
        <ul class="my-4 space-y-3">
          <li v-for="(connection, name) in $page.props.connections">
            <Link
              :href="route('connections', { selectedConnection: name })"
              class="flex items-center p-3 text-base font-bold rounded-lg bg-gray-600 hover:bg-gray-500 text-gray-200 group hover:shadow"
            >
              <CheckCircleIcon
                class="w-8"
                :class="{
                  'text-green-600': $page.props.selectedConnection == name,
                  'text-gray-400': $page.props.selectedConnection != name,
                }"
              />
              <span class="flex-1 ml-3 whitespace-nowrap">{{ name }} ({{ connection.host }}:{{ connection.port }})</span>
              <span
                v-show="$page.props.selectedConnection == name"
                class="inline-flex items-center justify-center px-2 py-0.5 ml-3 text-xs font-medium bg-gray-700 text-gray-400 rounded"
              >Selected</span>
            </Link>
          </li>
        </ul>
        <div>
          <a href="#" class="inline-flex items-center text-xs font-normal text-gray-400 hover:underline">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
            </svg>
            Why am I seeing these connections and how to configure them?
          </a>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
