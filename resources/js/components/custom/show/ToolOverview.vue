<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { useSlots } from 'vue';
defineProps<{
    type: string;
    idea_id: number;
}>();
const slots = useSlots();
</script>
<template>
    <Link
        :href="`${route('tool', idea_id)}?type=${type}`"
        class="group relative flex h-full w-full items-start justify-start gap-2 rounded border border-border p-4 transition-colors hover:border-primary"
    >
        <div v-if="slots.icon" class="rounded-full bg-muted p-2">
            <slot name="icon"></slot>
        </div>
        <div>
            <div class="flex w-full items-center justify-start gap-2">
                <h3 class="flex font-bold"><slot /></h3>
            </div>
            <p class="block text-muted-foreground"><slot name="description" /></p>
        </div>
    </Link>
</template>
