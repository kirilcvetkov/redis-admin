<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ItemTitle from "@/components/ItemTitle.vue";
import ItemValue from "@/components/ItemValue.vue";
import ItemDetails from "@/components/ItemDetails.vue";
</script>

<template>
  <AppLayout title="Item">
    <template #header>
      <ItemTitle :key="$page.props.item" :id="$page.props.item.key" />
    </template>

    <div>
      <ItemDetails :key="$page.props.item" :item="$page.props.item" />
      <ItemValue :key="$page.props.item" :item="$page.props.item" />
    </div>
  </AppLayout>
</template>
