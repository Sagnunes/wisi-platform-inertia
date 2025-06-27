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
import { useForm } from '@inertiajs/vue3';
import { PropType } from 'vue';

const props = defineProps({
    resource: {
        type: Object as PropType<Record<string, any>>,
        required: true,
    },
    routeName: {
        type: String,
        required: true,
    },
    resourceName: {
        type: String,
        required: true,
    },
    currentPage: {
        type: Number,
        default: 1,
    },
    identifierKey: {
        type: String,
        default: 'id',
    },
});

const emit = defineEmits(['deleted']);

const form = useForm({});

const closeModal = () => {
    form.clearErrors();
    form.reset();
};

const deleteResource = () => {
    const params = {
        [props.resourceName]: props.resource[props.identifierKey],
        page: props.currentPage,
    };

    form.delete(route(props.routeName, params), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            emit('deleted');
            closeModal();
        },
    });
};
</script>

<template>
    <Dialog>
        <DialogTrigger>
            <slot name="trigger">
                <Button variant="link" class="hover:cursor-pointer">Delete</Button>
            </slot>
        </DialogTrigger>
        <DialogContent>
            <form @submit.prevent="deleteResource">
                <DialogHeader class="space-y-3">
                    <DialogTitle>
                        Are you sure you want to delete "{{ resource.name || resource.title }}"
                    </DialogTitle>
                    <DialogDescription>
                        Once the {{ resourceName }} is deleted, all of its resources and data will
                        also be permanently deleted.
                    </DialogDescription>
                </DialogHeader>
                <DialogFooter>
                    <DialogClose as-child>
                        <Button variant="secondary" @click="closeModal">Cancel</Button>
                    </DialogClose>
                    <Button variant="destructive" :disabled="form.processing"> Delete </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>
