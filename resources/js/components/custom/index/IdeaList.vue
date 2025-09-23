<script setup lang="ts">
import { Idea } from '@/types/general';
import { router } from '@inertiajs/vue3';
import Tag from '../Tag.vue';

const props = defineProps<{
    ideas: Idea[];
}>();

const visit = (val: number) => {
    router.visit(`/ideas/${val}`);
};
</script>

<template>
    <div class="flex flex-col">
        <template v-for="idea in props.ideas" :key="idea.id">
            <div @click="visit(idea.id)" class="flex w-full gap-2 pt-4 hover:bg-muted sm:gap-4">
                <div class="ps-4">
                    <div
                        class="flex aspect-1/1 w-10 items-center justify-center rounded-full"
                        :class="{
                            'bg-red-600/10 text-red-600': idea.rating < 20,
                            'bg-orange-600/10 text-orange-600': idea.rating >= 20 && idea.rating < 80,
                            'bg-green-600/10 text-green-600': idea.rating >= 80,
                        }"
                    >
                        {{ idea.rating }}
                    </div>
                </div>

                <div class="flex w-full border border-transparent border-b-border pe-4 pb-4">
                    <div class="flex-grow">
                        <div class="flex justify-between">
                            <div class="font-bold">
                                {{ idea.title }}
                            </div>
                            <div v-if="false" class="text-sm text-foreground/50">{{ idea.date_created }}</div>
                            <div class="hidden flex-wrap justify-end gap-2 sm:flex">
                                <Tag
                                    v-for="(tag, index) in idea.tags"
                                    :key="index"
                                    class="border-none bg-primary/10 text-xs text-primary md:text-sm"
                                    >{{ tag.value }}</Tag
                                >
                            </div>
                        </div>
                        <div class="sm:max-w-[60%]">
                            <p class="line-clamp-2 overflow-hidden text-ellipsis">{{ idea.overview }}</p>
                        </div>
                        <div class="mt-2 flex flex-wrap gap-2 sm:hidden">
                            <Tag
                                v-for="(tag, index) in idea.tags"
                                :key="tag.value"
                                class="border-none bg-primary/10 text-xs text-primary md:text-sm"
                                >{{ tag.value }}</Tag
                            >
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</template>
