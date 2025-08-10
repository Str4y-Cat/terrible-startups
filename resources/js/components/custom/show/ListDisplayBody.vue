<script setup lang="ts">
const props = defineProps<{
    title: string;
    body: string[];
}>();
</script>

<template>
    <div class="mt-6">
        <h4 class="mb-3 font-bold">{{ props.title }}</h4>
        <ul class="text-foreground/50">
            <li v-for="(item, index) in body" :key="index">{{ item }}</li>
        </ul>
    </div>
</template>
