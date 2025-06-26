<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Status } from '@/types/user/status';
import { Head, useForm } from '@inertiajs/vue3';
import { PropType } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Statuses',
        href: '/statuses',
    },
];

breadcrumbs.push({
    title: 'Editing status',
    href: '/',
});

const props = defineProps({
    status: {
        type: Object as PropType<Status>,
        required: true,
    },
});

const status = props.status;
const form = useForm({
    name: status.name,
    description: status.description ?? undefined,
});

const submit = (e: Event) => {
    e.preventDefault();
    form.patch(route('statuses.update', status), {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Editing Status" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <form @submit="submit">
                <div class="mx-auto max-w-2xl px-4 lg:max-w-none lg:px-0">
                    <div>
                        <h3 id="status-info-heading" class="text-lg font-medium text-gray-900">Editing Status - {{ status.name }}</h3>
                        <div class="mt-6">
                            <Label>Name</Label>
                            <div class="mt-2">
                                <Input v-model="form.name" type="text" id="name" name="name" />
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>
                        </div>

                        <div class="mt-6">
                            <label for="description" class="block text-sm/6 font-medium text-gray-700">Description</label>
                            <div class="mt-2">
                                <Input v-model="form.description" type="text" id="description" name="description" />
                                <InputError class="mt-2" :message="form.errors.description" />
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 flex justify-end border-t border-gray-200 pt-6">
                        <div class="flex items-center gap-4">
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
