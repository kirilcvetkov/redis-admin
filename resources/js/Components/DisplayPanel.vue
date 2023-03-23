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
  <div class="sm:ml-64 mt-14 min-h-screen p-4 rounded-lg">
    <DisplayTitle :id="id" />
    <DisplayDetails :item="$page.props.get" />
    <DisplayValue :item="$page.props.get" />
  </div>
</template>

