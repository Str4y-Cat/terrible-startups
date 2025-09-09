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
    <button
        class="cursor-pointer rounded bg-muted/50 px-2 py-1 data-[active=true]:bg-primary/20 data-[active=true]:text-primary"
        :data-active="selected"
        @click.prevent="emit('toggle', { key: props.parent, value: props.label })"
    >
        {{ label }}
    </button>
</template>
