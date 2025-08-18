<script setup lang="ts">
import EditListDialog from '@/components/custom/EditListDialog.vue';
import EditTextDialog from '@/components/custom/EditTextDialog.vue';
import ListDisplayBody from '@/components/custom/show/ListDisplayBody.vue';

import TextDisplay from '@/components/custom/show/TextDisplay.vue';
import TextDisplayBody from '@/components/custom/show/TextDisplayBody.vue';
import Tag from '@/components/custom/Tag.vue';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { Toaster } from '@/components/ui/sonner';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { Plus, Share } from 'lucide-vue-next';
import { ref } from 'vue';
import { toast } from 'vue-sonner';
import 'vue-sonner/style.css'; // vue-sonner v2 requires this import

const page = usePage();
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Ideas',
        href: '/ideas',
    },
    {
        title: page.props.idea.title,
        href: '/ideas/create',
    },
];

interface Idea {
    title: string;
    rating: string;
    id: string;
    overview: string;
    type: string;
    problem_to_solve: string;
    inspiration: string;
    solution: string;
    features: string[];
    target_audience: string[];
    risks: string[];
    challenges: string[];
    date_created: string;
}

const idea: Idea = <Idea>page.props.idea;

const isDialogOpen = ref(false);

const isListDialogOpen = ref(false);

const modalData = ref({ title: '', body: '', list: [''], target: '' });

function openModal(
    title: string,
    body: string,
    target: '' | 'title' | 'overview' | 'problem_to_solve' | 'inspiration' | 'solution' | 'features' | 'target_audience' | 'risks' | 'challenges',
) {
    modalData.value = { title, body, target };
    isDialogOpen.value = true;
}

function openListModal(
    title: string,
    list: string[],
    target: '' | 'title' | 'overview' | 'problem_to_solve' | 'inspiration' | 'solution' | 'features' | 'target_audience' | 'risks' | 'challenges',
) {
    // console.log('opening list modal');
    modalData.value = { title, list, target };
    isListDialogOpen.value = true;
}

function handleSave({ target, value }: { target: keyof Idea; value: string }) {
    // console.log('Saving\n\n', target);
    // console.log('Value\n\n', value);

    // Option 1: Immediate update in UI
    idea[target] = value;

    // Option 2: Persist to server

    // console.log('doing the form');
    const form = useForm({
        [target]: value,
    });

    // console.log('putting', form.data());
    form.put(route('ideas.update', { id: idea.id }), {
        preserveScroll: true,
        onError: (error) => {
            toast.error('Failed to save', {
                style: {
                    'border-color': 'var(--color-red-600)',
                },
                description: error[target],
            });
        },
        onSuccess: () => {
            console.log('succsess');
            toast.success('Successfully saved', {
                style: {
                    'border-color': 'var(--color-green-600)',
                },
            });
        },
    });
}
</script>

