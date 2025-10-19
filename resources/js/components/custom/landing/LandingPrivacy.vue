<script setup lang="ts">
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import Section from './Section.vue';
</script>

<template>
    <Section>
        <!-- Header -->
        <div class="mb-12 text-center">
            <h2 class="mb-4 text-4xl font-bold tracking-tight sm:text-4xl">Privacy by default. Always.</h2>
            <p class="mx-auto max-w-2xl text-lg/8 text-muted-foreground">
                Your privacy is a big deal. We keep your data encrypted so only you can view it. Don't believe us? Our code is out in the open, you
                can audit it for yourself.
            </p>
        </div>
        <div class="relative aspect-7/5 w-full overflow-hidden rounded-2xl border border-4 sm:aspect-10/5">
            <PlaceholderPattern />
        </div>

        <!-- Ideas grid -->
    </Section>
</template>
