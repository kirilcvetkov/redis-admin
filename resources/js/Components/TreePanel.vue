<script setup>
import TreeAlphabet from "@/components/TreeAlphabet.vue";
import TreeList from "@/components/TreeList.vue";
</script>

<template>
  <aside class="fixed left-0 w-96 h-full columns-2 gap-1 overflow-y-auto bg-white dark:bg-gray-800" aria-label="Sidenav">
    <div class="w-24 h-full pt-2">
      <TreeAlphabet />
    </div>
    <div class="h-full pt-2">
      <TreeList :tree="$page.props.tree" :main="true" />
    </div>
  </aside>
</template>