<template>
    <Head :title="idea.title" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mb-16 flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="relative m-auto h-full w-full max-w-4xl rounded-xl">
                <div class="flex w-full items-center justify-between">
                    <h1 class="mt-4 text-4xl">{{ idea.title }}</h1>
                    <Share class=""></Share>
                </div>
                <TextDisplay title="Concept Foundation" :status="idea.overview && idea.inspiration ? 'complete' : 'progress'">
                    <TextDisplayBody
                        @click="openModal('Project overview', idea.overview, 'overview')"
                        title="Project Overview"
                        :body="idea.overview"
                    />
                    <div class="mt-8 flex flex-wrap gap-2">
                        <Tag v-for="(tag, index) in idea.tags" :key="index" class="group border-none bg-primary/10 text-sm text-primary md:text-sm">
                            {{ tag.value }}
                        </Tag>
                        <div class="flex items-center justify-center">
                            <Plus class="size-4 text-primary/50"></Plus>
                        </div>
                    </div>
                </TextDisplay>

                <TextDisplay title="Problem Identification" :status="idea.problem_to_solve ? 'complete' : 'progress'">
                    <TextDisplayBody
                        @click="openModal('Inspiration', idea.inspiration, 'inspiration')"
                        title="Inspiration"
                        :body="idea.inspiration"
                    />
                    <TextDisplayBody
                        @click="openModal('Problem', idea.problem_to_solve, 'problem_to_solve')"
                        title="Problem statement"
                        :body="idea.problem_to_solve"
                    />
                </TextDisplay>

                <TextDisplay title="Solution Design" :status="idea.solution ? 'complete' : 'progress'">
                    <TextDisplayBody @click="openModal('Solution', idea.solution, 'solution')" title="Proposed solution" :body="idea.solution" />
                </TextDisplay>

                <TextDisplay title="Feature planning" :status="idea.features ? 'complete' : 'progress'">
                    <ListDisplayBody @click="openListModal('Features', idea.features, 'features')" title="Bare Minimum - MVP" :body="idea.features" />
                </TextDisplay>

                <TextDisplay title="Marketing" :status="idea.target_audience ? 'complete' : 'progress'">
                    <ListDisplayBody
                        @click="openListModal('Target audience', idea.target_audience, 'target_audience')"
                        title="Target audience"
                        :body="idea.target_audience"
                    />
                </TextDisplay>

                <TextDisplay title="Risk analysis" :status="idea.risks && idea.challenges ? 'complete' : 'progress'">
                    <div class="w-full gap-4 sm:flex">
                        <ListDisplayBody
                            @click="openListModal('Risks', idea.risks, 'risks')"
                            class="w-full"
                            title="Identified risks"
                            :body="idea.risks"
                        />
                        <ListDisplayBody
                            @click="openListModal('Challenges', idea.challenges, 'challenges')"
                            class="w-full"
                            title="Key challenges"
                            :body="idea.challenges"
                        />
                    </div>
                </TextDisplay>

                <TextDisplay title="Market validation" :status="false ? 'complete' : 'progress'">
                    <div class="mt-4 grid grid-cols-2 flex-wrap gap-4 sm:grid-cols-3">
                        <div
                            class="group relative flex aspect-1/1 items-center justify-center gap-2 rounded border border-dashed border-primary sm:aspect-2/1"
                        >
                            <Plus class="block group-hover:hidden"></Plus>
                            <p class="block max-w-[70%] group-hover:hidden">Competitor search - General</p>
                            <p class="hidden group-hover:block">Coming soon</p>
                            <PlaceholderPattern class="opacity-40" />
                        </div>

                        <div
                            class="group relative flex aspect-1/1 items-center justify-center gap-2 rounded border border-dashed border-primary sm:aspect-2/1"
                        >
                            <Plus class="block group-hover:hidden"></Plus>
                            <p class="block max-w-[70%] group-hover:hidden">Competitor search - Product Hunt</p>
                            <p class="hidden group-hover:block">Coming soon</p>
                            <PlaceholderPattern class="opacity-40" />
                        </div>

                        <div
                            class="group relative flex aspect-1/1 items-center justify-center gap-2 rounded border border-dashed border-primary sm:aspect-2/1"
                        >
                            <Plus class="block group-hover:hidden"></Plus>
                            <p class="block max-w-[70%] group-hover:hidden">Reddit Scraper</p>
                            <p class="hidden group-hover:block">Coming soon</p>
                            <PlaceholderPattern class="opacity-40" />
                        </div>

                        <div
                            class="group relative flex aspect-1/1 items-center justify-center gap-2 rounded border border-dashed border-primary sm:aspect-2/1"
                        >
                            <Plus class="block group-hover:hidden"></Plus>
                            <p class="block max-w-[70%] group-hover:hidden">Local business's to talk to</p>
                            <p class="hidden group-hover:block">Coming soon</p>
                            <PlaceholderPattern class="opacity-40" />
                        </div>

                        <div
                            class="group relative flex aspect-1/1 items-center justify-center gap-2 rounded border border-dashed border-primary sm:aspect-2/1"
                        >
                            <Plus class="block group-hover:hidden"></Plus>
                            <p class="block max-w-[70%] group-hover:hidden">Possible partners</p>
                            <p class="hidden group-hover:block">Coming soon</p>
                            <PlaceholderPattern class="opacity-40" />
                        </div>
                    </div>
                </TextDisplay>

                <TextDisplay title="Notes"> </TextDisplay>
            </div>
        </div>

        <!-- The dialog -->
        <!--
        <Dialog v-model:open="isDialogOpen">
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>
                        <div class="flex items-center gap-2">
                            <SquarePen />
                            {{ modalData.title }}
                        </div>
                    </DialogTitle>
                </DialogHeader>
                <p>{{ modalData.body }}</p>
            </DialogContent>
        </Dialog>
        -->
        <EditTextDialog
            v-model:isOpen="isDialogOpen"
            :title="modalData.title"
            :body="modalData.body"
            :form_target="modalData.target"
            @save="handleSave"
        ></EditTextDialog>

        <EditListDialog
            v-model:isOpen="isListDialogOpen"
            :title="modalData.title"
            :list="modalData.list"
            :form_target="modalData.target"
            @save="handleSave"
        >
        </EditListDialog>

        <Toaster />
    </AppLayout>
</template>
