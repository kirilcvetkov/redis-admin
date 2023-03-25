<script setup>
import TreeItem from "@/Components/TreeItem.vue";

defineProps({
  tree: Object,
  show: { type: Boolean, default: true },
  main: { type: Boolean, default: false },
});
// :show-children="$route.params.id ? $route.params.id.startsWith(item.key) || false : false"
</script>

<template>
  <ul v-if="show" :class="{ 'border-l border-l-gray-700': ! main }" class="space-y-2 p-1">
    <TreeItem
      v-if="show"
      v-for="item in tree"
      :name="item.name"
      :key="item.key"
      :count="item.count"
      :itemKey="item.key"
      :children="item.children"
    />
  </ul>
</template>
