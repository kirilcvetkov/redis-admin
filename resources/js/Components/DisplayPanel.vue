<script setup>
import { watch } from 'vue'
import { storeToRefs } from 'pinia';
import DisplayTitle from "@/components/DisplayTitle.vue";
import DisplayValue from "@/components/DisplayValue.vue";
import DisplayDetails from "@/components/DisplayDetails.vue";
import { useTree } from "@/stores/TreeStore"

const props = defineProps({
  id: String
});

let tree = useTree();
tree.getItem(props.id);

const { get, getItem } = storeToRefs(tree);

watch(() => props.id, tree.getItem);
</script>

<template>
  <div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
      <DisplayTitle :id="id" />
      <DisplayDetails :item="get" />
      <DisplayValue :item="get" />
    </div>
  </div>
</template>

