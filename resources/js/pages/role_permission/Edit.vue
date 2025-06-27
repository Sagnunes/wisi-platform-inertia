<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Permission } from '@/types/user/permissions';
import { RolePermission } from '@/types/user/role_permission';
import { Head, useForm } from '@inertiajs/vue3';
import { PropType, onMounted } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const props = defineProps({
    role: {
        type: Object as PropType<RolePermission>,
        required: true,
    },
    permissions: {
        type: Array as PropType<Permission[]>,
        required: true,
    },
});

const form = useForm({
    permissions: props.role?.permissions?.map((p) => p.id).filter(Boolean) || [],
});

onMounted(() => {
    if (props.role?.permissions) {
        form.permissions = props.role.permissions.map((p) => p.id);
    }
});

const submit = () => {
    form.permissions = form.permissions.filter((id) => id !== null);
    form.put(route('role_permission.update', props.role?.id), {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <form @submit.prevent="submit">
                <div class="mx-auto max-w-2xl px-4 lg:max-w-none lg:px-0">
                    <div>
                        <h3 id="status-info-heading" class="text-lg font-medium text-gray-900">Giving Permissions to - {{ props.role?.name }}</h3>
                        <div class="mt-6">
                            <Label>Permissions</Label>
                            <div class="mt-2 grid grid-cols-1">
                                <select
                                    v-model="form.permissions"
                                    multiple
                                    id="permissions"
                                    size="4"
                                    name="permissions[]"
                                    class="h-[500px] w-full rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 outline-gray-300 focus:outline-2 focus:outline-gray-600 sm:text-sm/6"
                                >
                                    <option v-for="permission in permissions" :value="permission.id" :key="permission.id">
                                        {{ permission.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 flex justify-end border-t border-gray-200 pt-6">
                        <div class="flex items-center gap-4">
                            <Button @click.prevent="form.permissions = []">Clear</Button>
                            <Button :disabled="form.processing">Save</Button>
                            <Transition
                                enter-active-class="transition ease-in-out"
                                enter-from-class="opacity-0"
                                leave-active-class="transition ease-in-out"
                                leave-to-class="opacity-0"
                            >
                                <p v-show="form.recentlySuccessful" class="text-sm text-neutral-600">Saved.</p>
                            </Transition>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
