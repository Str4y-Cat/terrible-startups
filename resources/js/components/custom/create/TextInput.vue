<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { onMounted, ref } from 'vue';
const props = defineProps<{
    modelValue?: string;
    error?: string;
    label: string;
    class?: string;
    required?: boolean;
    id: string;
}>();

// This can be removed when 'field-sizing-content' becomes widely accepted
//------------------------------------------------------------------------
const textarea = ref<Element | null>(null);

onMounted(() => {
    textarea.value = document.querySelector(`#${props.id}`);
    autoResize();
});

function autoResize() {
    if (!textarea.value) return;
    textarea.value.style.height = 'auto'; // Reset height
    textarea.value.style.height = textarea.value.scrollHeight + 'px'; // Set new height
}

defineEmits<{
    (e: 'update', value: string): void;
}>();
//------------------------------------------------------------------------
</script>
<template>
    <div class="group mt-4 grid gap-2">
        <div class="flex items-center gap-2 border-b-1 border-dashed border-transparent border-b-muted group-has-focus:border-b-primary/20">
            <Label for="solution" class="pb-1 text-2xl"> {{ label }}</Label>
            <div class="item-start flex text-red-600" v-if="required"><span class="h-fit">*</span></div>
            <InputError :message="props.error" />
        </div>
        <Textarea
            @update:modelValue="
                (value) => {
                    $emit('update', `${value}`);
                    autoResize();
                }
            "
            :required="required"
            :id="props.id"
            :modelValue="props.modelValue"
            class="field-sizing-content min-h-30 resize-none border-none bg-input/0 p-1 text-foreground/70 focus-visible:ring-0 dark:bg-input/0"
        />
    </div>
</template>
