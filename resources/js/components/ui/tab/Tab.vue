<script setup lang="ts">

import { ChevronDown } from 'lucide-vue-next';
import { usePage } from '@inertiajs/vue3';

const currentUrl = usePage().url;

const tabs = [
    { name: 'Users', href: '/users', current: false },
    { name: 'Statuses', href: '/statuses', current: false },
    { name: 'Roles', href: '/roles', current: false },
    { name: 'Permission', href: '/permissions', current: false }
].map(tab => ({
    ...tab,
    current: tab.href === currentUrl
}));
</script>

<template>
    <div class="grid grid-cols-1 sm:hidden">
        <select
            aria-label="Select a tab"
            class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-2 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"
        >
            <option v-for="tab in tabs" :key="tab.name" :selected="tab.current">{{ tab.name }}</option>
        </select>
        <ChevronDown
            class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end fill-gray-500 "
            aria-hidden="true"
        />
    </div>
    <div class="hidden sm:block">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <a
                    v-for="tab in tabs"
                    :key="tab.name"
                    :href="tab.href"
                    :class="[
                                tab.current
                                    ? 'border-gray-500 text-gray-700'
                                    : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700',
                                'border-b-2 px-1 py-4 text-sm font-medium whitespace-nowrap',
                            ]"
                    :aria-current="tab.current ? 'page' : undefined"
                >{{ tab.name }}</a
                >
            </nav>
        </div>
    </div>
</template>

<style scoped>

</style>
