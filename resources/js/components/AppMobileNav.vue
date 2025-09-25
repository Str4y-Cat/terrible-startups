<script setup lang="ts">
import { useHistory } from '@/composables/useHistory';
import useIdeaOptions from '@/composables/useIdeaOptions';
import { Idea } from '@/types/general';
import { Link, usePage } from '@inertiajs/vue3';
import { ChevronLeft, ChevronRight, Download, Ellipsis, Plus, Rows3, Share, Trash2 } from 'lucide-vue-next';
import { Component, onMounted } from 'vue';
import ActionsDrawer from './custom/ActionsDrawer.vue';
import { ButtonVariants } from './ui/button';
const { canGoBack, canGoForward, goBack, goForward, position } = useHistory();

onMounted(() => {
    canGoBack();
    canGoForward();
});

interface ActionItem {
    label: string;
    disabled?: boolean;
    icon?: Component;
    class?: string;
    onClick?: () => void;
    variant?: ButtonVariants;
}
const page = usePage();

const idea = page.props.idea as Idea;
const { deleteIdea, downloadIdea } = useIdeaOptions(idea);
let actions: ActionItem[] | null = null;

if (idea) {
    actions = [
        { label: 'Share', icon: Share, disabled: true, onClick: () => {} },
        { label: 'Save', icon: Download, onClick: downloadIdea },
        { label: 'Delete', class: 'mt-4', icon: Trash2, onClick: deleteIdea, variant: 'destructive' },
    ];
}
</script>

<template>
    <div class="flex w-full justify-between bg-background px-6 py-2 pb-8 md:hidden md:px-4">
        <button :disabled="!canGoBack()" @click="goBack" class="group">
            <ChevronLeft class="text-primary group-disabled:text-foreground/30" />
        </button>

        <button :disabled="!canGoForward()" @click="goForward" class="group">
            <ChevronRight class="text-primary group-disabled:text-foreground/30" />
        </button>

        <Link :href="route('ideas.create')">
            <Plus class="text-primary" />
        </Link>

        <Link :href="route('ideas.index')">
            <Rows3 class="text-primary" />
        </Link>
        <ActionsDrawer :disabled="true" :actions="actions">
            <Ellipsis class="text-primary" />
        </ActionsDrawer>
        <!--<Menu class="text-primary" />-->
    </div>
</template>
