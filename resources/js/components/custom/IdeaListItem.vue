<script setup lang="ts">
import { Calendar, Rocket, Star } from 'lucide-vue-next';
import { computed } from 'vue';
const props = defineProps<{
    title: string;
    handle: string;
    description?: string;
    type: string;
    dateCreated: string;
    rating: number;
}>();

const starClass = computed(() => {
    const rating = props.rating;

    if (rating >= 75) return 'idea-best';
    if (rating < 75 && rating >= 50) return 'idea-average';
    if (rating < 50 && rating >= 25) return 'idea-bad';
    return 'idea-terrible';
});

console.log(starClass.value);
</script>

<template>
    <div
        class="relative flex items-center justify-between overflow-hidden rounded-xl border bg-muted/20 px-6 py-4 transition-colors"
        :class="{
            'border-idea-best/10 hover:border-idea-best/30': props.rating >= 75,
            'border-idea-average/10 hover:border-idea-average/30': rating < 75 && rating >= 50,
            'border-idea-bad/10 hover:border-idea-bad/30': rating < 50 && rating >= 25,
            'border-idea-terrible/10 hover:border-idea-terrible/30': rating < 25,
        }"
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
            <div class="color-primary flex items-center gap-2" :class="`text-${starClass}`">
                <component :is="Star" :size="17" fill="currentColor" :class="`fill-${starClass}`" />
                {{ props.rating }}
            </div>
        </div>
    </div>
</template>
