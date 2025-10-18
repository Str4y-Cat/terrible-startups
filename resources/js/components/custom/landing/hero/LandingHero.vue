<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Link } from '@inertiajs/vue3';
import Section from '../Section.vue';
</script>

<template>
    <Section>
        <!-- Headline -->
        <h1 class="mb-6 text-5xl font-bold tracking-tight sm:text-6xl lg:text-7xl">
            Stop Perfecting.<br />
            <span class="text-primary"> Start Creating. </span>
        </h1>

        <!-- Subheadline -->
        <p class="mx-auto mb-8 max-w-2xl text-lg text-muted-foreground sm:text-xl">
            The best way to keep track, validate and share your startup ideas.<br />100 startup ideas. 99 will be terrible. 1 will change everything.
        </p>

        <Button size="lg" @click.prevent>
            <Link :href="route('register')" class="w-full font-bold sm:text-lg">Create Your First Terrible Idea</Link>
        </Button>
    </Section>
</template>
