<script setup lang="ts">
import InputError from '@/components/InputError.vue';
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
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    name: '',
    description: '',
});

const showCreateDialog = ref(false);

const closeModal = () => {
    form.clearErrors();
    form.reset();
    showCreateDialog.value = false;
};

const createStatus = () => {
    form.post(route('statuses.store'), {
        onSuccess: () => closeModal(),
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <Dialog :open="showCreateDialog" @update:open="showCreateDialog = $event">
        <DialogTrigger>
            <Button variant="link" class="hover:cursor-pointer">New Status</Button>
        </DialogTrigger>
        <DialogContent>
            <form @submit.prevent="createStatus" class="space-y-6">
                <DialogHeader class="space-y-3">
                    <DialogTitle>Create a new Status</DialogTitle>
                    <DialogDescription> Fill the required input</DialogDescription>
                </DialogHeader>
                <div class="grid gap-2">
                    <Label for="name" class="sr-only">Name</Label>
                    <Input id="name" type="text" name="name" ref="nameInput" v-model="form.name" placeholder="Name" v-bind="$attrs" />
                    <InputError :message="form.errors.name" />
                </div>

                <div class="grid gap-2">
                    <Label for="description" class="sr-only">Description</Label>
                    <Input id="description" type="text" name="description" v-model="form.description" placeholder="Description" />
                    <InputError :message="form.errors.description" />
                </div>

                <DialogFooter class="gap-2">
                    <DialogClose as-child>
                        <Button variant="secondary" @click="closeModal"> Cancel</Button>
                    </DialogClose>
                    <Button type="submit" variant="default" :disabled="form.processing">Create</Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>

<style scoped></style>
