<script setup lang="ts">
import Collapsiable from '@/components/custom/Collapsiable.vue';
import BulletTextInput from '@/components/custom/create/BulletTextInput.vue';
import TextInput from '@/components/custom/create/TextInput.vue';
import ProgressiveRatingDialog from '@/components/custom/ProgressiveRatingDialog.vue';
import TagInputGroup from '@/components/custom/TagInputGroup.vue';
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { RatingAnswer, RatingQuestion } from '@/types/rating';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
// import { toast } from 'vue-sonner';
import { errorToast } from '@/composables/useErrorToast';

const idea_title = ref('New idea');

const breadcrumbs = computed<BreadcrumbItem[]>(() => {
    return [
        {
            title: 'Ideas',
            href: '/ideas',
        },
        {
            title: idea_title.value,
            href: '/ideas/create',
        },
    ];
});

const page = usePage();
const rating_questions = page.props.rating_questions as RatingQuestion[];

//sets the select types
// const businessTypes = ['Product', 'Service', 'Hello'];

//REFACTOR: move this to an interface. update rating_questions to rating_answers
const form = useForm<{
    title?: string;
    rating?: number;
    overview?: string;
    type?: string;
    problem_to_solve?: string;
    inspiration?: string;
    solution?: string;
    features?: string[];
    target_audience?: string[];
    risks?: string[];
    challenges?: string[];
    rating_questions?: RatingAnswer[];
    tags?: { key: string; value: string }[];
}>({
    title: '',
    rating: 0,
    overview: '',
    type: '',
    problem_to_solve: '',
    inspiration: '',
    solution: '',
    features: [''],
    target_audience: [''],
    risks: [''],
    challenges: [''],
    tags: [],
    rating_questions: [{ question_id: 0, score: 0 }],
});

const submit = () => {
    // form.rating_questions = [...stripratingsforsubmit()];
    form.post(route('ideas.store'), {
        onFinish: () => {
            /*navigate to form */
        },
        //REFACTOR: move this to a composable, with the option for title,description. useErrorToast
        onError: (error) => {
            errorToast('Failed to save', error);
            console.log(error);
        },
    });
};

//Determines whether all required fields are filled
const requiredFields: string[] = ['title'];
const canSubmit = computed(() => {
    return requiredFields.every((field) => {
        const value = form[field];
        return value !== null && value !== undefined && value.toString().trim() !== '' && !form.processing;
    });
});

const isRatingOpen = ref(false);

console.log(page.props.tagGroups);
console.log(rating_questions);
</script>

<template>
    <Head title="New terrible idea" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="relative m-auto w-full max-w-4xl rounded-xl">
                <form @submit.prevent="submit" class="flex flex-col gap-6 px-2 pt-8 sm:px-4">
                    <!--TITLE-->
                    <div class="mb-4 flex justify-between gap-4">
                        <div class="h-fit w-full">
                            <Input
                                id="title"
                                type="text"
                                required
                                autofocus
                                :tabindex="0"
                                @update="
                                    (val: string) => {
                                        idea_title = val;
                                    }
                                "
                                v-model="form.title"
                                class="rounded-none border-none bg-transparent p-0 text-3xl font-bold focus-visible:ring-0 md:text-3xl dark:bg-transparent"
                                placeholder="Untitled"
                            />
                            <InputError :message="form.errors.title" />
                        </div>

                        <ProgressiveRatingDialog
                            v-model="isRatingOpen"
                            :questions="rating_questions"
                            :disabled="!canSubmit"
                            :processing="form.processing"
                            @submit="
                                (ratings) => {
                                    form.rating = 0;
                                    form.rating_questions = ratings;
                                    submit();
                                }
                            "
                            @skip="submit"
                        >
                            <Button :disabled="!canSubmit" @click.prevent="isRatingOpen = true" class="fixed right-4 bottom-20 sm:static sm:block">
                                <span v-if="form.processing" class="flex items-center gap-2">
                                    Submitting
                                    <LoaderCircle class="h-4 w-4 animate-spin" />
                                </span>
                                <span v-else> Create </span>
                            </Button>
                        </ProgressiveRatingDialog>

                        <InputError :message="form.errors.rating_questions" />
                    </div>

                    <div class="">
                        <div class="grid gap-4">
                            <!-- OVERVIEW -->
                            <TextInput
                                :modelValue="form.overview"
                                :error="form.errors.overview"
                                :required="true"
                                label="Overview"
                                id="overview"
                                @update="(value) => (form.overview = value)"
                            ></TextInput>

                            <!-- Inspiration for Idea -->
                            <TextInput
                                :modelValue="form.inspiration"
                                :error="form.errors.inspiration"
                                label="Inspiration"
                                id="inspiration"
                                @update="(value) => (form.inspiration = value)"
                            ></TextInput>

                            <!-- Problem to Solve -->
                            <TextInput
                                :modelValue="form.problem_to_solve"
                                :error="form.errors.problem_to_solve"
                                label="Problem to solve"
                                id="problem_to_solve"
                                @update="(value) => (form.problem_to_solve = value)"
                            ></TextInput>

                            <!-- Proposed Solution -->
                            <TextInput
                                :modelValue="form.solution"
                                :error="form.errors.solution"
                                label="Solution"
                                id="solution"
                                @update="(value) => (form.solution = value)"
                            ></TextInput>

                            <TagInputGroup title="Tags" :tag_group="$page.props.tagGroups" v-model:selected="form.tags"></TagInputGroup>
                        </div>

                        <div class="grid gap-4">
                            <Collapsiable>
                                <!-- Features -->

                                <!--
                                <TextInput
                                    :modelValue="form.features"
                                    :error="form.errors.features"
                                    label="Features"
                                    id="features"
                                    @update="(value) => (form.features = value)"
                                ></TextInput>
                                -->

                                <BulletTextInput
                                    :modelValue="form.features"
                                    :error="form.errors.features"
                                    label="Features"
                                    id="features"
                                    @update:modelValue="
                                        (value) => {
                                            form.features = value;
                                        }
                                    "
                                ></BulletTextInput>

                                <!-- Description of Target Audience -->
                                <!--
                                <TextInput
                                    :modelValue="form.target_audience"
                                    :error="form.errors.target_audience"
                                    label="Target audiences"
                                    id="target_audience"
                                    @update="(value) => (form.target_audience = value)"
                                ></TextInput>
                                -->
                                <BulletTextInput
                                    :modelValue="form.target_audience"
                                    :error="form.errors.target_audience"
                                    label="Target audiences"
                                    id="target_audience"
                                    @update="(value) => (form.target_audience = value)"
                                ></BulletTextInput>

                                <!-- Risks -->
                                <BulletTextInput
                                    :modelValue="form.risks"
                                    :error="form.errors.risks"
                                    label="Risks"
                                    id="risks"
                                    @update="(value) => (form.risks = value)"
                                ></BulletTextInput>

                                <!-- Challenge -->
                                <BulletTextInput
                                    :modelValue="form.challenges"
                                    :error="form.errors.challenges"
                                    label="Challenges"
                                    id="challenges"
                                    @update="(value) => (form.challenges = value)"
                                ></BulletTextInput>
                            </Collapsiable>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
