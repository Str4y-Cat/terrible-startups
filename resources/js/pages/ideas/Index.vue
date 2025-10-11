<script setup lang="ts">
import IdeaList from '@/components/custom/index/IdeaList.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Idea } from '@/types/general';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { Plus, Search } from 'lucide-vue-next';
import { computed, ref } from 'vue';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Ideas',
        href: '/ideas',
    },
];

// const ideasArray;
const page = usePage();
const originalIdeas = page.props.ideas as Idea[];
originalIdeas.sort((a, b) => {
    return b.rating - a.rating;
});

const searchTerm = ref('');

const ideas = computed(() => {
    return originalIdeas.filter((idea) => {
        return idea.title.includes(searchTerm.value);
    });
});
</script>

<template>
    <Head title="Terrible ideas" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl sm:p-4">
            <!--<IdeaTable :ideas="ideas" />-->
            <div v-if="ideas.length == 0" class="flex h-full w-full grow items-center justify-center">
                <div class="flex flex-col items-center">
                    <h1 class="bold mb-4 w-fit text-xl text-muted-foreground sm:text-4xl">You have no saved ideas yet</h1>
                    <Button @click.prevent variant="secondary" class="w-fit">
                        <Link :href="route('ideas.create')" class="flex gap-2">
                            Create new idea
                            <Plus class="size-5" />
                        </Link>
                    </Button>
                </div>
            </div>

            <template v-else>
                <div class="mt-4 flex justify-center px-4 sm:justify-end">
                    <div class="relative w-full max-w-sm items-center">
                        <Input v-model="searchTerm" id="search" type="text" placeholder="Search..." class="pl-10" />
                        <span class="absolute inset-y-0 start-0 flex items-center justify-center px-2">
                            <Search class="size-5 text-muted-foreground" />
                        </span>
                    </div>
                </div>

                <IdeaList :ideas="ideas" />
            </template>
        </div>
    </AppLayout>
</template>
