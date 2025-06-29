<script setup lang="ts">
import { ChevronDown } from 'lucide-vue-next';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
    permissions: { type: Object, required: true }
});

const currentUrl = usePage().url;

const allTabs = [
    { name: 'Users', href: '/users', permission: 'manage-users' },
    { name: 'Statuses', href: '/statuses', permission: 'manage-statuses' },
    { name: 'Roles', href: '/roles', permission: 'manage-roles' },
    { name: 'Permission', href: '/permissions', permission: 'manage-permissions' }
];

const visibleTabs = allTabs.filter(tab =>
    props.permissions[tab.permission] || tab.permission === 'manage-users'
);

const processedTabs = visibleTabs.map(tab => ({
    ...tab,
    current: tab.href === currentUrl
}));

const mainTabItems = processedTabs.slice(0, 1);
const footerTabItems = processedTabs.slice(1);
</script>

<template>
    <div class="grid grid-cols-1 sm:hidden">
        <select
            aria-label="Select a tab"
            class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-2 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"
        >
            <option
                v-for="tab in processedTabs"
                :key="tab.name"
                :selected="tab.current"
            >
                {{ tab.name }}
            </option>
        </select>
        <ChevronDown
            class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end fill-gray-500"
            aria-hidden="true"
        />
    </div>

    <div class="hidden sm:block">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 justify-between" aria-label="Tabs">
                <!-- Main Tab -->
                <div class="-mb-px flex space-x-8">
                    <a
                        v-for="mainTab in mainTabItems"
                        :key="mainTab.name"
                        :href="mainTab.href"
                        :class="[
                            mainTab.current
                                ? 'border-gray-500 text-gray-700'
                                : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700',
                            'border-b-2 px-1 py-4 text-sm font-medium whitespace-nowrap'
                        ]"
                        :aria-current="mainTab.current ? 'page' : undefined"
                    >
                        {{ mainTab.name }}
                    </a>
                </div>

                <!-- Footer Tabs -->
                <div v-if="footerTabItems.length" class="-mb-px flex space-x-8">
                    <a
                        v-for="footerTabItem in footerTabItems"
                        :key="footerTabItem.name"
                        :href="footerTabItem.href"
                        :class="[
                            footerTabItem.current
                                ? 'border-gray-500 text-gray-700'
                                : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700',
                            'border-b-2 px-1 py-4 text-sm font-medium whitespace-nowrap'
                        ]"
                        :aria-current="footerTabItem.current ? 'page' : undefined"
                    >
                        {{ footerTabItem.name }}
                    </a>
                </div>
            </nav>
        </div>
    </div>
</template>
