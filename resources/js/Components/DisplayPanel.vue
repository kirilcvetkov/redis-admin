<script setup>
import DisplayTitle from "@/components/DisplayTitle.vue";
import DisplayValue from "@/components/DisplayValue.vue";
import DisplayDetails from "@/components/DisplayDetails.vue";
</script>

<template>
  <DisplayTitle :id="$page.props.item.key" />
  <DisplayDetails :item="$page.props.item" />
  <DisplayValue :item="$page.props.item" />
</template>

