<script setup lang="ts">
import EditDialog from '@/components/custom/EditDialog.vue';
import TextDisplay from '@/components/custom/show/TextDisplay.vue';
import TextDisplayBody from '@/components/custom/show/TextDisplayBody.vue';
import Tag from '@/components/custom/Tag.vue';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { Toaster } from '@/components/ui/sonner';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
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
    features: string;
    target_audience: string;
    risks: string;
    challenges: string;
    date_created: string;
}
const idea: Idea = <Idea>page.props.idea;

const isDialogOpen = ref(false);
const modalData = ref({ title: '', body: '', target: '' });

function openModal(
    title: string,
    body: string,
    target: '' | 'title' | 'overview' | 'problem_to_solve' | 'inspiration' | 'solution' | 'features' | 'target_audience' | 'risks' | 'challenges',
) {
    modalData.value = { title, body, target };
    isDialogOpen.value = true;
}

function handleSave({ target, value }: { target: keyof Idea; value: string }) {
    console.log('Saving\n\n', target);
    console.log('Value\n\n', value);

    // Option 1: Immediate update in UI
    idea[target] = value;

    // Option 2: Persist to server

    const form = useForm({
        [target]: value,
    });
    form.put(route('ideas.update', { id: idea.id }), {
        preserveScroll: true,
        onError: (error) => console.log(error),
        onSuccess: () => {
            console.log('succsess');
            toast('Saved', {
                description: 'Sunday, December 03, 2023 at 9:00 AM',
                // action: {
                //     label: 'Undo',
                //     onClick: () => console.log('Undo'),
                // },
            });
        },
    });
}
</script>

<template>
    <Head title="New" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="relative m-auto h-full w-full max-w-4xl rounded-xl">
                <div>
                    <h1 class="mt-4 text-4xl">{{ idea.title }}</h1>
                </div>
                <TextDisplay title="Concept Foundation" :status="idea.overview && idea.inspiration ? 'complete' : 'progress'">
                    <TextDisplayBody
                        @click="openModal('Project overview', idea.overview, 'overview')"
                        title="Project Overview"
                        :body="idea.overview"
                    />
                    <div class="mt-8 flex flex-wrap gap-y-2">
                        <Tag v-for="n in 10" :key="n">Tag - {{ n }}</Tag>
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
                    <TextDisplayBody title="Bare Minimum - MVP" :body="idea.features" />
                    <TextDisplayBody title="Core features" body="" />
                    <TextDisplayBody title="Nice to have's" body="" />
                </TextDisplay>

                <TextDisplay title="Risk analysis" :status="idea.risks && idea.challenges ? 'complete' : 'progress'">
                    <div class="w-full gap-4 sm:flex">
                        <TextDisplayBody
                            @click="openModal('Risks', idea.risks, 'risks')"
                            class="w-full"
                            title="Identified risks"
                            :body="idea.risks"
                        />
                        <TextDisplayBody
                            @click="openModal('Challenges', idea.challenges, 'challenges')"
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
                            <p class="block group-hover:hidden">Reddit Scraper</p>
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
                            <p class="block group-hover:hidden">Possible partners</p>
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
        <EditDialog
            v-model:isOpen="isDialogOpen"
            :title="modalData.title"
            :body="modalData.body"
            :form_target="modalData.target"
            @save="handleSave"
        ></EditDialog>

        <Toaster />
    </AppLayout>
</template>
