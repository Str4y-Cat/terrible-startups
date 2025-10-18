<script setup lang="ts">
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';

defineProps<{
    index: number;
    item: { title: string; description: string };
}>();
</script>
<template>
    <div class="items-c grid w-full gap-4 sm:grid-cols-2">
        <div class="max-w-140">
            <h2 class="mb-2 text-left text-lg font-bold text-primary">Step {{ index }}</h2>
            <h3 class="mb-2 text-left text-3xl font-bold">{{ item.title }}</h3>
            <p class="text-left text-lg/8">{{ item.description }}</p>
        </div>
        <div class="w-full">
            <div class="relative aspect-square w-full overflow-hidden rounded-2xl border border-4 sm:aspect-6/4">
                <PlaceholderPattern class="!stoke-muted-foreground" />
            </div>
        </div>
    </div>
</template>
