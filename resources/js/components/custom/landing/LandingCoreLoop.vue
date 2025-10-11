<script setup lang="ts">
import { Zap, Target, FileText, Search } from 'lucide-vue-next';
</script>

<template>
    <section id="how-it-works" class="bg-background py-16 sm:py-24">
        <div class="container px-4 sm:px-8">
            <div class="mx-auto max-w-6xl">
                <!-- Header -->
                <div class="mb-12 text-center">
                    <h2 class="mb-4 text-3xl font-bold tracking-tight sm:text-4xl">
                        The Terrible Startups Method
                    </h2>
                    <p class="mx-auto max-w-2xl text-lg text-muted-foreground">
                        30 minutes from brain dump to validated. Then move to the next one.
                    </p>
                </div>

                <!-- 4-step process -->
                <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-4">
                    <!-- Step 1 -->
                    <div class="relative">
                        <div class="mb-4 flex size-12 items-center justify-center rounded-lg bg-primary/10">
                            <Zap class="size-6 text-primary" />
                        </div>
                        <h3 class="mb-2 text-xl font-semibold">Brain Dump</h3>
                        <p class="mb-2 text-sm font-medium text-primary">Capture When Inspiration Hits</p>
                        <p class="text-sm text-muted-foreground">
                            No forms. No friction. Just get it down. Capture your idea in minutes, not hours.
                        </p>
                        <!-- Connector arrow for desktop -->
                        <div class="absolute right-0 top-6 hidden translate-x-1/2 lg:block">
                            <svg class="size-6 text-muted-foreground/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative">
                        <div class="mb-4 flex size-12 items-center justify-center rounded-lg bg-primary/10">
                            <Target class="size-6 text-primary" />
                        </div>
                        <h3 class="mb-2 text-xl font-semibold">Subjective Rating</h3>
                        <p class="mb-2 text-sm font-medium text-primary">Quick, Proven Rating System</p>
                        <p class="text-sm text-muted-foreground">
                            Questionnaire-based scoring gives you an honest strength assessment. Know which ideas deserve more attention.
                        </p>
                        <div class="absolute right-0 top-6 hidden translate-x-1/2 lg:block">
                            <svg class="size-6 text-muted-foreground/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative">
                        <div class="mb-4 flex size-12 items-center justify-center rounded-lg bg-primary/10">
                            <FileText class="size-6 text-primary" />
                        </div>
                        <h3 class="mb-2 text-xl font-semibold">Expand</h3>
                        <p class="mb-2 text-sm font-medium text-primary">Double Down on the Good Ones</p>
                        <p class="text-sm text-muted-foreground">
                            High score? Intrigued? Fill out features, challenges, risks. Give the app context to work with.
                        </p>
                        <div class="absolute right-0 top-6 hidden translate-x-1/2 lg:block">
                            <svg class="size-6 text-muted-foreground/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div>
                        <div class="mb-4 flex size-12 items-center justify-center rounded-lg bg-primary/10">
                            <Search class="size-6 text-primary" />
                        </div>
                        <h3 class="mb-2 text-xl font-semibold">Dig Deeper</h3>
                        <p class="mb-2 text-sm font-medium text-primary">AI-Powered Analysis</p>
                        <p class="text-sm text-muted-foreground">
                            Competitor research, SWOT analysis, community finder. More context = better results. <strong>+ More tools coming.</strong>
                        </p>
                    </div>
                </div>

                <!-- CTA -->
                <div class="mt-12 text-center">
                    <p class="text-sm text-muted-foreground">
                        Repeat this loop 100 times. One of them will be gold.
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>
