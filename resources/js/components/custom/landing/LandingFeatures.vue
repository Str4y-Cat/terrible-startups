<script setup lang="ts">
import { Zap, Gauge, TrendingUp, Sparkles, FolderKanban, Download } from 'lucide-vue-next';
</script>

<template>
    <section class="border-y bg-muted/30 py-16 sm:py-24">
        <div class="container px-4 sm:px-8">
            <div class="mx-auto max-w-6xl">
                <!-- Header -->
                <div class="mb-12 text-center">
                    <h2 class="mb-4 text-3xl font-bold tracking-tight sm:text-4xl">
                        Built for Speed
                    </h2>
                    <p class="mx-auto max-w-2xl text-lg text-muted-foreground">
                        Every feature designed to help you create more ideas, faster.
                    </p>
                </div>

                <!-- Features grid -->
                <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Feature 1 -->
                    <div class="rounded-lg border bg-card p-6">
                        <div class="mb-4 flex size-12 items-center justify-center rounded-lg bg-primary/10">
                            <Zap class="size-6 text-primary" />
                        </div>
                        <h3 class="mb-2 text-lg font-semibold">Lightning-Fast Capture</h3>
                        <p class="text-sm text-muted-foreground">
                            Brain dump an idea in 60 seconds. No complicated forms, no overthinking.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="rounded-lg border bg-card p-6">
                        <div class="mb-4 flex size-12 items-center justify-center rounded-lg bg-primary/10">
                            <Gauge class="size-6 text-primary" />
                        </div>
                        <h3 class="mb-2 text-lg font-semibold">Smart Rating Engine</h3>
                        <p class="text-sm text-muted-foreground">
                            Science-backed questionnaire system to objectively evaluate your ideas.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="rounded-lg border bg-card p-6">
                        <div class="mb-4 flex size-12 items-center justify-center rounded-lg bg-primary/10">
                            <TrendingUp class="size-6 text-primary" />
                        </div>
                        <h3 class="mb-2 text-lg font-semibold">Progressive Detail</h3>
                        <p class="text-sm text-muted-foreground">
                            Only flesh out what matters. Start broad, get specific with the winners.
                        </p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="rounded-lg border bg-card p-6">
                        <div class="mb-4 flex size-12 items-center justify-center rounded-lg bg-primary/10">
                            <Sparkles class="size-6 text-primary" />
                        </div>
                        <h3 class="mb-2 text-lg font-semibold">AI Tool Suite</h3>
                        <p class="text-sm text-muted-foreground">
                            Competitor search, SWOT analysis, Reddit communities. More tools added regularly.
                        </p>
                    </div>

                    <!-- Feature 5 -->
                    <div class="rounded-lg border bg-card p-6">
                        <div class="mb-4 flex size-12 items-center justify-center rounded-lg bg-primary/10">
                            <FolderKanban class="size-6 text-primary" />
                        </div>
                        <h3 class="mb-2 text-lg font-semibold">Idea Portfolio</h3>
                        <p class="text-sm text-muted-foreground">
                            Track everything. Spot patterns. See which types of ideas score highest.
                        </p>
                    </div>

                    <!-- Feature 6 -->
                    <div class="rounded-lg border bg-card p-6">
                        <div class="mb-4 flex size-12 items-center justify-center rounded-lg bg-primary/10">
                            <Download class="size-6 text-primary" />
                        </div>
                        <h3 class="mb-2 text-lg font-semibold">Export Ready</h3>
                        <p class="text-sm text-muted-foreground">
                            Take your best ideas anywhere. Your data, your way.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
