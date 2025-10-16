<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { Link } from '@inertiajs/vue3';

interface Props {
    authenticated?: boolean;
}

withDefaults(defineProps<Props>(), {
    authenticated: false,
});
</script>

<template>
    <header class="sticky top-0 z-50 w-full border-b border-border/40 bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60">
        <div class="container flex h-14 max-w-screen-2xl items-center justify-between px-4 sm:px-8">
            <!-- Logo -->
            <Link :href="route('home')" class="flex items-center space-x-2">
                <div class="flex h-8 w-8 items-center justify-center rounded-md">
                    <AppLogoIcon class="size-9 fill-current text-[var(--foreground)] dark:text-white" />
                </div>
                <span class="hidden font-bold sm:inline-block">Terrible Startups</span>
            </Link>

            <!-- Navigation -->
            <nav class="flex items-center gap-4">
                <Link
                    v-if="authenticated"
                    :href="route('ideas.index')"
                    class="inline-flex items-center justify-center rounded-md px-4 py-2 text-sm font-medium ring-offset-background transition-colors hover:bg-accent hover:text-accent-foreground focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none"
                >
                    Dashboard
                </Link>

                <template v-else>
                    <Link
                        :href="route('login')"
                        class="inline-flex items-center justify-center rounded-md px-4 py-2 text-sm font-medium ring-offset-background transition-colors hover:bg-accent hover:text-accent-foreground focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none"
                    >
                        Log in
                    </Link>
                    <Link
                        :href="route('register')"
                        class="inline-flex items-center justify-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground ring-offset-background transition-colors hover:bg-primary/90 focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none"
                    >
                        Get Started
                    </Link>
                </template>
            </nav>
        </div>
    </header>
</template>
