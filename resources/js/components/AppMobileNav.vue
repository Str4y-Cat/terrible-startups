<script setup lang="ts">
import { ChevronLeft, ChevronRight, CirclePlus, Menu } from 'lucide-vue-next';
</script>
<template>
    <div class="mb-4 flex w-full justify-between bg-background px-6 py-2 md:hidden md:px-4">
        <div class="flex gap-4">
            <ChevronLeft />
            <ChevronRight />
        </div>
        <CirclePlus />
        <Menu />
    </div>
</template>
