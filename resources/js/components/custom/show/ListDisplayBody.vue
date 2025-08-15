<script setup lang="ts">
import { Dot } from 'lucide-vue-next';
const props = defineProps<{
    title: string;
    body?: string[];
}>();
</script>

<template>
    <div class="mt-6">
        <h4 class="mb-3 font-bold">{{ props.title }}</h4>
        <ul class="text-foreground/50">
            <li v-for="(item, index) in body" class="mt-2" :key="index">
                <div class="group flex items-start gap-2">
                    <Dot class="transition-color min-w-[24px] group-has-focus:text-primary"></Dot>
                    <span>
                        {{ item }}
                    </span>
                </div>
            </li>
        </ul>
    </div>
</template>
