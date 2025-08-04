<script setup lang="ts">
import RatingDialog from '@/components/custom/RatingDialog.vue';
import InputError from '@/components/InputError.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { computed, reactive } from 'vue';
import Select from '@/components/custom/form/Select.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Ideas',
        href: '/ideas',
    },
    {
        title: 'New idea',
        href: '/ideas/create',
    },
];

//sets the select types
const businessTypes = ['Product', 'Service', 'Hello'];

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

// interface StrippedRating {
//     key: number;
//     value: number;
// }
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
    <Head title="New" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mb-16 flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="relative h-full w-full rounded-xl">
                <form @submit.prevent="submit" class="flex flex-col gap-6 px-4 pt-8">
                    <div class="flex justify-between gap-4">
                        <div class="h-fit w-full">
                            <Input
                                id="title"
                                type="text"
                                required
                                autofocus
                                :tabindex="0"
                                v-model="form.title"
                                class="border-none bg-transparent py-2 text-xl font-bold md:text-2xl dark:bg-transparent"
                                placeholder="New idea"
                            />
                            <InputError :message="form.errors.title" />
                        </div>
                        <!--<Button :variant="hasRating ? 'default' : 'ghost'" :disabled="!canSubmit">Create without rating</Button>-->
                        <p>{{}}</p>
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

                    <div class="grid divide-y-1 divide-solid sm:divide-x-1 sm:divide-y-0 md:grid-cols-5">
                        <div class="grid gap-4 p-4 sm:col-span-3">
                            <h1 class="font-bold text-foreground/30">Basics</h1>

                            <div class="grid gap-2">
                                <Label for="overview" class="text-md sm:text-lg">Overview</Label>
                                <Textarea
                                    :modelValue="form.overview"
                                    @update:modelValue="(value) => (form.overview = `${value}`)"
                                    class="border-none bg-input/10 p-1 dark:bg-input/10"
                                />
                                <InputError :message="form.errors.overview" />
                            </div>

                            <!-- Problem to Solve -->
                            <div class="grid gap-2">
                                <Label for="problem_to_solve" class="text-md sm:text-lg">Problem to Solve</Label>
                                <Textarea
                                    id="problem_to_solve"
                                    :modelValue="form.problem_to_solve"
                                    @update:modelValue="(value) => (form.problem_to_solve = `${value}`)"
                                    class="border-none bg-input/10 dark:bg-input/10"
                                />
                                <InputError :message="form.errors.problem_to_solve" />
                            </div>

                            <!-- Inspiration for Idea -->
                            <div class="grid gap-2">
                                <Label for="inspiration" class="text-md sm:text-lg">Inspiration</Label>
                                <Textarea
                                    @update:modelValue="(value) => (form.inspiration = `${value}`)"
                                    id="inspiration"
                                    :modelValue="form.inspiration"
                                    class="border-none bg-input/10 dark:bg-input/10"
                                />
                                <InputError :message="form.errors.inspiration" />
                            </div>

                            <!-- Proposed Solution -->
                            <div class="grid gap-2">
                                <Label for="solution" class="text-md sm:text-lg">Proposed Solution</Label>
                                <Textarea
                                    @update:modelValue="(value) => (form.solution = `${value}`)"
                                    id="solution"
                                    :modelValue="form.solution"
                                    class="border-none bg-input/10 dark:bg-input/10"
                                />
                                <InputError :message="form.errors.solution" />
                            </div>

                            <!-- Business type -->
                            <Select v-model="form.type" placeholder="Business type" :values="businessTypes"></Select>
                        </div>

                        <div class="grid gap-4 p-4 sm:col-span-2">
                            <h1 class="font-bold text-foreground/30">Extra</h1>
                            <!-- Features -->
                            <div class="grid gap-2">
                                <Label for="features" class="text-md sm:text-lg">Features</Label>
                                <Textarea
                                    @update:modelValue="(value) => (form.features = `${value}`)"
                                    id="features"
                                    :modelValue="form.features"
                                    class="border-none bg-input/10 dark:bg-input/10"
                                />
                                <InputError :message="form.errors.features" />
                            </div>

                            <!-- Description of Target Audience -->
                            <div class="grid gap-2">
                                <Label for="target_audience" class="text-md sm:text-lg">Description of Target Audience</Label>
                                <Textarea
                                    @update:modelValue="(value) => (form.target_audience = `${value}`)"
                                    id="target_audience"
                                    :modelValue="form.target_audience"
                                    class="border-none bg-input/10 dark:bg-input/10"
                                />
                                <InputError :message="form.errors.target_audience" />
                            </div>

                            <!-- Risks -->
                            <div class="grid gap-2">
                                <Label for="risks" class="text-md sm:text-lg">Risks</Label>
                                <Textarea
                                    @update:modelValue="(value) => (form.risks = `${value}`)"
                                    id="risks"
                                    :modelValue="form.risks"
                                    class="border-none bg-input/10 dark:bg-input/10"
                                />
                                <InputError :message="form.errors.risks" />
                            </div>

                            <!-- Challenge -->
                            <div class="grid gap-2">
                                <Label for="challenge" class="text-md sm:text-lg">Challenge</Label>
                                <Textarea
                                    id="challenge"
                                    @update:modelValue="(value) => (form.challenges = `${value}`)"
                                    :modelValue="form.challenges"
                                    class="border-none bg-input/10 dark:bg-input/10"
                                />
                                <InputError :message="form.errors.challenges" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
