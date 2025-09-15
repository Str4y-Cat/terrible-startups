<script setup lang="ts">
import AppContent from '@/components/AppContent.vue';
import AppMobileNav from '@/components/AppMobileNav.vue';
import AppShell from '@/components/AppShell.vue';
import AppSidebar from '@/components/AppSidebar.vue';
import AppSidebarHeader from '@/components/AppSidebarHeader.vue';
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppShell variant="sidebar" class="overflow-hidden">
        <AppSidebar />
        <AppContent variant="sidebar" class="overflow-hidden">
            <template #header>
                <AppSidebarHeader :breadcrumbs="breadcrumbs" />
            </template>

            <slot />

            <template #footer>
                <AppMobileNav />
            </template>
        </AppContent>
    </AppShell>
</template>
