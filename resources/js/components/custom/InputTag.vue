<script setup lang="ts">
const props = defineProps<{
    parent: string;
    label: string;
    selected?: boolean;
}>();

const emit = defineEmits<{
    (e: 'toggle', tag: { key: string; value: string }): void;
}>();
</script>

<template>
    <span class="sr-only">{{ parent }}</span>
    <span
        class="cursor-pointer rounded border border-primary px-2 py-1 data-[active=true]:bg-primary/30"
        :data-active="selected"
        @click="emit('toggle', { key: props.parent, value: props.label })"
    >
        {{ label }}
    </span>
</template>
