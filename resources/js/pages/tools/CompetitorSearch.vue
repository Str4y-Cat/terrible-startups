<script setup lang="ts">
import CompetitorSearchTable from '@/components/custom/CompetitorSearchTable.vue';
import Button from '@/components/ui/button/Button.vue';
import { Toaster } from '@/components/ui/sonner';
import { errorToast } from '@/composables/useErrorToast';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { CompetitorSearch } from '@/types/tools';
import { Head, Link, router, usePage, usePoll } from '@inertiajs/vue3';
import { ArrowLeft, LoaderCircle } from 'lucide-vue-next';
import { computed, watch } from 'vue';
import 'vue-sonner/style.css'; // vue-sonner v2 requires this import

const page = usePage();

const idea = page.props.idea as { id: string; title: string };

const competitor_searches = computed(() => page.props.competitor_searches as CompetitorSearch[]);
// console.log(competitor_searches);
const latest_competitor_search = computed(() => competitor_searches.value[competitor_searches.value.length - 1] || {});

const processing = computed(() => {
    return latest_competitor_search?.value.status == 'processing';
});

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
        title: 'competitor search',
        href: `/ideas/${idea.id}/competitor-search`,
    },
];

const { start, stop } = usePoll(
    1000,
    {
        only: ['competitor_searches'],
    },
    { autoStart: false },
);
// console.log(poll);

function createNewCompetitorSearch() {
    router.visit(route('tool.competitor_search', idea.id), {
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
    () => latest_competitor_search?.value.status,
    (newStatus) => {
        console.log('competitor status', newStatus);
        if (newStatus == 'complete') {
            console.log('stopping the search');
            // console.log(poll);
            stop();
        }
    },
);
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
                <h1 class="text-4xl">Competitor search</h1>
                <Button :disabled="processing" @click="createNewCompetitorSearch">
                    <span v-if="!processing"> Search </span>
                    <span v-if="processing"> Searching </span>
                    <LoaderCircle v-if="processing" class="h-4 w-4 animate-spin" />
                </Button>
            </div>
            <div>
                <p class="text-foreground/50">
                    Perform a ai search for all the competitors of your idea. The more information you have added to your idea description, the more
                    accurate the results will be
                </p>
            </div>
        </div>

        <div>
            <div class="space-y-8 p-4">
                <!-- DIRECT COMPETITORS -->
                <div v-if="latest_competitor_search">
                    <h3 class="mb-4 text-2xl font-semibold">Direct Competitors</h3>
                    <CompetitorSearchTable
                        :head="['name', 'regions', 'description', 'strengths', 'weaknesses', 'target_audience', 'website']"
                        :content="latest_competitor_search.content?.competitors"
                    />
                </div>

                <!-- INDIRECT COMPETITORS -->
                <div v-if="latest_competitor_search">
                    <h3 class="mb-4 text-2xl font-semibold">Indirect Competitors</h3>
                    <CompetitorSearchTable
                        :head="['name', 'regions', 'description', 'strengths', 'weaknesses', 'target_audience', 'website']"
                        :content="latest_competitor_search.content?.indirect_competitors"
                    />
                </div>
            </div>
        </div>

        <Toaster />
    </AppLayout>
</template>
