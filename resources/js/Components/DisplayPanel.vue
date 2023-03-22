<script setup>
import { watch } from 'vue'
import { storeToRefs } from 'pinia';
import DisplayTitle from "@/components/DisplayTitle.vue";
import DisplayValue from "@/components/DisplayValue.vue";
import DisplayDetails from "@/components/DisplayDetails.vue";

const props = defineProps({
  id: String
});
</script>

<template>
  <div class="min-h-screen p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
    <DisplayTitle :id="id" />
    <DisplayDetails :item="$page.props.get" />
    <DisplayValue :item="$page.props.get" />
  </div>
</template>

