<script setup lang="ts">
import { createReusableTemplate, useMediaQuery } from "@vueuse/core"
import { Button } from '@/components/ui/button';
import { CardContent } from '@/components/ui/card';
import Progress from '@/components/ui/progress/Progress.vue';
import type { RatingFormData, RatingSystemProps } from '@/types/rating';
import { Star, Check, ChevronLeft, ChevronRight, LoaderCircle } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from "@/components/ui/dialog"
import {
  Drawer,
  DrawerClose,
  DrawerContent,
  DrawerDescription,
  DrawerFooter,
  DrawerHeader,
  DrawerTitle,
  DrawerTrigger,
} from "@/components/ui/drawer"

const [UseTemplate, ProgressiveRatingForm] = createReusableTemplate()
const isDesktop = useMediaQuery("(min-width: 768px)")

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
    console.log(progress)
    return progress;
});

function handleChoiceSelect(questionId: string, value: number) {
    //adds a new key to the formdata with the value
    formData.value[questionId] = value;

    //shift the "current look at" value
    if (currentQuestion.value < props.questions.length) {
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
    if (currentQuestion.value == props.questions.length) return;
    currentQuestion.value++;
}

const ratingTotal = computed(()=>{
    let total = 1;
    for (const key in formData.value) {
        if (formData.value[key] != undefined) {
            total *= formData.value[key];
        }
    }
    return total;
})
const isOpen = ref(false)

</script>

<template>

    <UseTemplate>
            <CardContent class="p-6">
                <div class="transition" :class="isTransitioning ? 'translate -translate-x-6 opacity-0 duration-200' : ''">
                    <!-- Question Header -->
                    <div v-if="currentQuestion != props.questions.length">
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
                                class="h-auto w-full justify-start p-4 text-left transition duration-300 hover:border-primary/50 hover:bg-background"
                                :class="currentAnswer === choice.value ? 'border-primary' : ''"
                                :style="{ animationDelay: index * 100 + 'ms' }"
                            >
                                <div class="flex w-full items-center space-x-3">
                                    <div
                                        class="flex h-6 w-6 items-center justify-center rounded-full text-xs font-bold transition"
                                        :class="currentAnswer === choice.value ? 'bg-primary text-white' : 'bg-primary/10 text-primary'"
                                    >
                                        <Check v-if="currentAnswer === choice.value" class="h-3 w-3" />
                                        <span v-else>{{ choice.value }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <div class="font-medium">{{ choice.label }}</div>
                                        <div class="mt-1 text-xs text-muted-foreground">
                                            {{ choice.description }}
                                        </div>
                                    </div>
                                </div>
                            </Button>
                        </div>
                    </div>


                    <!-- Success -->
                    <div v-if="currentQuestion == props.questions.length">
                        <div class="flex w-full justify-center flex-col items-center">
                            <div class='w-full flex items-center gap-4'>
                                <div class="flex w-fit gap-2 items-center">
                                    <Star class="size-10"/>
                                    <h1 class="text-4xl">{{ratingTotal}}</h1>
                                </div>
                                <div class='w-fit'>

                                <h2 class="text-4xl">Not bad!</h2>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- Bottom Actions -->
                    <div class="animate-fade-in mt-8 flex items-center justify-between border-t pt-4">
                        <div class="flex gap-4">
                            <Button variant="ghost" :disabled="currentQuestion == 0" @click.prevent="movePrevious">
                                <ChevronLeft class="size-4" />
                                <span>Prev</span>
                            </Button>

                            <Button variant="ghost" :disabled="currentQuestion == props.questions.length " @click.prevent="moveNext" v-if="currentQuestion != props.questions.length" :model-value="progress">
                                <span>Next</span>
                                <ChevronRight class="size-4" />
                            </Button>
                        </div>

                        <Button v-if="!allAnswered" variant="ghost" @click.prevent="emit('skip')" :disabled>
                            <span v-if="!props.processing">Create without rating</span>
                            <span v-if="props.processing" class="flex gap-2 flex-nowrap">
                                <LoaderCircle  class="h-4 w-4 animate-spin" />
                                Submitting
                            </span>
                        </Button>

                        <Button @click.prevent="handleSubmit" :disabled="props.processing" v-if="allAnswered" class="hover:bg-primary-dark bg-primary">
                            <span v-if="!props.processing">Complete</span>

                            <span v-if="props.processing" class="flex gap-2 flex-nowrap">
                                <LoaderCircle  class="h-4 w-4 animate-spin" />
                                Submitting
                            </span>

                    </Button>
                    </div>
                </div>
            </CardContent>
    </UseTemplate>


    <Dialog v-if="isDesktop" v-model:open="isOpen">
        <DialogTrigger as-child>
            <Button :disabled="props.disabled" >
                Create
            </Button>
        </DialogTrigger>

        <DialogContent class="">
            <DialogTitle class="text-muted-foreground text-sm">Idea rating</DialogTitle>
            <div class="flex items-center justify-between border-b p-4" v-if="currentQuestion != props.questions.length"  >
                <div class="min-w-15 text-sm text-muted-foreground">{{ currentQuestion<props.questions.length? currentQuestion + 1: props.questions.length }} of {{ props.questions.length }}</div>
                <Progress  class="h-1" :model-value="progress"/>
            </div>

            <!-- Rating form -->
            <ProgressiveRatingForm/>
        </DialogContent>
    </Dialog>

<Drawer v-else v-model:open="isOpen">
    <DrawerTrigger as-child>
      <Button :disabled="props.disabled" class="fixed right-4 bottom-20 sm:static">
            Create
      </Button>
    </DrawerTrigger>

    <DrawerContent>
        <DrawerHeader>
            <DrawerTitle class="sr-only">Progressive Rating form</DrawerTitle>
        </DrawerHeader>
    <ProgressiveRatingForm/>
    <Progress  class="h-1" :model-value="progress"/>
      <DrawerFooter v-if="false" class="pt-2">
        <DrawerClose as-child>
          <Button variant="outline">
            Cancel
          </Button>
        </DrawerClose>
      </DrawerFooter>
    </DrawerContent>
  </Drawer>

</template>
