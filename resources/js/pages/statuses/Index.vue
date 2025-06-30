<script setup lang="ts">
import CreateDialog from '@/components/CreateDialog.vue';
import DeleteDialog from '@/components/DeleteDialog.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import Pagination from '@/components/ui/pagination/Pagination.vue';
import Tab from '@/components/ui/tab/Tab.vue';
import FlashMessage from '@/components/ui/toast/FlashMessage.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Paginator, StatusDTO } from '@/types/admin-panel/types';
import { Head } from '@inertiajs/vue3';
import { PropType } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Statuses',
        href: '/',
    },
];

const fields = [
    { name: 'name', placeholder: 'Name', required: true },
    { name: 'description', placeholder: 'Description' },
];

defineProps({
    statuses: { type: Object as PropType<Paginator<StatusDTO>>, required: true },
    can: { type: Object, required: true },
});

const editStatus = (slug: string) => {
    return '/statuses/' + slug + '/edit';
};
</script>

<template>
    <Head title="Statuses" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div>
            <FlashMessage />
            <div class="mx-auto max-w-7xl px-4 sm:px-6 sm:pt-4 lg:space-y-8 lg:px-8 lg:pt-4">
                <Tab :permissions="can" />
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold text-gray-900">Statuses</h1>
                        <p class="mt-2 text-sm text-gray-700">
                            A list of all the users in your account including their name, title,
                            email and role.
                        </p>
                    </div>
                    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                        <CreateDialog
                            resource-name="status"
                            route-name="statuses.store"
                            :fields="fields"
                            :initial-form-data="{ name: '', description: '' }"
                        >
                            <template #trigger>
                                <Button variant="link" class="hover:cursor-pointer">
                                    New Status
                                </Button>
                            </template>
                        </CreateDialog>
                    </div>
                </div>
            </div>
            <div class="mt-8 flow-root overflow-hidden">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <table class="w-full text-left" v-if="statuses.data.length > 0">
                        <thead class="bg-white">
                            <tr>
                                <th
                                    scope="col"
                                    class="relative isolate py-3.5 pr-3 text-left text-sm font-semibold text-gray-900"
                                >
                                    Name
                                    <div
                                        class="absolute inset-y-0 right-full -z-10 w-screen border-b border-b-gray-200"
                                    />
                                    <div
                                        class="absolute inset-y-0 left-0 -z-10 w-screen border-b border-b-gray-200"
                                    />
                                </th>
                                <th
                                    scope="col"
                                    class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
                                >
                                    Description
                                </th>
                                <th
                                    scope="col"
                                    class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell"
                                >
                                    Created at
                                </th>
                                <th scope="col" class="relative py-3.5 pl-3">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="status in statuses.data" :key="status.id">
                                <td class="relative py-4 pr-3 text-sm font-medium text-gray-900">
                                    {{ status.name }}
                                    <div
                                        class="absolute right-full bottom-0 h-px w-screen bg-gray-100"
                                    />
                                    <div
                                        class="absolute bottom-0 left-0 h-px w-screen bg-gray-100"
                                    />
                                </td>
                                <td class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell">
                                    {{ status.description }}
                                </td>
                                <td class="hidden px-3 py-4 text-sm text-gray-500 md:table-cell">
                                    {{ status.created_at }}
                                </td>
                                <td class="relative py-4 pl-3 text-right text-sm font-medium">
                                    <TextLink :href="editStatus(status.slug)"> Edit </TextLink>
                                    <DeleteDialog
                                        :resource="status"
                                        resource-name="status"
                                        route-name="statuses.destroy"
                                        :current-page="statuses.current_page"
                                    >
                                        <template #trigger>
                                            <Button variant="link" class="hover:cursor-pointer"
                                                >Delete Status
                                            </Button>
                                        </template>
                                    </DeleteDialog>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="mt-1 truncate text-sm text-gray-500" v-else>No records.</p>
                </div>
                <div
                    class="my-4 flex items-center justify-center"
                    v-if="statuses.total > statuses.per_page"
                >
                    <Pagination
                        :pagination="statuses"
                        @page-change="
                            (page) =>
                                $inertia.get(
                                    '/statuses',
                                    { page },
                                    {
                                        preserveScroll: true,
                                        preserveState: true,
                                        replace: true,
                                        only: ['statuses'],
                                    },
                                )
                        "
                    />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
