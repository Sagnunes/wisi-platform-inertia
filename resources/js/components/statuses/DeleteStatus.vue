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
import { Status } from '@/types/user/status';
import { useForm } from '@inertiajs/vue3';
import { PropType } from 'vue';

defineProps({
    status: {
        type: Object as PropType<Status>,
        required: true,
    },
});

const form = useForm({});

const closeModal = () => {
    form.clearErrors();
    form.reset();
};

const deleteStatus = (status: Status) => {
    form.delete(route('statuses.destroy', status), {
        onSuccess: () => closeModal(),
    });
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
