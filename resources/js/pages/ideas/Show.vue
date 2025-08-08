<script setup lang="ts">
import TextDisplay from '@/components/custom/show/TextDisplay.vue';
import TextDisplayBody from '@/components/custom/show/TextDisplayBody.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';

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
</script>

<template>
    <Head title="New" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="relative m-auto h-full w-full max-w-4xl rounded-xl">
                <div>
                    <h1 class="text-4xl">{{ idea.title }}</h1>
                </div>
                <TextDisplay title="Concept Foundation" :status="idea.overview && idea.inspiration ? 'complete' : 'progress'">
                    <TextDisplayBody title="Project Overview" :body="idea.overview" />
                    <TextDisplayBody title="Inspiration" :body="idea.inspiration" />
                </TextDisplay>

                <TextDisplay title="Concept Foundation" status="complete">
                    <TextDisplayBody title="Overview" body="this is the body" />
                    <TextDisplayBody title="Overview" body="this is the body" />
                    <TextDisplayBody title="Overview" body="this is the body" />
                </TextDisplay>
            </div>
        </div>
    </AppLayout>
</template>
