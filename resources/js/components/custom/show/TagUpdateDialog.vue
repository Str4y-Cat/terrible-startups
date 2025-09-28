<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { ScrollArea } from '@/components/ui/scroll-area';
import TagInputGroup from '../TagInputGroup.vue';

import { useForm } from '@inertiajs/vue3';
import { computed, reactive, watch } from 'vue';
const props = defineProps<{
    tag_groups: object;
    selected_tags: { key: string; value: string }[];
    modelValue?: boolean;
    idea_id: number;
}>();

const emit = defineEmits<{
    (e: 'update:modelValue', value: boolean): void;
    (e: 'success', value: { key: string; value: string }[]): void;
    (e: 'skip'): void;
    (e: 'close'): void;
    (e: 'processing', value: boolean): void;
}>();

const isOpen = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value),
});

//FIX: may cause reactivity error here
const tags = reactive<{ key: string; value: string }[]>(JSON.parse(JSON.stringify(props.selected_tags ?? [])));

// const tags = ref<{ key: string; value: string }[]>([...props.selected_tags]);

const form = useForm<{
    tags?: { key: string; value: string }[];
}>({
    tags: [],
});

const submit = () => {
    form.tags = tags;

    emit('processing', true);
    form.post(route('tags.sync', { idea: props.idea_id }), {
        onFinish: () => {
            emit('processing', false);
        },
        onSuccess: () => {
            isOpen.value = false;
            emit('success', tags);
        },
        onError: (error) => {},
    });
};

watch(
    tags,
    (newVal) => {
        console.log('tags have been updated', newVal);
        // form.tags = tags;
        // submit();
    },
    { deep: true },
);
</script>

<template>
    <Dialog v-model:open="isOpen" class="max-h-[80svh]">
        <DialogTrigger as-child>
            <slot></slot>
        </DialogTrigger>
        <DialogContent>
            <DialogHeader class="border border-dashed border-transparent border-b-border pb-2">
                <DialogTitle>Update Tags</DialogTitle>
                <DialogDescription>Change associated tags</DialogDescription>
            </DialogHeader>

            <ScrollArea class="max-h-[60svh]">
                <!--
                <TagUpdateInputGroup
                    @added="(val) => addTag(val)"
                    @removed="(val) => removeTag(val)"
                    :tag_group="tag_groups"
                    :selected_tags="tags"
                    v-model:selected="tags"
                ></TagUpdateInputGroup>
-->

                <TagInputGroup :tag_group="tag_groups" :selected_tags="tags" v-model:selected="tags"></TagInputGroup>
            </ScrollArea>

            <DialogFooter>
                <Button @click.prevent="submit" variant="ghost"> Save changes </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
