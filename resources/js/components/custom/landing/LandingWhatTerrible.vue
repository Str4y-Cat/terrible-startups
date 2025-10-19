<script setup lang="ts">
import { Brain, Hammer, NotebookPen, RefreshCcw, Share } from 'lucide-vue-next';
import Section from './Section.vue';
const terribleIdeas = [
    {
        icon: NotebookPen,
        title: 'Quick idea creation',
        description: 'Ideas are easy to jot down when isperation hits. ',
    },
    {
        icon: Brain,
        title: 'Offline validation',
        description: 'Quick subjective validations',
    },
    {
        icon: RefreshCcw,
        title: 'Auto sync across devices',
        description: 'Never lose access to your work. Your ideas are always backed up and available to all devices',
    },
    {
        icon: Share,
        title: 'Share your ideas',
        description: 'Share your ideas with people in an easy to understand format',
    },
    {
        icon: Hammer,
        title: 'Tools to help you succeed',
        description: 'A library of tools to help you validate and plan your venture',
    },
];
</script>

<template>
    <Section>
        <!-- Header -->
        <div class="mb-12 text-center">
            <h2 class="mb-4 text-4xl font-bold tracking-tight sm:text-4xl">What is Terrible Statups?</h2>
            <p class="mx-auto max-w-2xl text-lg/8 text-muted-foreground">
                Every billion-dollar company started as a terrible idea. Terrible statups speeds up the process of validating and sharing your next
                startup idea. Ideate fast, validate faster.
            </p>
        </div>

        <!-- Ideas grid -->
        <div class="grid grid-cols-2 gap-6 lg:grid-cols-3">
            <div v-for="(item, index) in terribleIdeas" :key="item.title" class="rounded">
                <component :is="item.icon" class="mb-2 size-6 stroke-primary" />
                <h3 class="mb-3 text-left text-xl font-bold">{{ item.title }}</h3>
                <p class="text-left text-lg/8 text-muted-foreground">{{ item.description }}</p>
            </div>
        </div>
    </Section>
</template>
