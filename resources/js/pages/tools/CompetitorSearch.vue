<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { CompetitorSearch } from '@/types/competitor_search';
import { Head, router, usePage, usePoll } from '@inertiajs/vue3';

const page = usePage();

console.log(page.props);
const idea: { id: string; title: string } = page.props.idea;

const competitor_searches = page.props.competitor_searches as CompetitorSearch[];
console.log(competitor_searches);
const latest_competitor_search = competitor_searches[competitor_searches.length - 1];

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

function createNewCompetitorSearch() {
    router.visit(route('tool.create_competitor_search', idea.id), {
        method: 'post',
        onSuccess: (response) => {
            console.log('Success! ', response);
        },
        onError: (error) => {
            console.log('failed! ', error);
        },
    });
}

usePoll(2000, {
    only: ['competitor_searches'],
});
</script>

<template>
    <Head title="Terrible ideas" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <h1 class="text-4xl">hello this is the competitor search page</h1>
            <Button @click="createNewCompetitorSearch">Search for competitors</Button>
        </div>
        <div>
            <div class="space-y-8 p-4">
                <!-- DIRECT COMPETITORS -->
                <div v-if="latest_competitor_search">
                    <h3 class="mb-4 text-2xl font-semibold">Direct Competitors</h3>
                    <div class="overflow-x-auto rounded-lg shadow">
                        <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Name</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Description</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Strengths</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Weaknesses</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Pricing</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Website</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr v-for="(competitor, index) in latest_competitor_search.content?.competitors" :key="index">
                                    <td class="px-4 py-2 font-medium text-gray-900">{{ competitor.name }}</td>
                                    <td class="px-4 py-2">{{ competitor.description }}</td>
                                    <td class="px-4 py-2">{{ competitor.strengths }}</td>
                                    <td class="px-4 py-2">{{ competitor.weaknesses }}</td>
                                    <td class="px-4 py-2">{{ competitor.pricing }}</td>
                                    <td class="px-4 py-2 text-blue-600 underline">
                                        <a :href="`https://${competitor.website}`" target="_blank">{{ competitor.website }}</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- INDIRECT COMPETITORS -->
                <div v-if="latest_competitor_search">
                    <h3 class="mb-4 text-2xl font-semibold">Indirect Competitors</h3>
                    <div class="overflow-x-auto rounded-lg shadow">
                        <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Name</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Description</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Strengths</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Weaknesses</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Pricing</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Website</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr v-for="(competitor, index) in latest_competitor_search.content.indirect_competitors" :key="index">
                                    <td class="px-4 py-2 font-medium text-gray-900">{{ competitor.name }}</td>
                                    <td class="px-4 py-2">{{ competitor.description }}</td>
                                    <td class="px-4 py-2">{{ competitor.strengths }}</td>
                                    <td class="px-4 py-2">{{ competitor.weaknesses }}</td>
                                    <td class="px-4 py-2">{{ competitor.pricing }}</td>
                                    <td class="px-4 py-2 text-blue-600 underline">
                                        <a :href="`https://${competitor.website}`" target="_blank">{{ competitor.website }}</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
