<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const ideasCount = ref(0);
const targetCount = 47293;

const floatingIdeas = [
    'Blockchain for Houseplants',
    'AI-Powered Socks',
    'Uber for Lost Keys',
    'Netflix for Dreams',
    'Tinder for Furniture',
    'Airbnb for Bathrooms',
    'Instagram for Ants',
    'Pet Rock 2.0',
];

// Animate counter on mount
onMounted(() => {
    const duration = 2000;
    const steps = 60;
    const increment = targetCount / steps;
    const stepDuration = duration / steps;

    let current = 0;
    const timer = setInterval(() => {
        current += increment;
        if (current >= targetCount) {
            ideasCount.value = targetCount;
            clearInterval(timer);
        } else {
            ideasCount.value = Math.floor(current);
        }
    }, stepDuration);
});
</script>

<template>
    <section class="relative overflow-hidden bg-gradient-to-b from-background to-muted/30 py-20 sm:py-32">
        <!-- Floating idea cards in background -->
        <div class="pointer-events-none absolute inset-0 overflow-hidden opacity-40">
            <div
                v-for="(idea, index) in floatingIdeas"
                :key="idea"
                class="absolute animate-float rounded-lg border bg-card px-3 py-2 text-xs font-medium shadow-sm"
                :style="{
                    left: `${(index * 13) % 90}%`,
                    top: `${(index * 17) % 80}%`,
                    animationDelay: `${index * 0.5}s`,
                    animationDuration: `${8 + index}s`,
                }"
            >
                {{ idea }}
            </div>
        </div>

        <!-- Content -->
        <div class="container relative z-10 px-4 sm:px-8">
            <div class="mx-auto max-w-4xl text-center">
                <!-- Badge -->
                <div class="mb-6 inline-flex items-center gap-2 rounded-full border bg-background/80 px-4 py-1.5 text-sm font-medium backdrop-blur-sm">
                    <span class="relative flex size-2">
                        <span class="absolute inline-flex size-full animate-ping rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex size-2 rounded-full bg-green-500"></span>
                    </span>
                    <span class="font-mono">{{ ideasCount.toLocaleString() }}</span> terrible ideas created
                </div>

                <!-- Headline -->
                <h1 class="mb-6 text-4xl font-bold tracking-tight sm:text-6xl lg:text-7xl">
                    Stop Perfecting.<br />
                    <span class="bg-gradient-to-r from-primary to-primary/60 bg-clip-text text-transparent">
                        Start Creating.
                    </span>
                </h1>

                <!-- Subheadline -->
                <p class="mx-auto mb-8 max-w-2xl text-lg text-muted-foreground sm:text-xl">
                    Document 100 startup ideas. 99 will be terrible. 1 will change everything.
                    Research shows: <strong class="font-semibold text-foreground">quantity leads to quality</strong>.
                </p>

                <!-- CTAs -->
                <div class="flex flex-col items-center justify-center gap-4 sm:flex-row">
                    <Link
                        :href="route('register')"
                        class="inline-flex h-12 items-center justify-center rounded-md bg-primary px-8 text-sm font-medium text-primary-foreground ring-offset-background transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                    >
                        Start Your First Idea
                    </Link>
                    <a
                        href="#how-it-works"
                        class="inline-flex h-12 items-center justify-center rounded-md border border-input bg-background px-8 text-sm font-medium ring-offset-background transition-colors hover:bg-accent hover:text-accent-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                    >
                        See How It Works
                    </a>
                </div>

                <!-- Subtext -->
                <p class="mt-6 text-sm text-muted-foreground">
                    Free forever. No credit card required. Start in 60 seconds.
                </p>
            </div>
        </div>

        <!-- Bottom gradient fade -->
        <div class="pointer-events-none absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-background to-transparent"></div>
    </section>
</template>

<style scoped>
@keyframes float {
    0%,
    100% {
        transform: translateY(0) rotate(-3deg);
    }
    50% {
        transform: translateY(-20px) rotate(3deg);
    }
}

.animate-float {
    animation: float 8s ease-in-out infinite;
}
</style>
