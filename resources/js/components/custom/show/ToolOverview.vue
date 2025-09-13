<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { useSlots } from 'vue';
const props = defineProps<{
    route_name: string;
    idea_id: string;
}>();
const slots = useSlots();
</script>
<template>
    <Link
        :href="route(route_name, idea_id)"
        class="group relative flex h-full w-full items-start justify-start gap-2 rounded border border-border p-4 transition-colors hover:border-primary"
    >
        <div v-if="slots.icon" class="rounded-full bg-muted p-2">
            <slot name="icon"></slot>
        </div>
        <div>
            <div class="flex w-full items-center justify-start gap-2">
                <h3 class="flex font-bold"><slot /></h3>
            </div>
            <p class="block"><slot name="description" /></p>
        </div>
        <PlaceholderPattern class="opacity-40" />
    </Link>
</template>
