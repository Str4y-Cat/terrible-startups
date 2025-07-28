<script setup lang="ts">
import { Calendar, Rocket, Star } from 'lucide-vue-next';
const props = defineProps<{
    title: string;
    handle: string;
    description?: string;
    type: string;
    dateCreated: string;
    rating: int;
}>();
</script>

<template>
    <div
        class="relative flex items-center justify-between overflow-hidden rounded-xl border border-sidebar-border/70 px-6 py-4 dark:border-sidebar-border"
    >
        <div class="flex items-center gap-4">
            <h2 class="text-xl font-bold">{{ props.title }}</h2>
            <div class="flex items-center gap-2 text-white/50">
                <component :is="Rocket" :size="17" />
                {{ props.type }}
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2 text-white/50">
                <component :is="Calendar" :size="17" />
                {{ props.dateCreated }}
            </div>
            <div class="color-primary flex items-center gap-2 text-xl text-primary">
                <component :is="Star" />
                {{ props.rating }}
            </div>
        </div>
    </div>
</template>
