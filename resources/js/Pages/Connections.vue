<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import RedisConnections from "@/Components/RedisConnections.vue";
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
        <RedisConnections :connections="$page.props.connections" :selected="$page.props.selectedConnection" />
      </div>
    </div>
  </AppLayout>
</template>
