<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { StatusDTO } from '@/types/admin-panel/types';
import { useForm } from '@inertiajs/vue3';
import { PropType } from 'vue';

const props = defineProps({
    status: {
        type: Object as PropType<StatusDTO>,
        required: true,
    },
    currentPage: { required: true, type: Number },
});

const form = useForm({});

const closeModal = () => {
    form.clearErrors();
    form.reset();
};

const deleteStatus = () => {
    form.delete(
        route('statuses.destroy', {
            status: props.status?.id,
            page: props.currentPage,
        }),
        {
            preserveScroll: true,
            preserveState: true,
        },
    );
};
</script>

<template>
    <Dialog>
        <DialogTrigger>
            <Button variant="link" class="hover:cursor-pointer">Delete</Button>
        </DialogTrigger>
        <DialogContent>
            <form @submit.prevent="deleteStatus(status)">
                <DialogHeader class="space-y-3">
                    <DialogTitle>Are you sure you want to delete "{{ status.name }}"</DialogTitle>
                    <DialogDescription>
                        Once the status is deleted, all of its resources and data will also be permanently deleted.
                    </DialogDescription>
                </DialogHeader>
                <DialogFooter>
                    <DialogClose as-child>
                        <Button variant="secondary" @click="closeModal"> Cancel</Button>
                    </DialogClose>
                    <Button variant="destructive">Delete</Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>

<style scoped></style>
