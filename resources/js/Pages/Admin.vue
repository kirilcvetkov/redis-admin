<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import TreePanel from "@/components/TreePanel.vue";
import Connections from "@/Pages/Connections.vue";
import DisplayTitle from "@/components/DisplayTitle.vue";
import DisplayValue from "@/components/DisplayValue.vue";
import DisplayDetails from "@/components/DisplayDetails.vue";
</script>

<template>
  <AppLayout title="Profile">
    <template #header>
      <DisplayTitle :id="$page.props.item.key" />
    </template>

    <div v-if="$page.props.item">
      <DisplayDetails :item="$page.props.item" />
      <DisplayValue :item="$page.props.item" />
    </div>
    <Connections v-else />
  </AppLayout>
</template>
