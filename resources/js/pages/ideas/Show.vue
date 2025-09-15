<script setup lang="ts">
import EditListDialog from '@/components/custom/EditListDialog.vue';
import EditTextDialog from '@/components/custom/EditTextDialog.vue';
import ListDisplayBody from '@/components/custom/show/ListDisplayBody.vue';
import Note from '@/components/custom/show/Note.vue';

import CollapsibleContainer from '@/components/custom/show/CollapsibleContainer.vue';
import TextDisplay from '@/components/custom/show/TextDisplay.vue';
import TextDisplayBody from '@/components/custom/show/TextDisplayBody.vue';
import ToolOverview from '@/components/custom/show/ToolOverview.vue';
import Tag from '@/components/custom/Tag.vue';
import { Toaster } from '@/components/ui/sonner';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router, useForm, usePage } from '@inertiajs/vue3';
import { Ellipsis, Ghost, Grid2x2Check, Users } from 'lucide-vue-next';
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
interface Note {
    contents: string;
    updated_at: string;
}

const idea = page.props.idea as Idea;
const note = page.props.note as Note;

console.log(note);

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

function getContext() {
    console.log('Getting context');
    router.visit(route('tool.context', idea.id), {
        method: 'post',
        onSuccess: (response) => {
            console.log('SUCCESS', response);
        },
        onError: (error) => {
            toast.error('Failed to save', {
                style: {
                    'border-color': 'var(--color-red-600)',
                },
                description: 'Error performing search',
            });
        },
    });
}
</script>

<template>
    <Head :title="idea.title" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="relative m-auto h-full w-full max-w-4xl rounded-xl">
                <div class="flex w-full items-center justify-between">
                    <h1 class="mt-4 text-4xl">{{ idea.title }}</h1>
                    <button @click.prevent="getContext" class="transition-color aspect-1/1 rounded-full bg-white/0 p-4 hover:bg-white/20">
                        <Ellipsis class="" />
                    </button>
                </div>
                <CollapsibleContainer title="Overview" :open="true">
                    <TextDisplayBody @click="openModal('Project overview', idea.overview, 'overview')" title="" :body="idea.overview" />
                    <div class="mt-8 flex flex-wrap gap-2">
                        <Tag v-for="(tag, index) in idea.tags" :key="index" class="group border-none bg-primary/10 text-sm text-primary md:text-sm">
                            {{ tag.value }}
                        </Tag>
                    </div>
                </CollapsibleContainer>

                <CollapsibleContainer title="Details">
                    <TextDisplay title="Inspiration" :status="idea.problem_to_solve ? 'complete' : 'progress'">
                        <TextDisplayBody @click="openModal('Inspiration', idea.inspiration, 'inspiration')" :body="idea.inspiration" />
                    </TextDisplay>
                    <TextDisplay title="Problem" :status="idea.problem_to_solve ? 'complete' : 'progress'">
                        <TextDisplayBody @click="openModal('Problem', idea.problem_to_solve, 'problem_to_solve')" :body="idea.problem_to_solve" />
                    </TextDisplay>

                    <TextDisplay title="Solution" :status="idea.solution ? 'complete' : 'progress'">
                        <TextDisplayBody @click="openModal('Solution', idea.solution, 'solution')" :body="idea.solution" />
                    </TextDisplay>

                    <TextDisplay title="Features" :status="idea.features ? 'complete' : 'progress'">
                        <ListDisplayBody @click="openListModal('Features', idea.features, 'features')" title="features" :body="idea.features" />
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
                </CollapsibleContainer>

                <CollapsibleContainer title="Validation Tools">
                    <div class="mt-4 grid grid-cols-1 flex-wrap gap-4 xs:grid-cols-2 md:grid-cols-3">
                        <!-- COMPETITOR SEARCH -->
                        <ToolOverview route_name="tool.competitor_search" :idea_id="idea.id">
                            <template v-slot:icon><Ghost /></template>
                            Competitor Search
                            <template v-slot:description>Search for competitors to your business</template>
                        </ToolOverview>

                        <!-- SWOT ANALYSIS -->
                        <ToolOverview route_name="tool.swot" :idea_id="idea.id">
                            <template v-slot:icon><Grid2x2Check /></template>
                            SWOT
                            <template v-slot:description>Strengths, Weaknesses, Opportunities, Threats</template>
                        </ToolOverview>

                        <!-- REDDIT COMPETITOR ANALYSIS -->
                        <ToolOverview route_name="tool.reddit_community_search" :idea_id="idea.id">
                            <template v-slot:icon><Users /></template>
                            Reddit Community search
                            <template v-slot:description>Search for relevant reddit communities</template>
                        </ToolOverview>
                    </div>
                </CollapsibleContainer>

                <Note :idea_id="idea.id" :note="note"></Note>
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
