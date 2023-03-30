<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import DisplayTitle from "@/components/DisplayTitle.vue";
import DisplayValue from "@/components/DisplayValue.vue";
import DisplayDetails from "@/components/DisplayDetails.vue";
</script>

<template>
  <AppLayout title="Admin">
    <template #header>
      <DisplayTitle :id="$page.props.item.key" />
    </template>

    <div>
      <DisplayDetails :item="$page.props.item" />
      <DisplayValue :item="$page.props.item" />
    </div>
  </AppLayout>
</template>
