<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Toaster } from '@/components/ui/sonner';
import { errorToast } from '@/composables/useErrorToast';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { ToolResult, ToolType } from '@/types/tools';
import { Head, Link, router, usePage, usePoll } from '@inertiajs/vue3';
import { ArrowLeft, LoaderCircle } from 'lucide-vue-next';
import { computed, watch } from 'vue';
import 'vue-sonner/style.css'; // vue-sonner v2 requires this import
import CompetitorSearch from './viewers/CompetitorSearch.vue';
import RedditCommunities from './viewers/RedditCommunities.vue';
import SwotAnalysis from './viewers/SwotAnalysis.vue';

//CONSTANTS
const page = usePage();

const idea = page.props.idea as { id: string; title: string };

const tool_results = computed(() => page.props.tool_results as ToolResult[]);

const tool_type = page.props.tool_type as ToolType;

//GENERAL
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Ideas',
        href: '/ideas',
    },
    {
        title: idea.title,
        href: `/ideas/${idea.id}`,
    },
    {
        title: tool_type,
        href: `/ideas/${idea.id}/tool?type=${tool_type}`,
    },
];

//SPECIFIC FUNCTION - excract to "useCreateTool"
const latest_tool_result = computed(() => tool_results.value[tool_results.value.length - 1] || {});

const processing = computed(() => {
    return latest_tool_result?.value.status == 'processing';
});

const { start, stop } = usePoll(
    1000,
    {
        only: ['tool_results'],
    },
    { autoStart: false },
);
// console.log(poll);

function createNewTool() {
    console.log(`posting to : ${route('tool', idea.id)}?type=${tool_type}`);

    router.visit(`${route('tool', idea.id)}?type=${tool_type}`, {
        method: 'post',
        onSuccess: (response) => {
            console.log('SUCCESS', response);
            start();
        },
        onError: (error) => {
            console.log(error);
            //trigger pop up
            errorToast('Failed to save', error);
        },
    });
}

watch(
    () => latest_tool_result?.value.status,
    (newStatus) => {
        console.log(`${tool_type} status`, newStatus);
        if (newStatus == 'complete') {
            console.log('stopping the search');
            // console.log(poll);
            stop();
        }
    },
);

//SPECIFIC SETUP
// dynamic component mapping
const viewers: Record<ToolType, any> = {
    'competitor-search': CompetitorSearch,
    swot: SwotAnalysis,
    'reddit-communities': RedditCommunities,
};

// const viewers = {
//     'competitor-search': CompetitorSearch,
//     swot: SwotAnalysis,
//     'reddit-communities': RedditCommunities,
// };
</script>

<template>
    <Head title="Terrible ideas" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mb-8 px-4">
            <div>
                <Link :href="`/ideas/${idea.id}`" class="mt-4 flex items-center text-foreground/50">
                    <ArrowLeft class="size-5" />
                    back
                </Link>
            </div>
            <div class="flex flex-1 gap-4 overflow-x-auto rounded-xl py-4">
                <h1 class="text-4xl">{{ tool_type }}</h1>
                <Button :disabled="processing" @click="createNewTool">
                    <span v-if="!processing"> Search </span>
                    <span v-if="processing"> Searching </span>
                    <LoaderCircle v-if="processing" class="h-4 w-4 animate-spin" />
                </Button>
            </div>
        </div>

        <div class="mb-8 px-4">
            <!--<component :is="viewers[tool_type]" v-if="latest_tool_result && latest_tool_result.content" :content="latest_tool_result.content" />-->
            <component :is="viewers[tool_type]" :content="latest_tool_result.content" />
        </div>

        <Toaster />
    </AppLayout>
</template>
