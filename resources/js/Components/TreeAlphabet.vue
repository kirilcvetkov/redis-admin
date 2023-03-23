<template>
  <ul class="text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
    <li
      v-for="(count, letter) in $page.props.alphabet"
      class="w-full px-4 py-2 border-b border-gray-200 rounded-t-lg dark:border-gray-600"
    >
      {{ letter }}
      <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
        {{ count }}
      </span>
    </li>
  </ul>
</template>
