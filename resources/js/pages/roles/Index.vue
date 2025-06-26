<script setup lang="ts">
import CreateRole from '@/components/roles/CreateRole.vue';
import DeleteRole from '@/components/roles/DeleteRole.vue';
import TextLink from '@/components/TextLink.vue';
import Tab from '@/components/ui/tab/Tab.vue';
import FlashMessage from '@/components/ui/toast/FlashMessage.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import { Role } from '@/types/user/role';
import { Head } from '@inertiajs/vue3';
import { PropType } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Roles',
        href: '/',
    },
];

defineProps({
    roles: { type: Array as PropType<Role[]>, required: true },
});

const editRoleUrl = (slug: string) => {
    return '/roles/' + slug + '/edit';
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
                        <CreateRole />
                    </div>
                </div>
            </div>
            <div class="mt-8 flow-root overflow-hidden">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <table class="w-full text-left">
                        <thead class="bg-white">
                            <tr>
                                <th scope="col" class="relative isolate py-3.5 pr-3 text-left text-sm font-semibold text-gray-900">
                                    Name
                                    <div class="absolute inset-y-0 right-full -z-10 w-screen border-b border-b-gray-200" />
                                    <div class="absolute inset-y-0 left-0 -z-10 w-screen border-b border-b-gray-200" />
                                </th>
                                <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell">
                                    Description
                                </th>
                                <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell">Created at</th>
                                <th scope="col" class="relative py-3.5 pl-3">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="role in roles" :key="role.id">
                                <td class="relative py-4 pr-3 text-sm font-medium text-gray-900">
                                    {{ role.name }}
                                    <div class="absolute right-full bottom-0 h-px w-screen bg-gray-100" />
                                    <div class="absolute bottom-0 left-0 h-px w-screen bg-gray-100" />
                                </td>
                                <td class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell">{{ role.description }}</td>
                                <td class="hidden px-3 py-4 text-sm text-gray-500 md:table-cell">{{ role.created_at }}</td>
                                <td class="relative py-4 pl-3 text-right text-sm font-medium">
                                    <TextLink :href="editRoleUrl(role.slug)"> Edit</TextLink>
                                    <DeleteRole :role />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped></style>
