<script setup lang="ts">
import { Dialog, DialogContent, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { SquarePen } from 'lucide-vue-next';
import { ref, watch } from 'vue';
import Button from '../ui/button/Button.vue';
import BulletTextInput from './create/BulletTextInput.vue';
const emit = defineEmits<{
    (e: 'update:isOpen', value: boolean): void;
    (e: 'save', payload: { target: string; value: string[] }): void;
}>();

const props = withDefaults(
    defineProps<{
        title?: string;
        list?: string[];
        isOpen: boolean;
        form_target?:
            | ''
            | 'title'
            | 'overview'
            | 'problem_to_solve'
            | 'inspiration'
            | 'solution'
            | 'features'
            | 'target_audience'
            | 'risks'
            | 'challenges';
    }>(),
    {
        isOpen: false,
        title: '',
        body: '',
        form_target: '',
    },
);

const inputValue = ref(['']);

watch(
    () => props.isOpen,
    (open) => {
        if (open) {
            inputValue.value = props.list ?? [''];
        }
    },
);

function submit() {
    if (!props.form_target) return;
    console.log('submitting', inputValue.value);
    emit('save', {
        target: props.form_target,
        value: inputValue.value,
    });

    emit('update:isOpen', false);
}
</script>

<template>
    <Dialog v-model:open="props.isOpen" @update:open="$emit('update:isOpen', $event)">
        <DialogContent>
            <DialogHeader>
                <DialogTitle>
                    <div class="flex items-center gap-2">
                        <SquarePen />
                        {{ props.title }}
                    </div>
                </DialogTitle>
            </DialogHeader>

            <form @submit.prevent="submit">
                <BulletTextInput v-model="inputValue" label="" :id="props.form_target" class="max-h-[70vh]" @update="inputValue = $event" />
                <Button class="mt-4" type="submit">Save</Button>
            </form>
        </DialogContent>
    </Dialog>
</template>
