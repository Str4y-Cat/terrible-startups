<script setup lang="ts">
const props = defineProps<{
    parent: string;
    label: string;
    selected?: boolean;
}>();
import { CircleX } from 'lucide-vue-next';

const emit = defineEmits<{
    (e: 'toggle', tag: { key: string; value: string }): void;
}>();
</script>

<template>
    <span class="sr-only">{{ parent }}</span>
    <button
        class="flex cursor-pointer items-center rounded bg-muted/50 px-3 py-2 transition-colors duration-400 data-[active=true]:bg-primary/20 data-[active=true]:text-primary"
        :data-active="selected"
        @click.prevent="emit('toggle', { key: props.parent, value: props.label })"
    >
        <span>
            {{ label }}
        </span>
        <div
            class="transition-width relative w-0 text-primary duration-200"
            :class="{
                'block w-7': selected,
                'delay-200': !selected,
            }"
        >
            <CircleX
                class="linear absolute right-0 size-5 -translate-y-[50%] text-primary"
                :class="{
                    'opacity-100 transition-opacity delay-200 duration-100': selected,
                    'opacity-0': !selected,
                }"
            />
        </div>
    </button>
</template>
