<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';
import { createBallPitWorld, handleResize } from '@/lib/landing/matterSetup';
import { useMediaQuery } from '@vueuse/core';

const canvasRef = ref<HTMLCanvasElement | null>(null);
const containerRef = ref<HTMLDivElement | null>(null);
const hoveredBall = ref<string | null>(null);
const mousePosition = ref({ x: 0, y: 0 });

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

    // Create the ball pit
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

    // Add hover detection
    canvasRef.value.addEventListener('mousemove', handleMouseMove);
});

onUnmounted(() => {
    if (world) {
        world.cleanup();
    }
    if (resizeObserver) {
        resizeObserver.disconnect();
    }
    if (canvasRef.value) {
        canvasRef.value.removeEventListener('mousemove', handleMouseMove);
    }
});

function handleMouseMove(event: MouseEvent) {
    if (!world || !canvasRef.value) return;

    const rect = canvasRef.value.getBoundingClientRect();
    const x = event.clientX - rect.left;
    const y = event.clientY - rect.top;

    mousePosition.value = { x: event.clientX, y: event.clientY };

    // Check if mouse is over any ball
    const hoveredBody = world.balls.find((ball) => {
        const dx = ball.position.x - x;
        const dy = ball.position.y - y;
        const distance = Math.sqrt(dx * dx + dy * dy);
        return distance < (ball.circleRadius || 20);
    });

    if (hoveredBody) {
        const data = world.ballData.get(hoveredBody);
        hoveredBall.value = data?.label || null;
    } else {
        hoveredBall.value = null;
    }
}
</script>

<template>
    <section class="relative overflow-hidden bg-gradient-to-b from-background to-muted/30 py-20 sm:py-32">
        <!-- Ball pit container -->
        <div ref="containerRef" class="absolute inset-0">
            <canvas ref="canvasRef" class="size-full"></canvas>
        </div>

        <!-- Tooltip for hovered ball -->
        <Transition name="tooltip">
            <div
                v-if="hoveredBall"
                class="pointer-events-none fixed z-50 rounded-lg border bg-popover px-3 py-2 text-sm text-popover-foreground shadow-md"
                :style="{
                    left: `${mousePosition.x + 15}px`,
                    top: `${mousePosition.y + 15}px`,
                }"
            >
                {{ hoveredBall }}
            </div>
        </Transition>

        <!-- Content overlay -->
        <div class="container relative z-10 px-4 sm:px-8">
            <div class="mx-auto max-w-4xl text-center">
                <!-- Headline -->
                <h1 class="mb-6 text-4xl font-bold tracking-tight text-foreground sm:text-6xl lg:text-7xl">
                    Most Ideas Are Terrible.<br />
                    <span class="bg-gradient-to-r from-primary to-primary/60 bg-clip-text text-transparent">
                        Yours Too.
                    </span>
                </h1>

                <!-- Subheadline -->
                <p class="mx-auto mb-8 max-w-2xl text-lg text-foreground/80 sm:text-xl">
                    But somewhere in the chaos is your gem. Let's find it.
                </p>

                <!-- CTAs -->
                <div class="flex flex-col items-center justify-center gap-4 sm:flex-row">
                    <Link
                        :href="route('register')"
                        class="inline-flex h-12 items-center justify-center rounded-md bg-primary px-8 text-sm font-medium text-primary-foreground shadow-lg ring-offset-background transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                    >
                        Start Creating
                    </Link>
                    <a
                        href="#how-it-works"
                        class="inline-flex h-12 items-center justify-center rounded-md border border-input bg-background/80 px-8 text-sm font-medium backdrop-blur-sm ring-offset-background transition-colors hover:bg-accent hover:text-accent-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                    >
                        Learn More
                    </a>
                </div>

                <!-- Hint text -->
                <p class="mt-6 text-sm text-muted-foreground">
                    <span class="hidden sm:inline">Drag the balls around " </span>Hover to see idea names
                </p>
            </div>
        </div>

        <!-- Bottom gradient fade -->
        <div class="pointer-events-none absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-background to-transparent"></div>
    </section>
</template>

<style scoped>
.tooltip-enter-active,
.tooltip-leave-active {
    transition: opacity 0.15s ease;
}

.tooltip-enter-from,
.tooltip-leave-to {
    opacity: 0;
}
</style>
