<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import { useForm } from '@inertiajs/vue3';
import { debouncedWatch } from '@vueuse/core';
import { LoaderCircle } from 'lucide-vue-next';
import { onMounted, ref } from 'vue';
import Tag from '../Tag.vue';

interface Note {
    contents: string;
    updated_at: string;
}
const props = defineProps<{
    idea_id: string;
    note: Note;
}>();

// const content = ref(props.content);

// FORM
// --------------------------------------
const form = useForm<{
    contents: string;
}>({
    contents: props.note.contents || '',
});

const submit = (value: string) => {
    form.contents = value;
    form.put(route('note.update', { idea: props.idea_id }), {
        onFinish: () => {
            console.log('sent the note update');
        },
        onSuccess: () => {
            console.log('Success');
        },
        onError: () => {
            console.log('failed to update the note');
        },
    });
};

// --------------------------------------

// This can be removed when 'field-sizing-content' becomes widely accepted
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

// Autosave function
const contents = ref(props.note.contents);
debouncedWatch(
    contents,
    () => {
        submit(contents.value || '');
        console.log('debounced');
    },
    { debounce: 500 },
);
</script>

<template>
    <div class="mt-8 rounded border border-dashed p-4">
        <div class="flex justify-between">
            <h3 class="text-2xl font-bold">Notes</h3>

            <div>
                <Tag class="relative text-sm text-foreground/70 transition-opacity">
                    <span
                        class="absolute right-0 block"
                        :class="{
                            'opacity-0': form.processing,
                            'opacity-100': !form.processing,
                        }"
                        >Saved</span
                    >
                    <LoaderCircle
                        class="absolute right-0 h-4 w-4 opacity-0"
                        :class="{
                            'animate-spin opacity-100': form.processing,
                        }"
                    />
                </Tag>
            </div>
        </div>
        <div class="relative mt-4">
            <Textarea
                @update:modelValue="
                    (value) => {
                        contents = `${value}`;
                        autoResize();
                    }
                "
                :id="`note_textarea_${props.idea_id}`"
                :modelValue="contents"
                placeholder="Example content ..."
                class="field-sizing-content min-h-60 resize-none border-none bg-input/0 p-1 text-foreground/70 shadow-none focus-visible:ring-0 sm:min-h-30 dark:bg-input/0"
            />

            <InputError class="absolute top-0 right-0" :message="form.errors.contents" />
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
