<script setup>
import { Head, Link } from '@inertiajs/vue3';
import RedisConnections from "@/Components/RedisConnections.vue";
</script>

<template>
  <div class="rounded-2xl bg-gradient-to-r from-pink-500 via-red-500 to-yellow-500 p-1 shadow-xl">
    <div class="block rounded-xl bg-gray-900 p-4 sm:p-6 lg:p-8">
      <h3 class="mt-2 mb-6 text-lg font-bold text-gray-200 sm:text-xl">
        Redis Connections
      </h3>

      <RedisConnections :connections="$page.props.connections" :selected="$page.props.selectedConnection" />
    </div>
  </div>
</template>
