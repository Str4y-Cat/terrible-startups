<script setup lang="ts">
const props = defineProps<{
    title: string;
    status?: string;
}>();
</script>

<template>
    <div class="mt-8 border border-dashed p-2">
        <div class="flex justify-between">
            <h3 class="text-2xl font-bold">{{ props.title }}</h3>

            <div
                class="rounded px-2 py-1 text-sm"
                :class="{
                    'border-green-500 bg-green-500/20 text-green-500': props.status == 'complete',
                    'border-orage-500 bg-orange-500/20 text-orange-500': props.status == 'progress',
                }"
            >
                <span v-if="props.status == 'complete'">Complete</span>
                <span v-if="props.status == 'progress'">In Progress</span>
            </div>
        </div>
        <slot></slot>
    </div>
</template>
