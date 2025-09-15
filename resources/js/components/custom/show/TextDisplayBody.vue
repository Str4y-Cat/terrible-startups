<script setup lang="ts">
defineProps<{
    title?: string;
    body?: string;
}>();
</script>

<template>
    <div class="mt-6">
        <h4 v-if="title" class="mb-3 font-bold">{{ title }}</h4>
        <p class="text-foreground/50">
            <span v-if="!body">Still need to complete</span>
            {{ body }}
        </p>
    </div>
</template>
