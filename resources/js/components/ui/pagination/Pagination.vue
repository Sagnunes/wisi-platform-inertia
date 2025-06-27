<script setup lang="ts">
import {
    PaginationRoot,
    PaginationList,
    PaginationListItem,
    PaginationEllipsis,
    PaginationFirst,
    PaginationLast,
    PaginationPrev,
    PaginationNext
} from 'reka-ui';

const props = defineProps({
    pagination: {
        type: Object,
        required: true
    }
});

const emit = defineEmits(['page-change']);

const handlePageChange = (page: number) => {
    if (page < 1 || page > props.pagination.last_page) return;
    emit('page-change', page);
};
</script>

<template>
    <PaginationRoot
        :page="pagination.current_page"
        :total="pagination.total"
        :itemsPerPage="pagination.per_page"
        @update:page="handlePageChange"
    >
        <PaginationList v-slot="{ items }" class="flex items-center gap-1">
            <!-- First Page Button -->
            <PaginationFirst
                class=" w-9 h-9 flex items-center justify-center rounded-md border border-gray-200 bg-white hover:bg-gray-50 disabled:opacity-50 transition-colors hover:cursor-pointer"
                :disabled="pagination.current_page === 1"
                @click="handlePageChange(1)"
            >
                &laquo;
            </PaginationFirst>

            <!-- Previous Button -->
            <PaginationPrev
                class="w-9 h-9 flex items-center justify-center rounded-md border border-gray-200 bg-white hover:bg-gray-50 disabled:opacity-50 transition-colors mr-1 hover:cursor-pointer"
                :disabled="pagination.current_page === 1"
                @click="handlePageChange(pagination.current_page - 1)"
            >
                &lsaquo;
            </PaginationPrev>

            <!-- Page Numbers -->
            <template v-for="(page, index) in items" :key="index">
                <PaginationListItem
                    v-if="page.type === 'page'"
                    :value="page.value"
                    class="w-9 h-9 flex items-center justify-center rounded-md border border-gray-200 transition-colors hover:cursor-pointer"
                    :class="{
                        'bg-primary text-white border-primary': page.value === pagination.current_page,
                        'bg-white hover:bg-gray-50': page.value !== pagination.current_page
                    }"
                >
                    {{ page.value }}
                </PaginationListItem>

                <PaginationEllipsis
                    v-else
                    class="w-9 h-9 flex items-center justify-center hover:cursor-pointer"
                >
                    ...
                </PaginationEllipsis>
            </template>

            <!-- Next Button -->
            <PaginationNext
                class="w-9 h-9 flex items-center justify-center rounded-md border border-gray-200 bg-white hover:bg-gray-50 disabled:opacity-50 transition-colors ml-1 hover:cursor-pointer"
                :disabled="pagination.current_page === pagination.last_page"
                @click="handlePageChange(pagination.current_page + 1)"
            >
                &rsaquo;
            </PaginationNext>

            <!-- Last Page Button -->
            <PaginationLast
                class="w-9 h-9 flex items-center justify-center rounded-md border border-gray-200 bg-white hover:bg-gray-50 disabled:opacity-50 transition-colors hover:cursor-pointer"
                :disabled="pagination.current_page === pagination.last_page"
                @click="handlePageChange(pagination.last_page)"
            >
                &raquo;
            </PaginationLast>
        </PaginationList>
    </PaginationRoot>
</template>

<style scoped>
[data-reka-pagination-item][data-selected] {
    background-color: #4f46e5;
    color: white;
    border-color: #4f46e5;
}
</style>
