<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { computed, reactive } from 'vue';
import Progress from '../ui/progress/Progress.vue';
import ScrollArea from '../ui/scroll-area/ScrollArea.vue';
import RatingSlider from './RatingSlider.vue';
const props = defineProps<{
    disabled?: boolean;
}>();

const ratings = reactive([
    { label: 'Urgency', description: 'How badly do users want this?', value: -1 },
    { label: 'Market Size', description: 'How many people are already purchasing things like this?', value: -1 },
    { label: 'Pricing Potential', description: 'How high can you sell this for?', value: -1 },
    { label: 'Customer Aquisition Cost', description: 'How much will it cost to generate a sale?', value: -1 },
    { label: 'Value Delivery Cost', description: 'How much time/effort is required to deliver value?', value: -1 },
    { label: 'Uniqueness', description: 'How unique is your offer compared to competitors?', value: -1 },
    { label: 'Speed to marker', description: 'How soon can you create something to sell?', value: -1 },
    { label: 'Up-front investment', description: 'How much do you need to invest to start selling?', value: -1 },
    { label: 'Upsell potential', description: 'Are there secondary offers you can present to customers?', value: -1 },
    { label: 'Evergreen Potential', description: 'Once created, how much additional effort is required to continue selling?', value: -1 },
]);

const progress = computed(() => {
    const total = ratings.length;
    const current = ratings.reduce((sum: any, cur: any) => {
        if (cur.value > -1) return (sum = sum + 1);
        return sum;
    }, 0);
    // console.log('update progress: ', current, total);
    return Math.floor((current / total) * 100);
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
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Rate your idea</DialogTitle>
                <DialogDescription>Be as objective as you can. Err on the pesimistic side if you are unsure</DialogDescription>
            </DialogHeader>
            <ScrollArea class="grid max-h-[50vh] py-6">
                <RatingSlider
                    v-for="(rating, index) in ratings"
                    :key="index"
                    :label="rating.label"
                    :description="rating.description"
                    @rating="
                        (x) => {
                            ratings[index].value = x;
                            // updateProgress();
                            // console.log(ratings);
                            console.log(progress);
                        }
                    "
                />
            </ScrollArea>
            <Progress
                :model-value="progress"
                :class="{
                    'opacity-0': progress == 100,
                }"
            ></Progress>

            <DialogFooter>
                <Button :disabled="progress != 100">Done</Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
