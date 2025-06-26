<!-- @/components/ui/FlashMessage.vue -->
<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { ref, watch, onUnmounted, computed } from 'vue';

const page = usePage();
const show = ref(false);
const message = ref('');
const type = ref<'success' | 'error' | 'warning' | 'info'>('success');
let timeoutId: ReturnType<typeof setTimeout> | null = null;

// Watch for any flash message changes
watch(
    () => page.props.flash,
    (newFlash) => {
        // Clear existing timeout
        if (timeoutId) {
            clearTimeout(timeoutId);
            timeoutId = null;
        }

        // Determine which message type is present
        const flashTypes = ['success', 'error', 'warning', 'info'] as const;
        const activeType = flashTypes.find(t => newFlash[t]);

        if (activeType) {
            type.value = activeType;
            message.value = newFlash[activeType] as string;
            show.value = true;

            // Auto-dismiss after 3 seconds
            timeoutId = setTimeout(() => {
                show.value = false;
            }, 3000);
        } else {
            show.value = false;
        }
    },
    { deep: true, immediate: true }
);

// Cleanup on unmount
onUnmounted(() => {
    if (timeoutId) clearTimeout(timeoutId);
});

// Dynamic classes based on message type
const containerClasses = computed(() => {
    const base = "fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg transition-opacity duration-300";
    const typeClasses = {
        success: "bg-green-100 border border-green-400 text-green-700",
        error: "bg-red-100 border border-red-400 text-red-700",
        warning: "bg-yellow-100 border border-yellow-400 text-yellow-700",
        info: "bg-blue-100 border border-blue-400 text-blue-700"
    };
    return `${base} ${typeClasses[type.value]}`;
});
</script>

<template>
    <div v-if="show" :class="containerClasses" role="alert">
        {{ message }}
    </div>
</template>
