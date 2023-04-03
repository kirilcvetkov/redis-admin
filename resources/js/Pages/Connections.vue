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

    <div class="rounded-2xl bg-gradient-to-r from-pink-500 via-red-500 to-yellow-500 p-1 shadow-xl">
      <div class="block rounded-xl bg-gray-900 p-4 sm:p-6 lg:p-8">
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
            <tr v-for="(connection, name) in $page.props.connections">
              <td class="p-4 text-slate-500 dark:text-slate-400">
                <CheckCircleIcon
                  class="w-8"
                  :class="{
                    'text-green-600': $page.props.selectedConnection == name,
                    'text-gray-600': $page.props.selectedConnection != name,
                  }"
                />
              </td>
              <td class="p-4 text-slate-500 dark:text-slate-400">
                <Link :href="route('admin', { selectedConnection: name })">
                  {{ name }}
                </Link>
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
                <Link :href="route('admin', { selectedConnection: name })">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                  </svg>
                </Link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AppLayout>
</template>
