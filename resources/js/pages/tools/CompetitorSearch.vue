<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';

const page = usePage();
console.log(page.props);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Ideas',
        href: '/ideas',
    },
    {
        title: page.props.idea.title,
        href: `/ideas/${page.props.idea.id}`,
    },
    {
        title: 'competitor search',
        href: `/ideas/${page.props.idea.id}/competitor-search`,
    },
];
</script>

<template>
    <Head title="Terrible ideas" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <h1 class="text-4xl">hello this is the competitor search page</h1>
        </div>
    </AppLayout>
</template>
