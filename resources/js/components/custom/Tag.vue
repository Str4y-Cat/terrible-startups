<script setup lang="ts">
import { ref } from 'vue';
const props = defineProps<{
    class?: string | object;
}>();
const active = ref(false);
</script>

<template>
    <div :class="props.class" :data-active="active" @click="active = !active" class="flex h-fit items-center rounded px-2 py-0.5">
        <slot> </slot>
    </div>
</template>
