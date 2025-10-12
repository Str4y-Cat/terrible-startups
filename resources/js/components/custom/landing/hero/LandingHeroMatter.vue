<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';
import { createBallPitWorld, handleResize } from '@/lib/landing/matterSetup';
import { useMediaQuery } from '@vueuse/core';

const canvasRef = ref<HTMLCanvasElement | null>(null);
const containerRef = ref<HTMLDivElement | null>(null);

const isMobile = useMediaQuery('(max-width: 768px)');

let world: ReturnType<typeof createBallPitWorld> | null = null;
let resizeObserver: ResizeObserver | null = null;

onMounted(() => {
    if (!canvasRef.value) return;

    // Set initial canvas size
    const container = containerRef.value;
    if (container) {
        canvasRef.value.width = container.clientWidth;
        canvasRef.value.height = container.clientHeight;
    }

    // Create the card world
    world = createBallPitWorld(canvasRef.value, isMobile.value);

    // Handle resize
    resizeObserver = new ResizeObserver(() => {
        if (canvasRef.value && world) {
            handleResize(canvasRef.value, world.render, world.engine);
        }
    });

    if (container) {
        resizeObserver.observe(container);
    }
});

onUnmounted(() => {
    if (world) {
        world.cleanup();
    }
    if (resizeObserver) {
        resizeObserver.disconnect();
    }
});
</script>

<template>
    <section class="relative min-h-screen bg-gradient-to-b from-background to-muted/30">
        <!-- Full-screen canvas container -->
        <div ref="containerRef" class="absolute inset-0">
            <canvas ref="canvasRef" class="size-full"></canvas>
        </div>

        <!-- Centered content overlay -->
        <div class="relative z-10 flex min-h-screen items-center justify-center px-4 py-20 sm:px-8 sm:py-32">
            <div class="mx-auto max-w-4xl text-center">
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

                <!-- Hint text -->
                <p class="mt-6 text-sm text-muted-foreground">
                    <span class="hidden sm:inline">Drag the cards around • </span>Play with the terrible ideas
                </p>

                <!-- Subtext -->
                <p class="mt-4 text-sm text-muted-foreground">
                    Free forever. No credit card required. Start in 60 seconds.
                </p>
            </div>
        </div>

        <!-- Bottom gradient fade -->
        <div class="pointer-events-none absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-background to-transparent"></div>
    </section>
</template>

