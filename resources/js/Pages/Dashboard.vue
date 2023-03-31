<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
defineProps({
  tab: { type: String, default: 'default' }
});
</script>
<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h5 class="text-2xl tracking-tight text-gray-900 dark:text-gray-200">
        Dashboard
      </h5>
    </template>

    <div class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
      <div class="sm:hidden">
        <label for="tabs" class="sr-only">Select tab</label>
        <select id="tabs" class="bg-gray-50 border-0 border-b border-gray-200 text-gray-900 text-sm rounded-t-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
          <option>Server Stats</option>
          <option>Services</option>
          <option>FAQ</option>
        </select>
      </div>
      <ul class="hidden text-sm font-medium text-center text-gray-500 divide-x divide-gray-200 rounded-lg sm:flex dark:divide-gray-600 dark:text-gray-400" id="fullWidthTab" data-tabs-toggle="#fullWidthTabContent" role="tablist">
        <li class="w-full">
          <button
            id="stats-tab" data-tabs-target="#stats" type="button" role="tab" aria-controls="stats" aria-selected="true"
            class="inline-block w-full p-4 rounded-tl-lg hover:bg-gray-100 focus:outline-none"
            @click="tab = 'default'"
            :class="{
              'text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 border-blue-600 dark:border-blue-500': tab == 'default',
              'bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600': tab != 'default',
            }"
          >Server Stats</button>
        </li>
        <li class="w-full">
          <button
            id="about-tab" data-tabs-target="#about" type="button" role="tab" aria-controls="about" aria-selected="false"
            class="inline-block w-full p-4 bg-gray-50 hover:bg-gray-100 focus:outline-none"
            @click="tab = 'tab2'"
            :class="{
              'text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 border-blue-600 dark:border-blue-500': tab == 'tab2',
              'bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600': tab != 'tab2',
            }"
          >Services</button>
        </li>
        <li class="w-full">
          <button
            id="faq-tab" data-tabs-target="#faq" type="button" role="tab" aria-controls="faq" aria-selected="false"
            class="inline-block w-full p-4 rounded-tr-lg hover:bg-gray-100 focus:outline-none"
            @click="tab = 'tab3'"
            :class="{
              'text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 border-blue-600 dark:border-blue-500': tab == 'tab3',
              'bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600': tab != 'tab3',
            }"
          >FAQ</button>
        </li>
      </ul>
      <div id="fullWidthTabContent" class="border-t border-gray-200 dark:border-gray-600">
        <div v-show="tab == 'default'" class="p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="stats" role="tabpanel" aria-labelledby="stats-tab">
          <dl class="grid max-w-screen-xl grid-cols-1 gap-8 p-4 mx-auto text-gray-900 sm:grid-cols-2 xl:grid-cols-3 dark:text-white sm:p-8">
            <div
              v-for="value in $page.props.stats"
              class="flex flex-col items-center justify-center"
            >
              <dt
                v-if="typeof value.value == 'object'"
                v-for="(row, key) in value.value"
                class="mb-2 text-3xl font-extrabold"
                >{{ key + ': ' + row }}</dt>
              <dt
                v-else
                class="mb-2 text-3xl font-extrabold"
                >{{ value.value }}</dt>
              <dd class="text-gray-500 dark:text-gray-400">{{ value.name }}</dd>
            </div>
          </dl>
        </div>
        <div v-show="tab == 'tab2'" class="p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="about" role="tabpanel" aria-labelledby="about-tab">
          <h2 class="mb-5 text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white">We invest in the world’s potential</h2>
          <!-- List -->
          <ul role="list" class="space-y-4 text-gray-500 dark:text-gray-400">
            <li class="flex space-x-2">
              <!-- Icon -->
              <svg class="flex-shrink-0 w-4 h-4 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
              <span class="leading-tight">Dynamic reports and dashboards</span>
            </li>
            <li class="flex space-x-2">
              <!-- Icon -->
              <svg class="flex-shrink-0 w-4 h-4 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
              <span class="leading-tight">Templates for everyone</span>
            </li>
            <li class="flex space-x-2">
              <!-- Icon -->
              <svg class="flex-shrink-0 w-4 h-4 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
              <span class="leading-tight">Development workflow</span>
            </li>
            <li class="flex space-x-2">
              <!-- Icon -->
              <svg class="flex-shrink-0 w-4 h-4 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
              <span class="leading-tight">Limitless business automation</span>
            </li>
          </ul>
        </div>
        <div v-show="tab == 'tab3'" class="p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="faq" role="tabpanel" aria-labelledby="faq-tab">
          <div id="accordion-flush" data-accordion="collapse" data-active-classes="bg-white dark:bg-gray-800 text-gray-900 dark:text-white" data-inactive-classes="text-gray-500 dark:text-gray-400">
            <h2 id="accordion-flush-heading-1">
              <button type="button" class="flex items-center justify-between w-full py-5 font-medium text-left text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400" data-accordion-target="#accordion-flush-body-1" aria-expanded="true" aria-controls="accordion-flush-body-1">
                <span>What is Flowbite?</span>
                <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
              </button>
            </h2>
            <div id="accordion-flush-body-1" class="hidden" aria-labelledby="accordion-flush-heading-1">
              <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                <p class="mb-2 text-gray-500 dark:text-gray-400">Flowbite is an open-source library of interactive components built on top of Tailwind CSS including buttons, dropdowns, modals, navbars, and more.</p>
                <p class="text-gray-500 dark:text-gray-400">Check out this guide to learn how to <a href="/docs/getting-started/introduction/" class="text-blue-600 dark:text-blue-500 hover:underline">get started</a> and start developing websites even faster with components on top of Tailwind CSS.</p>
              </div>
            </div>
            <h2 id="accordion-flush-heading-2">
              <button type="button" class="flex items-center justify-between w-full py-5 font-medium text-left text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400" data-accordion-target="#accordion-flush-body-2" aria-expanded="false" aria-controls="accordion-flush-body-2">
                <span>Is there a Figma file available?</span>
                <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
              </button>
            </h2>
            <div id="accordion-flush-body-2" class="hidden" aria-labelledby="accordion-flush-heading-2">
              <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                <p class="mb-2 text-gray-500 dark:text-gray-400">Flowbite is first conceptualized and designed using the Figma software so everything you see in the library has a design equivalent in our Figma file.</p>
                <p class="text-gray-500 dark:text-gray-400">Check out the <a href="https://flowbite.com/figma/" class="text-blue-600 dark:text-blue-500 hover:underline">Figma design system</a> based on the utility classes from Tailwind CSS and components from Flowbite.</p>
              </div>
            </div>
            <h2 id="accordion-flush-heading-3">
              <button type="button" class="flex items-center justify-between w-full py-5 font-medium text-left text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400" data-accordion-target="#accordion-flush-body-3" aria-expanded="false" aria-controls="accordion-flush-body-3">
                <span>What are the differences between Flowbite and Tailwind UI?</span>
                <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
              </button>
            </h2>
            <div id="accordion-flush-body-3" class="hidden" aria-labelledby="accordion-flush-heading-3">
              <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                <p class="mb-2 text-gray-500 dark:text-gray-400">The main difference is that the core components from Flowbite are open source under the MIT license, whereas Tailwind UI is a paid product. Another difference is that Flowbite relies on smaller and standalone components, whereas Tailwind UI offers sections of pages.</p>
                <p class="mb-2 text-gray-500 dark:text-gray-400">However, we actually recommend using both Flowbite, Flowbite Pro, and even Tailwind UI as there is no technical reason stopping you from using the best of two worlds.</p>
                <p class="mb-2 text-gray-500 dark:text-gray-400">Learn more about these technologies:</p>
                <ul class="pl-5 text-gray-500 list-disc dark:text-gray-400">
                  <li><a href="https://flowbite.com/pro/" class="text-blue-600 dark:text-blue-500 hover:underline">Flowbite Pro</a></li>
                  <li><a href="https://tailwindui.com/" rel="nofollow" class="text-blue-600 dark:text-blue-500 hover:underline">Tailwind UI</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
