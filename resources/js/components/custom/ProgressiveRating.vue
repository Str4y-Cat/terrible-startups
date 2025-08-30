<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import Progress from '@/components/ui/progress/Progress.vue';
import type { RatingFormData, RatingSystemProps } from '@/types/rating';
import { Check, ChevronLeft, ChevronRight, X } from 'lucide-vue-next';
import { computed, ref } from 'vue';

const props = defineProps<RatingSystemProps>();
const emit = defineEmits<{
    (e: 'submit', data: RatingFormData): void;
    (e: 'skip'): void;
    (e: 'close'): void;
}>();

const currentQuestion = ref(0);
const formData = ref<RatingFormData>({});
const isTransitioning = ref(false);

//are all questions answered
const allAnswered = computed(() => props.questions.every((question) => formData.value[question.id] !== undefined));

//get the current answer
const currentAnswer = computed(() => formData.value[props.questions[currentQuestion.value].id]);

//get the progress
const progress = computed(() => {
    const progress = (Object.keys(formData.value).length / props.questions.length) * 100;
    console.log('this is the progess', progress);
    return progress;
});

function handleChoiceSelect(questionId: string, value: number) {
    //adds a new key to the formdata with the value
    formData.value[questionId] = value;

    //shift the "current look at" value
    if (currentQuestion.value < props.questions.length - 1) {
        currentQuestion.value++;
        // isTransitioning.value = true;
        // setTimeout(() => {
        //     currentQuestion.value++;
        //     isTransitioning.value = false;
        // }, 200);
    }
}

function handleSubmit() {
    emit('submit', formData.value);
    emit('close');
}

function movePrevious() {
    if (currentQuestion.value == 0) return;
    currentQuestion.value--;
}

function moveNext() {
    if (currentQuestion.value == props.questions.length - 1) return;
    currentQuestion.value++;
}
</script>

<template>
    <div v-if="props.isOpen" class="animate-fade-in fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <Card class="animate-bounce-in w-full max-w-lg overflow-hidden bg-white shadow-2xl">
            <!-- Progress Bar -->
            <Progress :model-value="progress" />

            <div class="flex items-center justify-between border-b p-4">
                <div class="text-sm text-muted-foreground">{{ currentQuestion + 1 }} of {{ props.questions.length }}</div>
                <Button variant="ghost" size="sm" @click="emit('close')">
                    <X class="h-4 w-4" />
                </Button>
            </div>

            <CardContent class="p-6">
                <div class="transition" :class="isTransitioning ? 'translate -translate-x-6 opacity-0 duration-200' : ''">
                    <!-- Question Header -->
                    <div class="mb-8 space-y-4 text-center">
                        <h3 class="text-rating-text text-xl font-semibold">
                            {{ props.questions[currentQuestion].heading }}
                        </h3>
                        <p class="leading-relaxed text-muted-foreground">
                            {{ props.questions[currentQuestion].description }}
                        </p>
                    </div>

                    <!-- Choices -->
                    <div class="space-y-3">
                        <Button
                            v-for="(choice, index) in props.questions[currentQuestion].choices"
                            :key="choice.value"
                            variant="outline"
                            @click.prevent="handleChoiceSelect(props.questions[currentQuestion].id, choice.value)"
                            class="h-auto w-full justify-start p-4 text-left transition duration-300 hover:border-primary hover:bg-none"
                            :class="
                                currentAnswer === choice.value
                                    ? 'border-primary bg-primary text-primary-foreground shadow-lg hover:bg-primary'
                                    : 'hover:bg-rating-hover border-rating-border'
                            "
                            :style="{ animationDelay: index * 100 + 'ms' }"
                        >
                            <div class="flex w-full items-center space-x-3">
                                <div
                                    class="flex h-6 w-6 items-center justify-center rounded-full text-xs font-bold transition"
                                    :class="currentAnswer === choice.value ? 'bg-white text-primary' : 'bg-primary/10 text-primary'"
                                >
                                    <Check v-if="currentAnswer === choice.value" class="h-3 w-3" />
                                    <span v-else>{{ choice.value }}</span>
                                </div>
                                <div class="flex-1">
                                    <div class="font-medium">{{ choice.label }}</div>
                                    <div
                                        class="mt-1 text-xs"
                                        :class="currentAnswer === choice.value ? 'text-primary-foreground/80' : 'text-muted-foreground'"
                                    >
                                        {{ choice.description }}
                                    </div>
                                </div>
                            </div>
                        </Button>
                    </div>

                    <!-- Bottom Actions -->
                    <div class="animate-fade-in mt-8 flex items-center justify-between border-t pt-4">
                        <div class="flex gap-4">
                            <Button variant="ghost" :disabled="currentQuestion == 0" @click.prevent="movePrevious">
                                <ChevronLeft class="size-4" />
                                <span>Prev</span>
                            </Button>

                            <Button variant="ghost" :disabled="currentQuestion == props.questions.length - 1" @click.prevent="moveNext">
                                <span>Next</span>
                                <ChevronRight class="size-4" />
                            </Button>
                        </div>

                        <Button v-if="!allAnswered" variant="ghost" @click.prevent="emit('skip')">Skip Survey</Button>
                        <Button @click.prevent="handleSubmit" v-if="allAnswered" class="hover:bg-primary-dark bg-primary"> Complete Survey </Button>
                    </div>
                </div>
            </CardContent>
        </Card>
    </div>
</template>
