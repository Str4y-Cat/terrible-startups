<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { computed, reactive } from 'vue';
import IdeaListItem from '../components/custom/IdeaListItem.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Ideas',
        href: '/ideas',
    },
];

const ideasArray = reactive([
    {
        title: 'Tinder for Dogs',
        handle: 'tinder-for-dogs',
        description: 'A place for your pals to connect',
        type: 'Saas/App',
        dateCreated: '1/10/2024',
        rating: 5,
        pinned: false,
    },
    {
        title: 'BackyardBnB',
        handle: 'backyardbnb',
        description: 'Rent out your lawn to adventurous campers',
        type: 'Marketplace',
        dateCreated: '2/14/2024',
        rating: 32,
        pinned: false,
    },
    {
        title: 'GrassPass',
        handle: 'grasspass',
        description: 'Summon a neighbor’s mower when yours won’t start',
        type: 'App',
        dateCreated: '3/01/2024',
        rating: 27,
        pinned: false,
    },
    {
        title: 'Holey Socks',
        handle: 'holey-socks',
        description: 'Monthly delivery of socks that definitely need replacing',
        type: 'E-commerce',
        dateCreated: '4/20/2024',
        rating: 13,
        pinned: false,
    },
    {
        title: 'Zoomies',
        handle: 'zoomies',
        description: 'Let your cat have virtual playdates',
        type: 'Saas/App',
        dateCreated: '5/05/2024',
        rating: 51,
        pinned: false,
    },
    {
        title: 'BreakupBot',
        handle: 'breakupbot',
        description: 'End it gently, with algorithms',
        type: 'Saas',
        dateCreated: '6/11/2024',
        rating: 74,
        pinned: false,
    },
    {
        title: 'Blipflix',
        handle: 'blipflix',
        description: 'All shows under 60 seconds',
        type: 'Streaming/App',
        dateCreated: '7/07/2024',
        rating: 89,
        pinned: false,
    },
    {
        title: 'Quiet Connect',
        handle: 'quiet-connect',
        description: 'Professional networking without the small talk',
        type: 'Saas/Social',
        dateCreated: '8/19/2024',
        rating: 38,
        pinned: false,
    },
    {
        title: 'Brew World',
        handle: 'brew-world',
        description: 'Smell and hear coffee shops from home',
        type: 'VR/App',
        dateCreated: '9/01/2024',
        rating: 60,
        pinned: false,
    },
    {
        title: 'NameFame',
        handle: 'namefame',
        description: 'It’s like baby-name Tinder but for founders too',
        type: 'Saas/Utility',
        dateCreated: '10/10/2024',
        rating: 92,
        pinned: false,
    },
    {
        title: 'Trash Garden',
        handle: 'trash-garden',
        description: 'Nurture and grow your worst startup concepts',
        type: 'Web App',
        dateCreated: '11/23/2024',
        rating: 21,
        pinned: false,
    },
    {
        title: 'SnackChain',
        handle: 'snackchain',
        description: 'Decentralized snacking economy',
        type: 'Blockchain',
        dateCreated: '12/01/2024',
        rating: 17,
        pinned: false,
    },
    {
        title: 'PunlyFans',
        handle: 'punlyfans',
        description: 'Premium access to the cringiest jokes on the web',
        type: 'Content Platform',
        dateCreated: '12/25/2024',
        rating: 69,
        pinned: false,
    },
    {
        title: 'RockTalk',
        handle: 'rocktalk',
        description: 'Where your inanimate friends come alive online',
        type: 'Social/App',
        dateCreated: '1/01/2025',
        rating: 12,
        pinned: true,
    },
    {
        title: 'SorryTube',
        handle: 'sorrytube',
        description: 'Instant influencer-grade apologies for any scandal',
        type: 'Saas/Tool',
        dateCreated: '1/15/2025',
        rating: 101,
        pinned: true,
    },
]);

const ideas = computed(() => {
    return [...ideasArray].sort((a, b) => {
        if (a.pinned != b.pinned && (a.pinned || b.pinned)) {
            return a.pinned ? -1 : 1;
        }

        return b.rating - a.rating;
    });
});

const log = (val: any) => {
    console.log(val);
};
</script>

<template>
    <Head title="All" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 overflow-scroll">
                <div v-for="idea in ideas" :key="idea.title" class="">
                    <IdeaListItem
                        :title="idea.title"
                        :handle="idea.handle"
                        :description="idea.description"
                        :type="idea.type"
                        :dateCreated="idea.dateCreated"
                        :rating="idea.rating"
                        :pinned="idea.pinned"
                        :link="route('ideas/show')"
                        @pinned="(isPinned: boolean) => (idea.pinned = isPinned)"
                    />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
