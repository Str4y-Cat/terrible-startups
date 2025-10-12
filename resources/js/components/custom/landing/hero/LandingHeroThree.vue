<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';
import { createParticleScene } from '@/lib/landing/threeSetup';
import { useMediaQuery } from '@vueuse/core';

const containerRef = ref<HTMLDivElement | null>(null);
const isMobile = useMediaQuery('(max-width: 768px)');

let scene: ReturnType<typeof createParticleScene> | null = null;
let resizeObserver: ResizeObserver | null = null;

onMounted(() => {
    if (!containerRef.value) return;

    // Create the 3D particle scene
    scene = createParticleScene(containerRef.value, isMobile.value);

    // Handle resize
    resizeObserver = new ResizeObserver(() => {
        if (scene) {
            scene.resize();
        }
    });

    resizeObserver.observe(containerRef.value);
});

onUnmounted(() => {
    if (scene) {
        scene.cleanup();
    }
    if (resizeObserver) {
        resizeObserver.disconnect();
    }
});
</script>

<template>
    <section class="relative bg-gradient-to-b from-background to-muted/30 py-20 sm:py-32">
        <!-- 3D Particle container -->
        <div ref="containerRef" class="absolute inset-0 opacity-60"></div>

        <!-- Content overlay -->
        <div class="container relative z-10 px-4 sm:px-8">
            <div class="mx-auto max-w-4xl text-center">
                <!-- Headline -->
                <h1 class="mb-6 text-4xl font-bold tracking-tight text-foreground sm:text-6xl lg:text-7xl">
                    Stop Perfecting.<br />
                    <span class="bg-gradient-to-r from-primary to-primary/60 bg-clip-text text-transparent">
                        Start Creating.
                    </span>
                </h1>

                <!-- Subheadline -->
                <p class="mx-auto mb-8 max-w-2xl text-lg text-foreground/90 sm:text-xl">
                    Document 100 startup ideas. 99 will be terrible. 1 will change everything.
                    <strong class="block mt-2 font-semibold text-foreground">Quantity leads to quality.</strong>
                </p>

                <!-- CTAs -->
                <div class="flex flex-col items-center justify-center gap-4 sm:flex-row">
                    <Link
                        :href="route('register')"
                        class="inline-flex h-12 items-center justify-center rounded-md bg-primary px-8 text-sm font-medium text-primary-foreground shadow-lg ring-offset-background transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                    >
                        Start Your First Idea
                    </Link>
                    <a
                        href="#how-it-works"
                        class="inline-flex h-12 items-center justify-center rounded-md border border-input bg-background/80 px-8 text-sm font-medium backdrop-blur-sm ring-offset-background transition-colors hover:bg-accent hover:text-accent-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                    >
                        See How It Works
                    </a>
                </div>

                <!-- Hint text -->
                <p class="mt-6 text-sm text-muted-foreground">
                    <span class="hidden sm:inline">Move your mouse to explore " </span>Red, yellow, and green represent idea quality
                </p>
            </div>
        </div>

        <!-- Bottom gradient fade -->
        <div class="pointer-events-none absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-background to-transparent"></div>
    </section>
</template>
