<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
const props = defineProps<{
    modelValue?: string;
    error?: string;
    label: string;
    class?: string;
    id: string;
}>();
</script>
<template>
    <div class="grid gap-2 divide-y-1 divide-solid has-focus:divide-primary/20">
        <Label for="solution" class="text-md sm:text-lg">{{ label }}</Label>
        <Textarea
            @update:modelValue="(value) => $emit('update', value)"
            :id="props.id"
            :modelValue="props.modelValue"
            class="field-sizing-content min-h-30 border-none bg-input/0 p-1 focus-visible:ring-0 dark:bg-input/0"
        />
        <InputError :message="props.error" />
    </div>
</template>
