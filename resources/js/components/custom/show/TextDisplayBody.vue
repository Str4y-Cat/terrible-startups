<script setup lang="ts">
const props = defineProps<{
    title: string;
    body: string;
}>();
</script>

<template>
    <div class="mt-6">
        <h4 class="mb-3 font-bold">{{ props.title }}</h4>
        <p class="text-foreground/50">
            <span v-if="!props.body">Still need to complete</span>
            {{ props.body }}
        </p>
    </div>
</template>
