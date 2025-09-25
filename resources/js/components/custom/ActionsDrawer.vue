<script setup lang="ts">
import { Drawer, DrawerContent, DrawerFooter, DrawerTrigger } from '@/components/ui/drawer';
import type { Component } from 'vue';
import type { ButtonVariants } from '../ui/button';
import Button from '../ui/button/Button.vue';

interface ActionItem {
    label: string;
    disabled?: boolean;
    icon?: Component;
    class?: string;
    onClick?: () => void;
    variant?: ButtonVariants;
}

defineProps<{
    actions?: ActionItem[];
}>();
</script>

<template>
    <Drawer v-if="actions || true">
        <DrawerTrigger>
            <slot></slot>
        </DrawerTrigger>

        <DrawerContent>
            <div class="divider-x-primary mx-auto mt-8 flex min-h-50 w-full max-w-sm flex-col gap-3">
                <Button
                    :variant="action.variant ?? 'secondary'"
                    v-for="action in actions"
                    :key="action.label"
                    class="flex w-full items-center justify-between border-b font-bold"
                    :disabled="action.disabled"
                    :class="action.class"
                    @click="action.onClick"
                >
                    {{ action.label }}
                    <component v-if="action.icon" :is="action.icon" class="mr-2 size-5" />
                </Button>

                <DrawerFooter v-if="false">
                    <Button> Delete </Button>
                </DrawerFooter>
            </div>
        </DrawerContent>
    </Drawer>
</template>
