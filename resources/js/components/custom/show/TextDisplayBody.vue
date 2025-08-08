<script setup lang="ts">
const props = defineProps<{
    title: string;
    body: string;
}>();
</script>

<template>
    <div class="mt-4">
        <h4 class="font-bold">{{ props.title }}</h4>
        <p class="text-foreground/50">
            <span v-if="!props.body">Still need to complete</span>
            {{ props.body }}
        </p>
    </div>
</template>
