<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';
import { createBallPitWorld, handleResize, type BallData } from '@/lib/landing/matterSetup';
import { useMediaQuery } from '@vueuse/core';

const canvasRef = ref<HTMLCanvasElement | null>(null);
const containerRef = ref<HTMLDivElement | null>(null);
const hoveredBall = ref<{ label: string; x: number; y: number } | null>(null);
const hoverTimeout = ref<NodeJS.Timeout | null>(null);

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
    canvasRef.value.addEventListener('mouseleave', handleMouseLeave);
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
        canvasRef.value.removeEventListener('mouseleave', handleMouseLeave);
    }
    if (hoverTimeout.value) {
        clearTimeout(hoverTimeout.value);
    }
});

function handleMouseMove(event: MouseEvent) {
    if (!world || !canvasRef.value) return;

    const rect = canvasRef.value.getBoundingClientRect();
    const x = event.clientX - rect.left;
    const y = event.clientY - rect.top;

    // Check if mouse is over any ball
    const hoveredBody = world.balls.find((ball) => {
        const dx = ball.position.x - x;
        const dy = ball.position.y - y;
        const distance = Math.sqrt(dx * dx + dy * dy);
        return distance < (ball.circleRadius || 20);
    });

    if (hoveredBody) {
        const data = world.ballData.get(hoveredBody);

        // Clear existing timeout
        if (hoverTimeout.value) {
            clearTimeout(hoverTimeout.value);
        }

        // Set new timeout for 300ms delay
        hoverTimeout.value = setTimeout(() => {
            if (data) {
                hoveredBall.value = {
                    label: data.label,
                    x: hoveredBody.position.x,
                    y: hoveredBody.position.y,
                };
            }
        }, 300);
    } else {
        // Clear timeout and reset hover
        if (hoverTimeout.value) {
            clearTimeout(hoverTimeout.value);
            hoverTimeout.value = null;
        }
        hoveredBall.value = null;
    }
}

function handleMouseLeave() {
    if (hoverTimeout.value) {
        clearTimeout(hoverTimeout.value);
        hoverTimeout.value = null;
    }
    hoveredBall.value = null;
}
</script>

<template>
    <section class="bg-gradient-to-b from-background to-muted/30 py-20 sm:py-32">
        <div class="container px-4 sm:px-8">
            <div class="grid gap-12 lg:grid-cols-2 lg:gap-16">
                <!-- Left Column - Text Content -->
                <div class="flex flex-col justify-center">
                    <!-- Headline -->
                    <h1 class="mb-6 text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">
                        Most Ideas Are Terrible.<br />
                        <span class="bg-gradient-to-r from-primary to-primary/60 bg-clip-text text-transparent">
                            Yours Too.
                        </span>
                    </h1>

                    <!-- Subheadline -->
                    <p class="mb-8 text-lg text-muted-foreground sm:text-xl">
                        But somewhere in the chaos is your gem. Let's find it.
                    </p>

                    <!-- CTAs -->
                    <div class="flex flex-col gap-4 sm:flex-row">
                        <Link
                            :href="route('register')"
                            class="inline-flex h-12 items-center justify-center rounded-md bg-primary px-8 text-sm font-medium text-primary-foreground shadow-lg ring-offset-background transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                        >
                            Start Creating
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
                        <span class="hidden sm:inline">Drag the balls around • </span>Hover to reveal idea names
                    </p>
                </div>

                <!-- Right Column - Ball Pit -->
                <div class="relative flex items-center justify-center">
                    <div ref="containerRef" class="relative h-[500px] w-full overflow-hidden rounded-lg border bg-muted/30">
                        <canvas ref="canvasRef" class="size-full rounded-lg"></canvas>

                        <!-- Expanded ball with text overlay -->
                        <Transition name="expand">
                            <div
                                v-if="hoveredBall"
                                class="pointer-events-none absolute flex items-center justify-center rounded-full bg-primary/90 text-center text-sm font-medium text-primary-foreground shadow-lg backdrop-blur-sm transition-all duration-300"
                                :style="{
                                    left: `${hoveredBall.x}px`,
                                    top: `${hoveredBall.y}px`,
                                    transform: 'translate(-50%, -50%)',
                                    width: '120px',
                                    height: '120px',
                                    padding: '1rem',
                                }"
                            >
                                <span class="leading-tight">{{ hoveredBall.label }}</span>
                            </div>
                        </Transition>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
.expand-enter-active,
.expand-leave-active {
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.expand-enter-from {
    opacity: 0;
    transform: translate(-50%, -50%) scale(0.5);
}

.expand-leave-to {
    opacity: 0;
    transform: translate(-50%, -50%) scale(0.8);
}
</style>
