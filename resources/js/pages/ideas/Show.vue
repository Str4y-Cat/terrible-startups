<script setup lang="ts">
import Note from '@/components/custom/show/Note.vue';

import DropDown from '@/components/custom/DropDown.vue';
import CollapsibleContainer from '@/components/custom/show/CollapsibleContainer.vue';
import ListDisplayBody from '@/components/custom/show/ListDisplayBody.vue';
import TextDisplay from '@/components/custom/show/TextDisplay.vue';
import TextDisplayBody from '@/components/custom/show/TextDisplayBody.vue';
import ToolOverview from '@/components/custom/show/ToolOverview.vue';
import Tag from '@/components/custom/Tag.vue';
import SyncToast from '@/components/custom/toasters/SyncToast.vue';
import { Toaster } from '@/components/ui/sonner';
import useIdeaOptions from '@/composables/useIdeaOptions';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Idea } from '@/types/general';
import { Head, usePage } from '@inertiajs/vue3';
import { useMediaQuery } from '@vueuse/core';
import { Download, Ghost, Grid2x2Check, Share, Trash2, Users } from 'lucide-vue-next';
import { computed, markRaw, ref, watch } from 'vue';
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

interface Note {
    contents: string;
    updated_at: string;
}

const isDesktop = useMediaQuery('(min-width: 768px)');

const idea = page.props.idea as Idea;
const note = page.props.note as Note;

const { deleteIdea, downloadIdea } = useIdeaOptions(idea);

const detailConfig = {
    inspiration: { title: 'Inspiration', placeholder: 'The event, experience or thought that inspired your idea... ', type: 'string' },
    problem_to_solve: { title: 'Problem', placeholder: 'The problem your idea solves... ', type: 'string' },
    solution: { title: 'Solution', placeholder: 'The solution you propose...', type: 'string' },
    features: { title: 'Features', type: 'list' },
    target_audience: { title: 'Target audience', type: 'list' },
    risks: { title: 'Risks', type: 'list' },
    challenges: { title: 'Challenges', type: 'list' },
} as const;

const completedDetails = computed(() => {
    let count = 0;
    if (!idea.details) return count;

    for (const key in idea.details) {
        if (idea.details?.[key]) {
            count++;
        }
    }
    return count;
});
const totalDetailCount = 7;

const syncing = ref(false);
let toastId: string | number | undefined = undefined;
watch(syncing, (isSyncing) => {
    if (isSyncing) {
        toastId = toast.custom(markRaw(SyncToast), {
            duration: Infinity,
        });
    } else if (toastId != undefined) {
        setTimeout(() => {
            toast.dismiss(toastId);
            toastId = undefined;
        }, 300);
    }
});
</script>

<template>
    <Head :title="idea.title" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="relative m-auto h-full w-full max-w-4xl rounded-xl">
                <div class="flex w-full items-center justify-between">
                    <h1 class="mt-4 text-4xl">{{ idea.title }}</h1>

                    <DropDown
                        v-if="isDesktop"
                        :actions="[
                            { label: 'Share', icon: Share, disabled: true, onClick: () => {} },
                            { label: 'Save', icon: Download, onClick: downloadIdea },
                            { label: 'Delete', class: 'text-red-500 ', icon: Trash2, onClick: deleteIdea },
                        ]"
                    ></DropDown>
                    <!--
                    <button @click.prevent="getContext" class="transition-color aspect-1/1 rounded-full bg-white/0 p-4 hover:bg-white/20">
                        <Ellipsis class="" />
                    </button>
                    -->
                </div>

                <CollapsibleContainer title="Overview" :open="true">
                    <TextDisplayBody @processing="(value) => (syncing = value)" field="overview" :idea_id="idea.id" :body="idea.overview" />
                    <div class="mt-8 flex flex-wrap gap-2">
                        <Tag v-for="(tag, index) in idea.tags" :key="index" class="group border-none bg-primary/10 text-sm text-primary md:text-sm">
                            {{ tag.value }}
                        </Tag>
                    </div>
                </CollapsibleContainer>

                <CollapsibleContainer title="Details">
                    <template v-slot:header>
                        <div
                            class="rounded-full px-2 py-0.5 text-sm"
                            :class="{
                                'bg-orange-500/20 text-orange-500': completedDetails != totalDetailCount,
                                'bg-green-500/20 text-green-500': completedDetails == totalDetailCount,
                            }"
                        >
                            {{ completedDetails }}/{{ totalDetailCount }}
                        </div>
                    </template>

                    <template v-for="(meta, key) in detailConfig" :key="key">
                        <TextDisplay :title="meta.title" :status="idea.details?.[key] ? 'complete' : 'progress'">
                            <TextDisplayBody
                                @processing="(value) => (syncing = value)"
                                v-if="meta.type === 'string'"
                                :field="key"
                                :idea_id="idea.id"
                                :body="idea.details?.[key]"
                                :placeholder="meta.placeholder"
                            />

                            <ListDisplayBody
                                @processing="(value) => (syncing = value)"
                                v-if="meta.type === 'list'"
                                :field="key"
                                :bullets="idea.details?.[key] ?? ['']"
                                :idea_id="idea.id"
                            />
                        </TextDisplay>
                    </template>
                </CollapsibleContainer>

                <CollapsibleContainer title="Validation Tools" :open="true">
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

                <Note :idea_id="idea.id" @processing="(value) => (syncing = value)" :note="note"></Note>
            </div>
        </div>

        <Toaster position="bottom-right" />
    </AppLayout>
</template>
