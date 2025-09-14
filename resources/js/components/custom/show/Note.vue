<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import { useForm } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

const props = defineProps<{
    idea_id: string;
    content?: string;
}>();

// const content = ref(props.content);
console.log(props.content);

// FORM
// --------------------------------------
const form = useForm<{
    contents: string;
}>({
    contents: props.content,
});

const submit = () => {
    console.log('sending the following information:', form.data());
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
//------------------------------------------------------------------------
</script>

<template>
    <div class="relative mt-4">
        <Button variant="ghost" @click.prevent="submit">
            <span v-if="form.processing">Saving</span>
            <span v-else>Save</span>
        </Button>
        <Textarea
            @update:modelValue="
                (value) => {
                    form.contents = `${value}`;
                    autoResize();
                }
            "
            :id="props.id"
            :modelValue="form.contents"
            placeholder="Example content ..."
            class="field-sizing-content min-h-60 resize-none border-none bg-input/0 p-1 text-foreground/70 shadow-none focus-visible:ring-0 sm:min-h-30 dark:bg-input/0"
        />

        <InputError class="absolute top-0 right-0" :message="form.errors.contents" />
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
