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
import { Role } from '@/types/user/role';
import { useForm } from '@inertiajs/vue3';
import { PropType } from 'vue';

defineProps({
    role: {
        type: Object as PropType<Role>,
        required: true,
    },
});

const form = useForm({});

const closeModal = () => {
    form.clearErrors();
    form.reset();
};

const submit = (role: Role) => {
    form.delete(route('roles.destroy', role), {
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
            <form @submit.prevent="submit(role)">
                <DialogHeader class="space-y-3">
                    <DialogTitle>Are you sure you want to delete "{{ role.name }}"</DialogTitle>
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
