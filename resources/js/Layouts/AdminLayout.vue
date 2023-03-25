<script setup>
import { Link, router } from '@inertiajs/vue3';
import BackgroundLayout from '@/Layouts/BackgroundLayout.vue';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import TreePanel from "@/components/TreePanel.vue";
import DisplayPanel from "@/components/DisplayPanel.vue";

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  laravelVersion: String,
  phpVersion: String,
});

const logout = () => {
  router.post(route('logout'));
};
</script>

<template>
  <TreePanel />

  <BackgroundLayout>
    <nav class="top-0 sm:ml-64 inset-x-0 fixed bg-gray-50 h-14 z-30 transition-position w-screen lg:w-auto p-2">
      <div class="px-4 flex flex-nowrap items-center justify-end mx-auto">
        <!-- Settings Dropdown -->
        <div v-if="$page.props.auth.user" class="ml-3 relative">
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

    <DisplayPanel />

    <div class="sm:ml-64 flex justify-center mt-16 px-6 sm:items-center sm:justify-between">
      <div class="text-center text-sm text-gray-500 dark:text-gray-400 sm:text-left">
        <div class="flex items-center gap-4">
          <a href="https://github.com/sponsors/kirilcvetkov" class="group inline-flex items-center hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="-mt-px mr-1 w-5 h-5 stroke-gray-400 dark:stroke-gray-600 group-hover:stroke-gray-600 dark:group-hover:stroke-gray-400">
              <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
            </svg>
            Sponsor
          </a>
        </div>
      </div>

      <div class="ml-4 text-center text-sm text-gray-500 dark:text-gray-400 sm:text-right sm:ml-0">
        Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
      </div>
    </div>
  </BackgroundLayout>
</template>
