<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Toaster } from '@/components/ui/sonner';
import { errorToast } from '@/composables/useErrorToast';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { CommunityAnalysis } from '@/types/tools';
import { Head, Link, router, usePage, usePoll } from '@inertiajs/vue3';
import { ArrowLeft, LoaderCircle } from 'lucide-vue-next';
import { computed, watch } from 'vue';
import 'vue-sonner/style.css'; // vue-sonner v2 requires this import

const page = usePage();

const idea = page.props.idea as { id: string; title: string };

const community_searches = computed(() => page.props.community_searches as CommunityAnalysis[]);
// console.log(competitor_searches);
const latest_community_search = computed(() => {
    return community_searches.value[community_searches.value?.length - 1] || {};
});

const processing = computed(() => {
    return latest_community_search?.value.status == 'processing';
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
        title: 'Reddit community search',
        href: `/ideas/${idea.id}/reddit-community-search`,
    },
];

const { start, stop } = usePoll(
    1000,
    {
        only: ['community_searches'],
    },
    { autoStart: false },
);
// console.log(poll);

function createNewRedditCommunitySearch() {
    router.visit(route('tool.reddit_community_search', idea.id), {
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
    () => latest_community_search?.value.status,
    (newStatus) => {
        console.log('status', newStatus);
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
                <h1 class="text-4xl">Reddit Community search</h1>
                <Button :disabled="processing" @click="createNewRedditCommunitySearch">
                    <span v-if="!processing"> Search </span>
                    <span v-if="processing"> Searching </span>
                    <LoaderCircle v-if="processing" class="h-4 w-4 animate-spin" />
                </Button>
            </div>
        </div>

        <div>
            <div class="space-y-8 p-4">
                <!-- Community Analysis Display -->
                <div v-if="latest_community_search?.content" class="space-y-8 p-4">
                    <!-- Business Idea Analysis -->
                    <section>
                        <h2 class="text-2xl font-bold">Business Idea Analysis</h2>
                        <p class="mt-2 text-foreground/80">
                            {{ latest_community_search.content.business_idea_analysis }}
                        </p>
                    </section>

                    <!-- Communities -->
                    <section>
                        <h2 class="text-2xl font-bold">Relevant Communities</h2>
                        <div class="mt-4 grid gap-6 md:grid-cols-2">
                            <div
                                v-for="community in latest_community_search.content.communities"
                                :key="community.name"
                                class="rounded-xl border p-4 shadow-sm"
                            >
                                <h3 class="text-xl font-semibold">
                                    <a :href="community.link_or_access" target="_blank" class="text-blue-600 hover:underline">
                                        {{ community.name }}
                                    </a>
                                </h3>
                                <p class="mt-2 text-foreground/80">{{ community.description }}</p>
                                <p v-if="community.type" class="mt-1 text-sm text-foreground/50"><strong>Type:</strong> {{ community.type }}</p>
                                <p class="mt-3 text-sm text-foreground/60"><strong>Relevance:</strong> {{ community.relevance_reasoning }}</p>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Empty State -->
                <div v-else class="p-4 text-foreground/50">No community search available yet.</div>
            </div>
        </div>

        <Toaster />
    </AppLayout>
</template>
