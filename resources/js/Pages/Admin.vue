<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
  <Head title="Admin" />

  <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
    <div class="min-h-screen">
      <nav class="px-2 sm:px-4 py-2.5 rounded">
        <div class="container flex flex-wrap items-center justify-around mx-auto">
          <!-- Logo -->
          <div class="shrink-0 flex items-center">
            <Link :href="route('connections')">
              <ApplicationMark class="block h-9 w-auto" />
            </Link>
          </div>

          <!-- Navigation Links -->
          <div class="w-full block md:w-auto" id="navbar-default">
            <ul class="flex flex-col p-4 mt-4 rounded-lg md:flex-row md:mt-0 md:text-sm md:font-medium">
              <li v-for="(count, letter) in $page.props.alphabet">
                <Link
                  :href="route('list', {letter: letter})" :active="route().current('connections')"
                  class="mr-1 px-3 py-2 text-xs font-medium text-center text-white rounded-lg focus:ring-4 focus:outline-none"
                  :class="{
                    'bg-blue-700 hover:bg-blue-800 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800': count > 0,
                    'hidden xl:block bg-gray-700 hover:bg-gray-800 focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800': count == 0,
                  }"
                  as="button"
                  :disabled="count == 0"
                  >
                  {{ letter }}
                </Link>
              </li>
            </ul>

            <!-- <div class="relative hidden md:block">
              <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">Search icon</span>
              </div>
              <input type="text" id="search-navbar" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search...">
            </div> -->
          </div>

          <!-- Settings Dropdown -->
          <div class="ml-3 relative">
            <Dropdown align="right" width="48">
              <template #trigger>
                <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                  <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                </button>

                <span v-else class="inline-flex rounded-md">
                  <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-blue-900 hover:text-gray-200 focus:outline-none focus:bg-blue-900 active:bg-blue-800 transition ease-in-out duration-150">
                    {{ $page.props.auth.user.name }}

                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                  </button>
                </span>
              </template>

              <template #content>
                <!-- Account Management -->
                <div class="block px-4 py-2 text-xs text-gray-500">
                  Manage Account
                </div>

                <DropdownLink :href="route('profile.show')">
                  Profile
                </DropdownLink>

                <DropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
                  API Tokens
                </DropdownLink>

                <div class="border-t border-gray-200" />

                <!-- Authentication -->
                <form @submit.prevent="logout">
                  <DropdownLink as="button">
                    Log Out
                  </DropdownLink>
                </form>
              </template>
            </Dropdown>
          </div>
        </div>
      </nav>
    </div>

  </div>
</template>

<style>
  .bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
  }
  @media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
      background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
  }
</style>
