<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import LandingNav from '@/components/custom/landing/LandingNav.vue';
import LandingHeroClean from '@/components/custom/landing/hero/LandingHeroClean.vue';
import LandingHeroMatter from '@/components/custom/landing/hero/LandingHeroMatter.vue';
import LandingHeroThree from '@/components/custom/landing/hero/LandingHeroThree.vue';
import LandingPhilosophy from '@/components/custom/landing/LandingPhilosophy.vue';
import LandingCoreLoop from '@/components/custom/landing/LandingCoreLoop.vue';
import LandingFeatures from '@/components/custom/landing/LandingFeatures.vue';
import LandingWhyTerrible from '@/components/custom/landing/LandingWhyTerrible.vue';
import LandingSocialProof from '@/components/custom/landing/LandingSocialProof.vue';
import LandingCTA from '@/components/custom/landing/LandingCTA.vue';

interface Props {
    auth: {
        user: any | null;
    };
}

const props = defineProps<Props>();

// Hero variation selector - change this to switch between hero styles
// Options: 'clean', 'matter', 'three'
const heroType = ref<'clean' | 'matter' | 'three'>('matter');
</script>

<template>
    <Head title="Terrible Startups - Turn Your Ideas Into Reality">
        <meta name="description" content="Document 100 startup ideas. 99 will be terrible. 1 will change everything. Quantity leads to quality." />
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <div class="min-h-screen bg-background text-foreground">
        <!-- Navigation -->
        <LandingNav :authenticated="!!auth.user" />

        <!-- Hero Section - Switchable -->
        <LandingHeroClean v-if="heroType === 'clean'" />
        <LandingHeroMatter v-else-if="heroType === 'matter'" />
        <LandingHeroThree v-else-if="heroType === 'three'" />

        <!-- Philosophy Section -->
        <LandingPhilosophy />

        <!-- Core Loop Section -->
        <LandingCoreLoop />

        <!-- Features Section -->
        <LandingFeatures />

        <!-- Why Terrible Section -->
        <LandingWhyTerrible />

        <!-- Social Proof -->
        <LandingSocialProof />

        <!-- Final CTA -->
        <LandingCTA />

        <!-- Footer -->
        <footer class="border-t py-8">
            <div class="container px-4 sm:px-8">
                <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
                    <p class="text-sm text-muted-foreground">
                        © 2025 Terrible Startups. All rights reserved.
                    </p>
                    <div class="flex gap-6 text-sm">
                        <a href="#" class="text-muted-foreground hover:text-foreground">Privacy</a>
                        <a href="#" class="text-muted-foreground hover:text-foreground">Terms</a>
                        <a :href="route('login')" class="text-muted-foreground hover:text-foreground">Login</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<style scoped>
/* Smooth scroll behavior */
html {
    scroll-behavior: smooth;
}
</style>
