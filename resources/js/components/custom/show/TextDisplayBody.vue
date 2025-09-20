<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import { useAutosaveField } from '@/composables/useAutosaveField';
import { onMounted, ref, watch } from 'vue';

const props = defineProps<{
    idea_id: number;
    field: string;
    title?: string;
    body?: string;
}>();

const emit = defineEmits<{
    (e: 'processing', value: boolean): void;
}>();

// FORM
// --------------------------------------
const { localValue, errorMessage, isSaving } = useAutosaveField(route('ideas.update', { idea: props.idea_id }), props.field, props.body ?? '');

watch(isSaving, (newVal) => {
    emit('processing', newVal);
});

// This can be removed when 'field-sizing-content' becomes widely accepted
//------------------------------------------------------------------------
const textarea = ref<HTMLTextAreaElement | null>(null);

onMounted(() => {
    textarea.value = document.querySelector(`#note_textarea_${props.field}`);
    autoResize();
});

function autoResize() {
    if (!textarea.value) return;
    textarea.value.style.height = 'auto'; // Reset height
    textarea.value.style.height = textarea.value.scrollHeight + 'px'; // Set new height
}
</script>

<template>
    <div class="mt-6">
        <div class="relative mt-4">
            <Textarea
                v-model="localValue"
                :id="`note_textarea_${props.field}`"
                placeholder="Example content ..."
                class="field-sizing-content min-h-30 resize-none border-none bg-input/0 p-0 text-foreground/70 shadow-none focus-visible:ring-0 sm:min-h-30 dark:bg-input/0"
            />

            <InputError class="absolute top-0 right-0" :message="errorMessage" />
        </div>
    </div>
</template>
