<script setup lang="ts">
const props = defineProps<{
    class?: string | object;
}>();
</script>

<template>
    <div :class="props.class" class="inline h-fit rounded px-2 py-0.5">
        <slot> </slot>
    </div>
</template>
