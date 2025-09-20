<script setup lang="ts">
import Tag from '../Tag.vue';
defineProps<{
    title?: string;
    status?: string;
}>();
</script>

<template>
    <div class="mb-8 rounded">
        <div class="flex justify-between">
            <h3 v-if="title" class="text-xl font-bold">{{ title }}</h3>

            <Tag v-if="status == 'complete'" class="border-green-500 bg-green-500/20 text-sm text-green-500">
                <span>Complete</span>
            </Tag>

            <Tag v-if="status == 'progress'" class="border-orage-500 bg-orange-500/20 text-sm text-orange-500">
                <span>In Progress</span>
            </Tag>
        </div>
        <slot></slot>
    </div>
</template>
