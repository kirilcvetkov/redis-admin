<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import DisplayTitle from "@/components/DisplayTitle.vue";
import DisplayValue from "@/components/DisplayValue.vue";
import DisplayDetails from "@/components/DisplayDetails.vue";
</script>

<template>
  <AppLayout title="Item">
    <template #header>
      <DisplayTitle :key="$page.props.item" :id="$page.props.item.key" />
    </template>

    <div>
      <DisplayDetails :key="$page.props.item" :item="$page.props.item" />
      <DisplayValue :key="$page.props.item" :item="$page.props.item" />
    </div>
  </AppLayout>
</template>
