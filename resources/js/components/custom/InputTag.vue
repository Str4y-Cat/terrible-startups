<script setup lang="ts">
const props = defineProps<{
    label: string;
    selected?: boolean;
}>();

const emit = defineEmits<{
    (e: 'toggle', label: string): void;
}>();
</script>

<template>
    <span
        class="cursor-pointer rounded border px-2 py-1 data-[active=true]:bg-primary/30"
        :data-active="selected"
        @click="emit('toggle', props.label)"
    >
        {{ label }}
    </span>
</template>
