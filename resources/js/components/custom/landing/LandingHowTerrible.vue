<script setup lang="ts">
import HowTerribleSection from './HowTerribleSection.vue';
import SectionWide from './SectionWide.vue';
const steps = [
    {
        title: 'Brain dump',
        description: 'Capture the idea as soon as inspiration hits, regardless of how silly the idea is, write it down',
    },
    {
        title: 'Quick Validation',
        description:
            "Run through a quick validation, to get an initial feeling for the idea. Don't worry! You can update this as you flesh the idea out",
    },
    {
        title: 'Flesh the idea out',
        description: 'Add more information to the idea. This clarifies things for you and gives more context to the validation tools',
    },
    {
        title: 'Deep dive',
        description: 'Go deeper on your idea by making use of the validation and research tools.',
    },
    {
        title: 'Build and share',
        description: 'Share the idea with others, get crafted prompts to start building an mvp',
    },
];
</script>

<template>
    <SectionWide class="pt-10">
        <!-- Header -->
        <!--
        <div class="mb-12 text-center">
            <h2 class="mb-4 text-4xl font-bold tracking-tight sm:text-4xl">What is Terrible Statups?</h2>
            <p class="mx-auto max-w-2xl text-lg/8 text-muted-foreground">
                Every billion-dollar company started as a terrible idea. The only way to find the gems is to make. Terrible statups is a way to keep
                all your ideas in one place, and validate them as you go.
            </p>
        </div>
        -->

        <!-- Ideas grid -->
        <div class="flex flex-col gap-16">
            <div v-for="(item, index) in steps" :key="item.title" class="rounded">
                <HowTerribleSection :item="item" :index="index" />
            </div>
        </div>
    </SectionWide>
</template>
