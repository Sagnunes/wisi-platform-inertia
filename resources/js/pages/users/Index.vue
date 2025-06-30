<script setup lang="ts">
import DeleteDialog from '@/components/DeleteDialog.vue';
import { Avatar, AvatarFallback } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import Tab from '@/components/ui/tab/Tab.vue';
import FlashMessage from '@/components/ui/toast/FlashMessage.vue';
import Badge from '@/components/users/Badge.vue';
import { getInitials } from '@/composables/useInitials';
import { Statuses } from '@/enums/Status';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, User } from '@/types';
import { Paginator, UserWithStatusAndRoles } from '@/types/admin-panel/types';
import { Head, useForm } from '@inertiajs/vue3';
import { PropType } from 'vue';
import TextLink from '@/components/TextLink.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Users',
        href: '/',
    },
];

defineProps({
    users: { type: Object as PropType<Paginator<UserWithStatusAndRoles>>, required: true },
    can: { type: Object, required: true },
});

const updateStatusUrl = (user: User) => {
    return `/users/${user.id}/status`;
};

const form = useForm({
    status: 0,
});

const confirmUpdateStatus = (user: User, status: number) => {
    form.status = status;
    form.patch(updateStatusUrl(user), {
        preserveScroll: true,
        preserveState: true,
        replace: true,
        only: ['users'],
    });
};

const manageRolesUrl = (user: User) => {
    return `user/${user.id}/roles/edit`;
}
</script>

<template>
    <Head title="Users" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div>
            <FlashMessage />
            <div class="mx-auto max-w-7xl px-4 sm:px-6 sm:pt-4 lg:space-y-8 lg:px-8 lg:pt-4">
                <Tab :permissions="can" />
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold text-gray-900">Users</h1>
                        <p class="mt-2 text-sm text-gray-700">
                            A list of all the users in your account including their name, title,
                            email and role.
                        </p>
                    </div>
                </div>
                <div class="mt-8 flow-root">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead>
                                    <tr>
                                        <th
                                            scope="col"
                                            class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-0"
                                        >
                                            Name
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                        >
                                            Title
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                        >
                                            Status
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                        >
                                            Roles
                                        </th>
                                        <th scope="col" class="relative py-3.5 pr-4 pl-3 sm:pr-0">
                                            <span class="sr-only">Edit</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    <tr v-for="user in users.data" :key="user.id">
                                        <td
                                            class="py-5 pr-3 pl-4 text-sm whitespace-nowrap sm:pl-0"
                                        >
                                            <div class="flex items-center">
                                                <Avatar
                                                    class="h-11 w-11 overflow-hidden rounded-lg"
                                                >
                                                    <AvatarFallback
                                                        class="rounded-lg text-black dark:text-white"
                                                    >
                                                        {{ getInitials(user.name) }}
                                                    </AvatarFallback>
                                                </Avatar>
                                                <div class="ml-4">
                                                    <div class="font-medium text-gray-900">
                                                        {{ user.name }}
                                                    </div>
                                                    <div class="mt-1 text-gray-500">
                                                        {{ user.email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td
                                            class="px-3 py-5 text-sm whitespace-nowrap text-gray-500"
                                        >
                                            <div class="text-gray-900">Computer Technician</div>
                                            <div class="mt-1 text-gray-500">
                                                IT, Networking, Security, Software Development,
                                            </div>
                                        </td>
                                        <td
                                            class="px-3 py-5 text-sm whitespace-nowrap text-gray-500"
                                        >
                                            <Badge :status="user.status" />
                                        </td>
                                        <td
                                            class="px-3 py-5 text-sm whitespace-nowrap text-gray-500"
                                        >
                                            {{ user.roles.map((role) => role.name).join(', ') }}
                                        </td>
                                        <td
                                            class="relative space-x-2 py-5 pr-4 pl-1 text-right text-sm font-medium whitespace-nowrap sm:pr-0"
                                        >
                                            <div
                                                class="float-right flex w-fit flex-row items-center"
                                            >
                                                <DeleteDialog
                                                    :resource="user"
                                                    resource-name="user"
                                                    route-name="users.destroy"
                                                    :current-page="users.current_page"
                                                    v-if="user.can.delete"
                                                >
                                                    <template #trigger>
                                                        <Button
                                                            variant="link"
                                                            class="hover:cursor-pointer"
                                                            >Delete User
                                                        </Button>
                                                    </template>
                                                </DeleteDialog>

                                                <div v-if="user.can.validate">
                                                    <Button
                                                        @click="
                                                            confirmUpdateStatus(
                                                                user,
                                                                Statuses.ACTIVE,
                                                            )
                                                        "
                                                        v-if="
                                                            user.status.id === Statuses.PENDING ||
                                                            user.status.id === Statuses.BLOCKED
                                                        "
                                                        >Validate
                                                    </Button>
                                                    <Button
                                                        @click="
                                                            confirmUpdateStatus(
                                                                user,
                                                                Statuses.BLOCKED,
                                                            )
                                                        "
                                                        v-if="user.status.id === Statuses.ACTIVE"
                                                        >Block
                                                    </Button>
                                                </div>
                                                <TextLink :href="manageRolesUrl(user)">Roles</TextLink>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
