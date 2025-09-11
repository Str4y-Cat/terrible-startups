<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Toaster } from '@/components/ui/sonner';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { SwotAnalysis } from '@/types/tools';
import { Head, Link, router, usePage, usePoll } from '@inertiajs/vue3';
import { ArrowLeft, LoaderCircle } from 'lucide-vue-next';
import { computed } from 'vue';
import { toast } from 'vue-sonner';
import 'vue-sonner/style.css'; // vue-sonner v2 requires this import

const page = usePage();

const idea = page.props.idea as { id: string; title: string };

const swots = computed(() => page.props.swots as SwotAnalysis[]);
console.log(swots.value);
// console.log(competitor_searches);
const latest_swot = computed(() => swots.value[swots.value.length - 1] || {});

const processing = computed(() => {
    return latest_swot?.value.status == 'processing';
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
        title: 'SWOT',
        href: `/ideas/${idea.id}/swot`,
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
    router.visit(route('tool.swot', idea.id), {
        method: 'post',
        onSuccess: (response) => {
            console.log('SUCCESS', response);
            start();
        },
        onError: (error) => {
            console.log(error);
            //trigger pop up

            toast.error('Failed to save', {
                style: {
                    'border-color': 'var(--color-red-600)',
                },
                description: 'Error performing search',
            });
        },
    });
}

/*
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
*/
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
                <h1 class="text-4xl">SWOT Analysis</h1>
                <Button :disabled="processing" @click="createNewCompetitorSearch">
                    <span v-if="!processing"> Search </span>
                    <span v-if="processing"> Searching </span>
                    <LoaderCircle v-if="processing" class="h-4 w-4 animate-spin" />
                </Button>
            </div>
        </div>

        <div>
            <div class="space-y-8 p-4">
                <!-- SWOT Analysis Display -->
                <div v-if="latest_swot?.content" class="space-y-8 p-4">
                    <!-- Business Idea Summary -->
                    <section>
                        <h2 class="text-2xl font-bold">Business Idea Summary</h2>
                        <p class="mt-2 text-foreground/80">{{ latest_swot.content.BusinessIdeaSummary }}</p>
                    </section>

                    <!-- Research -->
                    <section>
                        <h2 class="text-2xl font-bold">Research</h2>
                        <p class="mt-2 text-foreground/80">{{ latest_swot.content.Research }}</p>
                    </section>

                    <!-- SWOT Categories -->
                    <section>
                        <h2 class="mb-4 text-2xl font-bold">SWOT</h2>
                        <div class="grid gap-6 md:grid-cols-2">
                            <div v-for="(category, key) in latest_swot.content.SWOT" :key="key" class="rounded-xl border p-4">
                                <h3 class="text-xl font-semibold capitalize">{{ key }}</h3>
                                <ul class="mt-2 list-inside list-disc space-y-1">
                                    <li v-for="point in category.Points" :key="point" class="text-foreground/80">
                                        {{ point }}
                                    </li>
                                </ul>
                                <p class="mt-3 text-sm text-foreground/60"><strong>Reasoning:</strong> {{ category.Reasoning }}</p>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Empty state -->
                <div v-else class="p-4 text-foreground/50">No SWOT analysis available yet.</div>
            </div>
        </div>

        <Toaster />
    </AppLayout>
</template>
