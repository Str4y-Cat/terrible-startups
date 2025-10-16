<script setup lang="ts">
import { Brain, Hammer, NotebookPen, RefreshCcw, Share } from 'lucide-vue-next';
const terribleIdeas = [
    {
        icon: NotebookPen,
        title: 'Quick idea creation',
        description: 'Ideas are easy to jot down when isperation hits. ',
    },
    {
        icon: Brain,
        title: 'Offline vaidation',
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
    <section class="border border-red-500 bg-background">
        <div class="mx-auto my-16 max-w-6xl">
            <!-- Header -->
            <div class="mb-12 text-center">
                <h2 class="mb-4 text-4xl font-bold tracking-tight sm:text-4xl">What is Terrible Statups?</h2>
                <p class="mx-auto max-w-2xl text-lg/8 text-muted-foreground">
                    Every billion-dollar company started as a terrible idea. The only way to find the gems is to make. Terrible statups is a way to
                    keep all your ideas in one place, and validate them as you go.
                </p>
            </div>

            <!-- Ideas grid -->
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <div v-for="(item, index) in terribleIdeas" :key="item.title" class="rounded border">
                    <div class="mb-3 flex items-center justify-start gap-2">
                        <component :is="item.icon" class="size-6" />
                        <h3 class="font-bold">{{ item.title }}</h3>
                    </div>
                    <p class="text-muted-foreground">{{ item.description }}</p>
                </div>
            </div>
        </div>
    </section>
</template>
