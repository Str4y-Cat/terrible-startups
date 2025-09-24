<script setup lang="ts">
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { Ellipsis } from 'lucide-vue-next';
import type { Component } from 'vue';

interface ActionItem {
    label: string;
    disabled?: boolean;
    icon?: Component;
    class?: string;
    onClick?: () => void;
}

defineProps<{
    actions: ActionItem[];
}>();
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger>
            <div class="transition-color aspect-1/1 rounded-full bg-white/0 p-4 hover:bg-white/20">
                <Ellipsis />
            </div>
        </DropdownMenuTrigger>

        <DropdownMenuContent>
            <DropdownMenuLabel>Actions</DropdownMenuLabel>
            <DropdownMenuSeparator />

            <DropdownMenuItem v-for="action in actions" :key="action.label" :disabled="action.disabled" :class="action.class" @click="action.onClick">
                <component v-if="action.icon" :is="action.icon" class="mr-2" :class="action.class" />
                {{ action.label }}
            </DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
