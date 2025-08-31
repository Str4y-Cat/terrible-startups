<script setup lang="ts">
import IdeaTable from '@/components/custom/IdeaTable.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import { computed, reactive } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Ideas',
        href: '/ideas',
    },
];

// const ideasArray;
const page = usePage();
const ideasArray = reactive(page.props.ideas);

const ideas = computed(() => {
    return [...ideasArray].sort((a, b) => {
        if (a.pinned != b.pinned && (a.pinned || b.pinned)) {
            return a.pinned ? -1 : 1;
        }

        return b.rating - a.rating;
    });
});
</script>

<template>
    <Head title="Terrible ideas" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mb-16 flex flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <IdeaTable :ideas="ideas"></IdeaTable>
        </div>
    </AppLayout>
</template>
