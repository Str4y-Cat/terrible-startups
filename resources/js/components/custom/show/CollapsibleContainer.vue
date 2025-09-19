<script setup lang="ts">
import { Collapsible, CollapsibleContent, CollapsibleTrigger } from '@/components/ui/collapsible';
import { Maximize2, Minimize2 } from 'lucide-vue-next';
import { ref } from 'vue';
const props = defineProps<{
    title: string;
    open?: boolean;
}>();
const isOpen = ref(props.open || false);
</script>

<template>
    <div class="mt-8 rounded border border-dashed">
        <Collapsible v-model:open="isOpen">
            <CollapsibleTrigger class="group flex w-full cursor-pointer items-center p-4 text-left">
                <div class="flex-grow text-2xl font-bold">
                    {{ title }}
                </div>
                <div class="rounded-full bg-muted/0 p-4 text-foreground/70 transition-colors *:size-5 group-hover:bg-muted">
                    <Minimize2 v-if="isOpen" />
                    <Maximize2 v-else />
                </div>
            </CollapsibleTrigger>
            <CollapsibleContent class="p-4"><slot /></CollapsibleContent>
        </Collapsible>
    </div>
</template>
