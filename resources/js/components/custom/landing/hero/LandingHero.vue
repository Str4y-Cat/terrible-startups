<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <section class="">
        <!-- Centered content overlay -->
        <div class="relative z-10 flex items-center justify-center border border-red-500 py-20 sm:py-32">
            <div class="mx-auto max-w-4xl border border-red-500 text-center">
                <!-- Headline -->
                <h1 class="mb-6 text-5xl font-bold tracking-tight sm:text-6xl lg:text-7xl">
                    Stop Perfecting.<br />
                    <span class="text-primary"> Start Creating. </span>
                </h1>

                <!-- Subheadline -->
                <p class="mx-auto mb-8 max-w-2xl text-lg text-muted-foreground sm:text-xl">
                    The best way to keep track, validate and share your startup ideas.<br />100 startup ideas. 99 will be terrible. 1 will change
                    everything.
                </p>

                <Button @click.prevent>
                    <Link :href="route('register')" class="w-full border"> Create Your First Idea</Link>
                </Button>
            </div>
        </div>
    </section>
</template>
