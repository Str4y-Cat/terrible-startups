<script setup lang="ts">
import RatingDialog from '@/components/custom/RatingDialog.vue';
import InputError from '@/components/InputError.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import Select from '../../components/custom/form/Select.vue';

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

const businessTypes = ['Product', 'Service', 'Hello'];

const form = useForm({
    title: '',
    overview: '',
    type: '',
    rating: '',
    problem_to_solve: '',
    inspiration: '',
    solution: '',
    features: '',
    target_audience: '',
    risks: '',
    challenge: '',
});
const submit = () => {
    console.log(form.data());
    // form.post(route('ideas.store'), {
    //     onFinish: () => {
    //         /*navigate to form */
    //     },
    // });
};
const requiredFields: string[] = ['title'];
const canSubmit = computed(() => {
    return requiredFields.every((field) => {
        const value = form[field];
        return value !== null && value !== undefined && value.toString().trim() !== '' && !form.processing;
    });
});

const hasRating = ref(false);
</script>

<template>
    <Head title="New" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mb-16 flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="relative h-full w-full rounded-xl border bg-muted/20">
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
                        <RatingDialog :disabled="!canSubmit" @click="hasRating = true"></RatingDialog>
                        <!--<RatingDrawer :disabled="!canSubmit"></RatingDrawer>-->
                        <!--<Button :disabled="!canSubmit">Create</Button>-->
                    </div>

                    <div class="grid divide-y-1 divide-solid sm:divide-x-1 sm:divide-y-0 md:grid-cols-5">
                        <div class="grid gap-4 p-4 sm:col-span-3">
                            <h1 class="font-bold text-foreground/30">Basics</h1>

                            <div class="grid gap-2">
                                <Label for="overview" class="sm:text-lg">Overview</Label>
                                <Textarea :modelValue="form.overview" class="border-none bg-input/10 p-1 dark:bg-input/10" />
                                <InputError :message="form.errors.overview" />
                            </div>

                            <!-- Problem to Solve -->
                            <div class="grid gap-2">
                                <Label for="problem_to_solve" class="sm:text-lg">Problem to Solve</Label>
                                <Textarea
                                    id="problem_to_solve"
                                    :modelValue="form.problem_to_solve"
                                    class="border-none bg-input/10 dark:bg-input/10"
                                />
                                <InputError :message="form.errors.problem_to_solve" />
                            </div>

                            <!-- Inspiration for Idea -->
                            <div class="grid gap-2">
                                <Label for="inspiration" class="sm:text-lg">Inspiration</Label>
                                <Textarea id="inspiration" :modelValue="form.inspiration" class="border-none bg-input/10 dark:bg-input/10" />
                                <InputError :message="form.errors.inspiration" />
                            </div>

                            <!-- Proposed Solution -->
                            <div class="grid gap-2">
                                <Label for="solution" class="sm:text-lg">Proposed Solution</Label>
                                <Textarea id="solution" :modelValue="form.solution" class="border-none bg-input/10 dark:bg-input/10" />
                                <InputError :message="form.errors.solution" />
                            </div>

                            <!-- Business type -->
                            <Select v-model="form.type" placeholder="Business type" :values="businessTypes"></Select>
                        </div>

                        <div class="grid gap-4 p-4 sm:col-span-2">
                            <h1 class="font-bold text-foreground/30">Extra</h1>
                            <!-- Features -->
                            <div class="grid gap-2">
                                <Label for="features" class="sm:text-lg">Features</Label>
                                <Textarea id="features" :modelValue="form.features" class="border-none bg-input/10 dark:bg-input/10" />
                                <InputError :message="form.errors.features" />
                            </div>

                            <!-- Description of Target Audience -->
                            <div class="grid gap-2">
                                <Label for="target_audience" class="sm:text-lg">Description of Target Audience</Label>
                                <Textarea id="target_audience" :modelValue="form.target_audience" class="border-none bg-input/10 dark:bg-input/10" />
                                <InputError :message="form.errors.target_audience" />
                            </div>

                            <!-- Risks -->
                            <div class="grid gap-2">
                                <Label for="risks" class="sm:text-lg">Risks</Label>
                                <Textarea id="risks" :modelValue="form.risks" class="border-none bg-input/10 dark:bg-input/10" />
                                <InputError :message="form.errors.risks" />
                            </div>

                            <!-- Challenge -->
                            <div class="grid gap-2">
                                <Label for="challenge" class="sm:text-lg">Challenge</Label>
                                <Textarea id="challenge" :modelValue="form.challenge" class="border-none bg-input/10 dark:bg-input/10" />
                                <InputError :message="form.errors.challenge" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
