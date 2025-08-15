<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ChevronLeft, ChevronRight, CirclePlus, Ellipsis, Rows3 } from 'lucide-vue-next';

const goBack = () => {
    window.history.back();
};

const goForward = () => {
    window.history.forward();
};
</script>
<template>
    <div class="fixed bottom-0 flex w-full justify-between bg-background px-6 py-2 pb-8 md:hidden md:px-4">
        <button @click="goBack" class="group">
            <ChevronLeft class="text-foreground group-disabled:text-foreground/30" />
        </button>

        <button @click="goForward" class="group">
            <ChevronRight class="text-foreground group-disabled:text-foreground/30" />
        </button>
        <Link :href="route('ideas.create')">
            <CirclePlus class="text-primary" />
        </Link>

        <Link :href="route('ideas.index')">
            <Rows3 class="text-primary" />
        </Link>
        <Ellipsis class="text-primary" />
        <!--<Menu class="text-primary" />-->
    </div>
</template>
