<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Link } from '@inertiajs/vue3';
import { Check } from 'lucide-vue-next';
import Section from './Section.vue';
</script>

<template>
    <Section class="flex min-h-[100svh] items-center justify-center">
        <!-- Headline -->
        <h2 class="mb-4 text-3xl font-bold sm:text-4xl lg:text-4xl">Your First Idea Will Be Terrible</h2>
        <p class="mb-8 text-lg text-muted-foreground">So will #2, #5, and #17. But #23? That's the one.</p>

        <!-- CTA Button -->
        <div class="mb-8">
            <Button @click.prevent size="lg">
                <Link :href="route('register')" class="font-bold sm:text-lg"> Create Your First Terrible Idea </Link>
            </Button>
        </div>

        <!-- Value props -->
        <div v-if="false" class="flex flex-col gap-3 text-sm text-muted-foreground sm:flex-row sm:justify-center sm:gap-6">
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
    </Section>
</template>
