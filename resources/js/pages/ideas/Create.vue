<script setup lang="ts">
import Collapsiable from '@/components/custom/Collapsiable.vue';
import TextInput from '@/components/custom/create/TextInput.vue';
import RatingDialog from '@/components/custom/RatingDialog.vue';
import InputError from '@/components/InputError.vue';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { computed, reactive, ref } from 'vue';

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

//sets the select types
// const businessTypes = ['Product', 'Service', 'Hello'];

const form = useForm<{
    title?: string;
    rating?: number;
    overview?: string;
    type?: string;
    problem_to_solve?: string;
    inspiration?: string;
    solution?: string;
    features?: string;
    target_audience?: string;
    risks?: string;
    challenges?: string;
    rating_questions?: { key: number; value: number }[];
}>({
    title: '',
    rating: 0,
    overview: '',
    type: '',
    problem_to_solve: '',
    inspiration: '',
    solution: '',
    features: '',
    target_audience: '',
    risks: '',
    challenges: '',
    rating_questions: [{ key: 0, value: 0 }],
});

const submit = () => {
    form.rating_questions = [...stripRatingsForSubmit()];
    console.log(form.data());
    form.post(route('ideas.store'), {
        onFinish: () => {
            /*navigate to form */
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

interface Rating {
    label: string;
    description: string;
    value: number;
    key: number;
}

//REFACTOR: Convert this array to a database call, thats cached
const ratings = reactive<Rating[]>([
    { key: 0, label: 'Urgency', description: 'How badly do users want this?', value: -1 },
    { key: 1, label: 'Market Size', description: 'How many people are already purchasing things like this?', value: -1 },
    { key: 2, label: 'Pricing Potential', description: 'How high can you sell this for?', value: -1 },
    { key: 3, label: 'Customer Aquisition Cost', description: 'How much will it cost to generate a sale?', value: -1 },
    { key: 4, label: 'Value Delivery Cost', description: 'How much time/effort is required to deliver value?', value: -1 },
    { key: 5, label: 'Uniqueness', description: 'How unique is your offer compared to competitors?', value: -1 },
    { key: 6, label: 'Speed to marker', description: 'How soon can you create something to sell?', value: -1 },
    { key: 7, label: 'Up-front investment', description: 'How much do you need to invest to start selling?', value: -1 },
    { key: 8, label: 'Upsell potential', description: 'Are there secondary offers you can present to customers?', value: -1 },
    { key: 9, label: 'Evergreen Potential', description: 'Once created, how much additional effort is required to continue selling?', value: -1 },
]);

const stripRatingsForSubmit = (): { key: number; value: number }[] => {
    return ratings.map((x) => {
        return { key: x.key, value: x.value };
    });
};

//calculated the rating total out of a 100. Regardless of the rating count
const total = computed(() => {
    const max = ratings.length * 10;
    const current = ratings.reduce((sum, current) => {
        return (sum += current.value);
    }, 0);
    return Math.round((current / max) * 100);
});
</script>

<template>
    <Head title="idea_title" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mb-16 flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="relative h-full w-full rounded-xl">
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
                                @update:modelValue="
                                    (val) => {
                                        idea_title = val;
                                    }
                                "
                                v-model="form.title"
                                class="rounded-none border-none bg-transparent p-0 text-2xl font-bold focus-visible:ring-0 md:text-3xl dark:bg-transparent"
                                placeholder="New idea - Untitled"
                            />
                            <InputError :message="form.errors.title" />
                        </div>
                        <!--<Button :variant="hasRating ? 'default' : 'ghost'" :disabled="!canSubmit">Create without rating</Button>-->
                        <RatingDialog
                            @update="
                                ({ index, value }) => {
                                    ratings[index].value = value;
                                    form.rating = total;
                                }
                            "
                            :onSubmit="submit"
                            :ratings="ratings"
                            :disabled="!canSubmit"
                        ></RatingDialog>
                        <InputError :message="form.errors.rating_questions" />
                        <!--<RatingDrawer :disabled="!canSubmit"></RatingDrawer>-->
                        <!--<Button :disabled="!canSubmit">Create</Button>-->
                    </div>

                    <div class="">
                        <div class="grid gap-4">
                            <!-- OVERVIEW -->
                            <TextInput
                                :modelValue="form.overview"
                                :error="form.errors.overview"
                                label="Overview"
                                id="overview"
                                @update="(value) => (form.overview = value)"
                            ></TextInput>

                            <!-- Problem to Solve -->
                            <TextInput
                                :modelvalue="form.problem_to_solve"
                                :error="form.errors.problem_to_solve"
                                label="Problem to solve"
                                id="problem_to_solve"
                                @update:modelvalue="(value) => (form.problem_to_solve = value)"
                            ></TextInput>

                            <!-- Inspiration for Idea -->
                            <TextInput
                                :modelvalue="form.inspiration"
                                :error="form.errors.inspiration"
                                label="Inspiration"
                                id="inspiration"
                                @update:modelvalue="(value) => (form.inspiration = value)"
                            ></TextInput>

                            <!-- Proposed Solution -->
                            <TextInput
                                :modelvalue="form.solution"
                                :error="form.errors.solution"
                                label="Solution"
                                id="solution"
                                @update:modelvalue="(value) => (form.solution = value)"
                            ></TextInput>
                        </div>

                        <div class="grid gap-4">
                            <Collapsiable>
                                <!-- Features -->
                                <TextInput
                                    :modelvalue="form.features"
                                    :error="form.errors.features"
                                    label="Features"
                                    id="features"
                                    @update:modelvalue="(value) => (form.features = value)"
                                ></TextInput>

                                <!-- Description of Target Audience -->
                                <TextInput
                                    :modelvalue="form.target_audience"
                                    :error="form.errors.target_audience"
                                    label="Target audience"
                                    id="target_audience"
                                    @update:modelvalue="(value) => (form.target_audience = value)"
                                ></TextInput>

                                <!-- Risks -->
                                <TextInput
                                    :modelvalue="form.risks"
                                    :error="form.errors.risks"
                                    label="Risks"
                                    id="risks"
                                    @update:modelvalue="(value) => (form.risks = value)"
                                ></TextInput>

                                <!-- Challenge -->
                                <TextInput
                                    :modelvalue="form.challenges"
                                    :error="form.errors.challenges"
                                    label="Challenges"
                                    id="challenges"
                                    @update:modelvalue="(value) => (form.challenges = value)"
                                ></TextInput>
                            </Collapsiable>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
