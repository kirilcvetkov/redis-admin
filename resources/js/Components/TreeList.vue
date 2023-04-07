<script setup>
import TreeItem from "@/Components/TreeItem.vue";

defineProps({
  tree: Object,
  show: { type: Boolean, default: true },
  main: { type: Boolean, default: false },
});
</script>

<template>
  <ul v-if="show" :class="{ 'border-l border-l-gray-700': ! main }" class="space-y-2 pt-1">
    <TreeItem
      v-if="show"
      v-for="item in tree"
      :name="item.name"
      :key="item.key"
      :count="item.count"
      :itemKey="item.key"
      :children="item.children"
      :show="decodeURIComponent(route().params.key).startsWith(item.key)"
    />
  </ul>
</template>
