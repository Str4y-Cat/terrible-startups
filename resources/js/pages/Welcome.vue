<script setup lang="ts">
import LandingHero from '@/components/custom/landing/hero/LandingHero.vue';
import LandingHeroVideo from '@/components/custom/landing/hero/LandingHeroVideo.vue';
import LandingCTA from '@/components/custom/landing/LandingCTA.vue';
import LandingHowTerrible from '@/components/custom/landing/LandingHowTerrible.vue';
import LandingNav from '@/components/custom/landing/LandingNav.vue';
import LandingWhatTerrible from '@/components/custom/landing/LandingWhatTerrible.vue';
import { Head } from '@inertiajs/vue3';

interface Props {
    auth: {
        user: any | null;
    };
}

const props = defineProps<Props>();
console.log(props.auth);
</script>

<template>
    <Head title="Terrible Startups - Turn Your Ideas Into Reality">
        <meta name="description" content="Document 100 startup ideas. 99 will be terrible. 1 will change everything." />
    </Head>

    <LandingNav :authenticated="auth.user != null ? true : false" />

    <div class="mx-auto min-h-screen max-w-screen-2xl bg-background px-6 text-foreground sm:px-8">
        <LandingHero />

        <LandingHeroVideo src="" />

        <!-- Core Loop Section -->
        <LandingWhatTerrible />

        <!-- Why Terrible Section -->
        <LandingHowTerrible />

        <!-- Social Proof -->
        <!--<LandingSocialProof />-->

        <!-- Final CTA -->
        <LandingCTA />

        <!-- Footer -->
        <footer v-if="false" class="border-t py-8">
            <div class="container px-4 sm:px-8">
                <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
                    <p class="text-sm text-muted-foreground">© 2025 Terrible Startups. All rights reserved.</p>
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
