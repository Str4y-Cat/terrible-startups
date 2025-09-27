<script setup lang="ts">
import Progress from '@/components/ui/progress/Progress.vue';
import { Rating } from '@/types/rating';
import { computed, ref } from 'vue';
import ProgressiveRatingDialog from '../ProgressiveRatingDialog.vue';
const props = defineProps<{
    rating: Rating;
}>();

const ratingTotal =
    props.rating.answers.length > 0
        ? props.rating.answers.reduce((sum, cur) => {
              return (sum *= cur.score);
          }, 1)
        : -1;

const ratingResults = {
    broken: {
        title: 'Oh no',
        description: 'Looks like something broke. Please redo your rating',
    },
    terrible: {
        title: 'Wonderfully terrible',
        description: 'You have scored 1 or more questions as a 0. This makes the entire idea moot. Reposition your idea, or try something else',
    },
    bad: {
        title: "It's quite weak",
        description: 'Keen for pain? This is what this idea will bring.',
    },
    average: {
        title: 'Almost there',
        description: "It's not quite there, do some more research or try improve the idea a bit before continuing",
    },
    good: {
        title: "You're onto something",
        description: 'Your idea is solid and worth exploring',
    },
    exceptional: {
        title: 'This is exceptional',
        description: 'The idea is great. Move fast',
    },
};

const ratingResult = computed(() => {
    const thresholds = [
        { limit: 0, result: ratingResults.broken },
        { limit: 1, result: ratingResults.terrible },
        { limit: 10, result: ratingResults.bad },
        { limit: 20, result: ratingResults.average },
        { limit: 100, result: ratingResults.good },
    ];

    const match = thresholds.find((threshold) => ratingTotal < threshold.limit);
    return match ? match.result : ratingResults.exceptional;
});

function getAnswer(questionId: number | string): { question_id: number; score: number } | undefined {
    return props.rating.answers.find((answer) => {
        return answer.question_id == +questionId;
    });
}

const openRatingDialog = ref(false);
</script>
<template>
    <div @click="openRatingDialog = true" class="mx-auto mt-8 w-full cursor-pointer rounded-lg">
        <div class="mb-4 flex gap-4">
            <div
                class="flex aspect-1/1 h-20 w-20 items-center justify-center rounded-full text-2xl"
                :class="{
                    'bg-red-600/10 text-red-600': ratingTotal < 20,
                    'bg-orange-600/10 text-orange-600': ratingTotal >= 20 && ratingTotal < 80,
                    'bg-green-600/10 text-green-600': ratingTotal >= 80,
                }"
            >
                {{ ratingTotal }}
            </div>
            <div class="flex flex-col gap-2">
                <h3 class="text-xl font-bold">
                    {{ ratingResult.title }}
                </h3>
                <p class="text-muted-foreground">
                    {{ ratingResult.description }}
                </p>
            </div>
        </div>

        <div class="space-y-4 pt-0 pt-4">
            <div v-for="(item, index) in rating.questions" :key="index" class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="font-medium">{{ item.heading }}</span>
                    <span class="text-muted-foreground" :class="{ 'text-red-600': getAnswer(item.id)?.score == 0 }"
                        >{{ getAnswer(item.id)?.score }}/3</span
                    >
                </div>

                <Progress :modelValue="((getAnswer(item.id)?.score ?? 0) / 3) * 100" class="h-1.5" />
            </div>
        </div>
    </div>

    <ProgressiveRatingDialog
        v-model="openRatingDialog"
        :questions="rating.questions"
        :disabled="false"
        :processing="false"
        @close="openRatingDialog = false"
    />
</template>
