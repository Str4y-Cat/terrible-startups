<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Calendar, Dot, Pin, Star } from 'lucide-vue-next';
import { computed } from 'vue';
const props = defineProps<{
    title: string;
    handle: string;
    description?: string;
    type: string;
    dateCreated: string;
    rating: number;
    pinned?: boolean;
    link: string;
}>();

const starClass = computed(() => {
    const rating = props.rating;

    if (rating >= 75) return 'idea-best';
    if (rating < 75 && rating >= 50) return 'idea-average';
    if (rating < 50 && rating >= 25) return 'idea-bad';
    return 'idea-terrible';
});
</script>

<template>
    <div
        class="relative flex items-center justify-between overflow-hidden rounded-xl border border-muted/50 bg-muted/20 px-4 transition-colors hover:border-muted sm:px-6"
    >
        <Link :href="props.link" class="flex w-full items-center justify-between">
            <div class="flex flex-col py-2 xs:flex-row xs:items-center xs:gap-4 xs:py-4">
                <h2 class="font-bold sm:text-xl">{{ props.title }}</h2>
                <div class="flex items-center gap-2 text-white/50">
                    <component :is="Dot" :size="17" class="hidden xs:block" />
                    {{ props.type }}
                </div>
            </div>

            <div class="flex h-full items-center gap-4">
                <div class="hidden items-center gap-2 text-white/50 sm:flex">
                    <component :is="Calendar" :size="17" />
                    {{ props.dateCreated }}
                </div>
                <div
                    class="color-primary flex items-center gap-2"
                    :class="{
                        'text-idea-best': props.rating >= 75,
                        'text-idea-average': rating < 75 && rating >= 50,
                        'text-idea-bad': rating < 50 && rating >= 25,
                        'text-idea-terrible': rating < 25,
                    }"
                >
                    <component :is="Star" :size="17" :class="[`fill-current`]" />
                    {{ props.rating }}
                </div>
            </div>
        </Link>

        <button
            @click="$emit('pinned', !pinned)"
            class="color-foreground ms-4 flex cursor-pointer items-center gap-2 rounded-xl border border-transparent p-2 hover:border-muted"
        >
            <component :is="Pin" :size="17" :class="[{ 'fill-foreground': pinned }]" />
        </button>
    </div>
</template>
