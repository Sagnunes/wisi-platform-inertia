<script setup lang="ts">
import type { StatusDTO } from '@/types/admin-panel/types';
import { computed } from 'vue';

interface ColorScheme {
    bg: string;
    text: string;
    ring: string;
}

type ValidStatusName = 'Pendente' | 'Ativo' | 'Bloqueado';

const statusTranslation: Record<string, ValidStatusName> = {
    Pending: 'Pendente',
    Active: 'Ativo',
    Blocked: 'Bloqueado',
} as const;

const STATUS_COLORS: Record<ValidStatusName, ColorScheme> = {
    Pendente: {
        bg: 'bg-yellow-50',
        text: 'text-yellow-700',
        ring: 'ring-yellow-600/20',
    },
    Ativo: {
        bg: 'bg-green-50',
        text: 'text-green-700',
        ring: 'ring-green-600/20',
    },
    Bloqueado: {
        bg: 'bg-red-50',
        text: 'text-red-700',
        ring: 'ring-red-600/20',
    },
} as const;

const props = defineProps<{
    status: StatusDTO;
}>();

const translatedStatus = computed(() => {
    return statusTranslation[props.status.name] || 'Pendente';
});

const badgeClasses = computed(() => {
    const colors = STATUS_COLORS[translatedStatus.value];
    return [colors.bg, colors.text, colors.ring].join(' ');
});
</script>

<template>
    <span
        class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset"
        :class="badgeClasses"
    >
        {{ translatedStatus }}
    </span>
</template>
