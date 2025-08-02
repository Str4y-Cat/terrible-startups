<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { useIntersectionObserver } from '@vueuse/core';
import { computed, ref, useTemplateRef } from 'vue';
import Progress from '../ui/progress/Progress.vue';
import ScrollArea from '../ui/scroll-area/ScrollArea.vue';
import RatingSlider from './RatingSlider.vue';

interface Rating {
    label: string;
    description: string;
    value: number;
}
const props = defineProps<{
    disabled?: boolean;
    onSubmit: CallableFunction;
    ratings: Rating[];
}>();

// const ratings = reactive(props.ratings);

const progress = computed(() => {
    const total = props.ratings.length;
    const current = props.ratings.reduce((sum: any, cur: any) => {
        if (cur.value > -1) return (sum = sum + 1);
        return sum;
    }, 0);
    return Math.floor((current / total) * 100);
});
const progressFull = computed(() => {
    return progress.value == 100;
});

const target = useTemplateRef<HTMLDivElement>('target');
const targetIsVisible = ref(false);
const { stop } = useIntersectionObserver(target, ([entry], observerElement) => {
    targetIsVisible.value = entry?.isIntersecting || false;
});

// const progress = ref(0);
//
// const updateProgress = () => {
//     const total = ratings.length;
//     const current = ratings.reduce((sum: any, cur: any) => {
//         if (cur.value > -1) return (sum = sum + 1);
//         return sum;
//     }, 0);
//     // console.log('update progress: ', current, total);
//     progress.value = Math.floor((current / total) * 100);
// };
// console.log;
</script>

<template>
    <Dialog>
        <DialogTrigger
            :disabled="props.disabled"
            class="fixed right-4 bottom-4 inline-flex h-9 shrink-0 items-center justify-center gap-2 rounded-md bg-primary px-4 py-2 text-sm font-medium whitespace-nowrap text-primary-foreground shadow-xs transition-all outline-none hover:bg-primary/90 focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50 disabled:pointer-events-none disabled:translate-y-[200%] disabled:opacity-50 has-[>svg]:px-3 aria-invalid:border-destructive aria-invalid:ring-destructive/20 sm:static sm:disabled:translate-0 dark:aria-invalid:ring-destructive/40 [&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*=\'size-\'])]:size-4"
        >
            Create
        </DialogTrigger>
        <DialogContent class="">
            <DialogHeader>
                <DialogTitle>Rate your idea</DialogTitle>
                <DialogDescription>Be as objective as you can. Err on the pesimistic side if you are unsure</DialogDescription>
            </DialogHeader>
            <ScrollArea class="relative grid max-h-[50vh] py-6">
                <RatingSlider
                    v-for="(rating, index) in props.ratings"
                    :key="index"
                    :label="rating.label"
                    :description="rating.description"
                    :ref="index == props.ratings.length - 1 ? 'target' : ''"
                    :currentValue="rating.value"
                    @rating="
                        (x) => {
                            // ratings[index].value = x;
                            // updateProgress();
                            // console.log(ratings);
                            // console.log(progress);
                            $emit('update', { index: index, value: x });
                        }
                    "
                />
                <div
                    :class="{
                        'h-0': targetIsVisible,
                        'h-50': !targetIsVisible,
                    }"
                    class="focus-target pointer-events-none absolute bottom-5 w-full bg-linear-to-t from-background to-background/0 transition-[height] duration-500"
                ></div>
            </ScrollArea>

            <DialogFooter>
                <div class="flex w-full items-center gap-4">
                    <div class="w-full">
                        <Progress
                            :model-value="progress"
                            class="transition-opacity delay-200"
                            :class="{
                                'opacity-0': progressFull,
                            }"
                        ></Progress>
                    </div>
                    <div>
                        <Button @click="onSubmit" :variant="progressFull ? 'default' : 'ghost'">{{ progressFull ? 'Create' : 'Skip' }}</Button>
                    </div>
                </div>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
