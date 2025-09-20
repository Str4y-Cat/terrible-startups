<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import { useAutosaveField } from '@/composables/useAutosaveField';
import { onMounted, ref, watch } from 'vue';

interface Note {
    contents: string;
    updated_at: string;
}
const props = defineProps<{
    idea_id: number;
    note?: Note;
}>();

const emit = defineEmits<{
    (e: 'processing', value: boolean): void;
}>();

const { localValue, errorMessage, isSaving } = useAutosaveField(
    route('note.update', { idea: props.idea_id }),
    'contents',
    props.note?.contents ?? '',
);

watch(isSaving, (newVal) => {
    emit('processing', newVal);
});

// This can be removed when 'field-sizing-content' becomes widely accepted
// REFACTOR: move this to a composable
//------------------------------------------------------------------------
const textarea = ref<HTMLTextAreaElement | null>(null);

onMounted(() => {
    textarea.value = document.querySelector(`#note_textarea_${props.idea_id}`);
    autoResize();
});

function autoResize() {
    if (!textarea.value) return;
    textarea.value.style.height = 'auto'; // Reset height
    textarea.value.style.height = textarea.value.scrollHeight + 'px'; // Set new height
}

//------------------------------------------------------------------------
</script>

<template>
    <div class="mt-8 rounded border border-dashed p-4">
        <div class="flex justify-between">
            <h3 class="text-2xl font-bold">Notes</h3>
        </div>
        <div class="relative mt-4">
            <Textarea
                @update:modelValue="autoResize()"
                :id="`note_textarea_${props.idea_id}`"
                v-model="localValue"
                placeholder="Example content ..."
                class="field-sizing-content min-h-60 resize-none border-none bg-input/0 p-0 text-foreground/70 shadow-none focus-visible:ring-0 sm:min-h-30 dark:bg-input/0"
            />

            <InputError class="absolute top-0 right-0" :message="errorMessage" />
        </div>
    </div>

    <!--

const form = useForm<{
    title?: string;
    rating?: number;
    overview?: string;
    type?: string;
    problem_to_solve?: string;
    inspiration?: string;
    solution?: string;
    features?: string[];
    target_audience?: string[];
    risks?: string[];
    challenges?: string[];
    rating_questions?: { key: number; value: number }[];
    tags?: { key: string; value: string }[];
}>({
    title: '',
    rating: 0,
    overview: '',
    type: '',
    problem_to_solve: '',
    inspiration: '',
    solution: '',
    // features: [''],
    // features: [''],
    // target_audience: [''],
    // risks: [''],
    // challenges: [''],
    tags: [],
    rating_questions: [{ key: 0, value: 0 }],
});

const submit = () => {
    // form.rating_questions = [...stripratingsforsubmit()];
    console.log('This is the form data', form.data());
    form.post(route('ideas.store'), {
        onFinish: () => {
            /*navigate to form */
        },
        onError: (error) => {
            console.log(error);
        },
    });
};
<TextInput
    :modelValue="form.inspiration"
    :error="form.errors.inspiration"
    label="Inspiration"
    id="inspiration"
    @update="(value) => (form.inspiration = value)"
></TextInput>
--></template>
