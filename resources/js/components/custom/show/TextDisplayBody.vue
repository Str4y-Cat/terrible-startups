<script setup lang="ts">
const props = defineProps<{
    title: string;
    body: string;
}>();
</script>

<template>
    <div class="mt-2">
        <h4>{{ props.title }}</h4>
        <p class="text-foreground/70">
            <span v-if="!props.body">Still need to complete</span>
            {{ props.body }}
        </p>
    </div>
</template>
