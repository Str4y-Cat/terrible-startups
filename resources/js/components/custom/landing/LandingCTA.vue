<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Check } from 'lucide-vue-next';
</script>

<template>
    <section class="bg-gradient-to-b from-background to-muted/30 py-16 sm:py-24">
        <div class="container px-4 sm:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <!-- Headline -->
                <h2 class="mb-4 text-3xl font-bold tracking-tight sm:text-4xl lg:text-5xl">
                    Your First Idea Will Probably Be Terrible
                </h2>
                <p class="mb-8 text-lg text-muted-foreground">
                    So will #2, #5, and #17. But #23? That's the one.
                </p>

                <!-- CTA Button -->
                <div class="mb-8">
                    <Link
                        :href="route('register')"
                        class="inline-flex h-14 items-center justify-center rounded-md bg-primary px-10 text-base font-medium text-primary-foreground shadow-lg ring-offset-background transition-all hover:bg-primary/90 hover:shadow-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                    >
                        Create Your First Terrible Idea
                    </Link>
                </div>

                <!-- Value props -->
                <div class="flex flex-col gap-3 text-sm text-muted-foreground sm:flex-row sm:justify-center sm:gap-6">
                    <div class="flex items-center justify-center gap-2">
                        <Check class="size-4 text-primary" />
                        <span>Free forever</span>
                    </div>
                    <div class="flex items-center justify-center gap-2">
                        <Check class="size-4 text-primary" />
                        <span>No credit card required</span>
                    </div>
                    <div class="flex items-center justify-center gap-2">
                        <Check class="size-4 text-primary" />
                        <span>Start in 60 seconds</span>
                    </div>
                    <div class="flex items-center justify-center gap-2">
                        <Check class="size-4 text-primary" />
                        <span>Export anytime</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
