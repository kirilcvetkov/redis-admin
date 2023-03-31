<script setup>
import TreeList from "@/components/TreeList.vue";
</script>

<template>
  <aside class="hidden sm:block fixed top-0 left-0 w-64 h-full overflow-y-auto bg-white dark:bg-gray-800" aria-label="Sidenav">
    <div class="overflow-y-auto py-5 px-3 h-full bg-white dark:bg-gray-800">
      <div class="pb-3">
        <img class="object-contain w-auto" src="@/../assets/logo.png" />
      </div>

      <TreeList :tree="$page.props.tree" :main="true" />
    </div>
  </aside>
</template>
