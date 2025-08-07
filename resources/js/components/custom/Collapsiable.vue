<script setup lang="ts">
import { Collapsible, CollapsibleContent, CollapsibleTrigger } from '@/components/ui/collapsible';
import { ChevronRight } from 'lucide-vue-next';
import { ref } from 'vue';

const isOpen = ref(false);
</script>

<template>
    <Collapsible v-model:open="isOpen">
        <CollapsibleTrigger>
            <div class="mb-4 flex items-center gap-2 text-foreground/50">
                Add more Information
                <component :is="ChevronRight" :size="17" :class="{ 'rotate-90': isOpen }" />
            </div>
        </CollapsibleTrigger>
        <CollapsibleContent>
            <slot />
        </CollapsibleContent>
    </Collapsible>
</template>
