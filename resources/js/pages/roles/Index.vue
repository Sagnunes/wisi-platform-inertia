<script setup lang="ts">
import CreateDialog from '@/components/CreateDialog.vue';
import DeleteDialog from '@/components/DeleteDialog.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import Pagination from '@/components/ui/pagination/Pagination.vue';
import Tab from '@/components/ui/tab/Tab.vue';
import FlashMessage from '@/components/ui/toast/FlashMessage.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import { Paginator, RoleDTO } from '@/types/admin-panel/types';
import { Head } from '@inertiajs/vue3';
import { PropType } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Roles',
        href: '/',
    },
];

defineProps({
    roles: { type: Object as PropType<Paginator<RoleDTO>>, required: true },
    can: { type: Object, required: true },
});

const fields = [
    { name: 'name', placeholder: 'Name', required: true },
    { name: 'description', placeholder: 'Description' },
];

const editRoleUrl = (slug: string) => {
    return '/roles/' + slug + '/edit';
};

const editPermissionUrl = (slug: string) => {
    return `role/${slug}/permission/edit`;
};
</script>

<template>
    <Head title="Roles" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div>
            <FlashMessage />
            <div class="mx-auto max-w-7xl px-4 sm:px-6 sm:pt-4 lg:space-y-8 lg:px-8 lg:pt-4">
                <Tab />
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold text-gray-900">Roles</h1>
                        <p class="mt-2 text-sm text-gray-700">A list of all roles.</p>
                    </div>
                    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                        <CreateDialog
                            resource-name="role"
                            route-name="roles.store"
                            :fields="fields"
                            :initial-form-data="{ name: '', description: '' }"
                            v-if="can.create"
                        >
                            <template #trigger>
                                <Button variant="link" class="hover:cursor-pointer">
                                    New Role</Button
                                >
                            </template>
                        </CreateDialog>
                    </div>
                </div>
            </div>
            <div class="mt-8 flow-root overflow-hidden">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <table class="w-full text-left" v-if="roles.data.length > 0">
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
                            <tr v-for="role in roles.data" :key="role.id">
                                <td class="relative py-4 pr-3 text-sm font-medium text-gray-900">
                                    {{ role.name }}
                                    <div
                                        class="absolute right-full bottom-0 h-px w-screen bg-gray-100"
                                    />
                                    <div
                                        class="absolute bottom-0 left-0 h-px w-screen bg-gray-100"
                                    />
                                </td>
                                <td class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell">
                                    {{ role.description }}
                                </td>
                                <td class="hidden px-3 py-4 text-sm text-gray-500 md:table-cell">
                                    {{ role.created_at }}
                                </td>
                                <td class="relative py-4 pl-3 text-right text-sm font-medium">
                                    <TextLink :href="editRoleUrl(role.slug)" v-if="can.edit"> Edit</TextLink>
                                    <DeleteDialog
                                        :resource="role"
                                        resource-name="role"
                                        route-name="roles.destroy"
                                        :current-page="roles.current_page"
                                        v-if="can.delete"
                                    >
                                        <template #trigger>
                                            <Button variant="link" class="hover:cursor-pointer"
                                                >Delete Role</Button
                                            >
                                        </template>
                                    </DeleteDialog>
                                    <TextLink :href="editPermissionUrl(role.slug)" v-if="can.assign">
                                        Assign</TextLink
                                    >
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="mt-1 truncate text-sm text-gray-500" v-else>No records.</p>
                </div>
                <div
                    class="my-4 flex items-center justify-center"
                    v-if="roles.total > roles.per_page"
                >
                    <Pagination
                        :pagination="roles"
                        @page-change="
                            (page) =>
                                $inertia.get(
                                    '/roles',
                                    { page },
                                    {
                                        preserveScroll: true,
                                        preserveState: true,
                                        replace: true,
                                        only: ['roles'],
                                    },
                                )
                        "
                    />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped></style>
