<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Label } from '@/components/ui/label';
import { Dot } from 'lucide-vue-next';
import { computed, nextTick, ref, watch } from 'vue';

const props = defineProps<{
    modelValue?: string[];
    error?: string;
    label: string;
    id: string;
}>();

const emit = defineEmits<{
    (e: 'update:modelValue', value: string[]): void;
}>();

const bullets = ref<string[]>(props.modelValue ?? ['']);

// Keep track of textareas
const textareas = ref<(HTMLTextAreaElement | null)[]>([]);

watch(
    () => props.modelValue,
    (newVal) => {
        if (newVal) bullets.value = [...newVal];
    },
);

function autoResize(el: HTMLTextAreaElement | null) {
    if (!el) return;
    el.style.height = 'auto'; // Reset height
    el.style.height = el.scrollHeight + 'px'; // Set new height
}

function onInput(e: Event, index: number) {
    const value = (e.target as HTMLTextAreaElement).value;
    autoResize(e.target as HTMLTextAreaElement);
    bullets.value[index] = value;
    emit('update:modelValue', bullets.value);
}

const lastItemFull = computed(() => {
    console.log(bullets.value[bullets.value.length - 1] != '');
    return bullets.value[bullets.value.length - 1] != '';
});

function createBullet(index: number) {
    bullets.value.splice(index + 1, 0, '');
    emit('update:modelValue', bullets.value);

    // Wait for DOM update, then focus new bullet
    nextTick(() => {
        const newTextarea = textareas.value[index + 1];
        if (newTextarea) {
            newTextarea.focus();
        }
    });
}
function removeBullet(index: number) {
    bullets.value.splice(index, 1);
    emit('update:modelValue', bullets.value);

    // After removal, focus previous bullet if possible
    nextTick(() => {
        const prev = textareas.value[Math.max(index - 1, 0)];
        if (prev) {
            prev.focus();
        }
    });
}

function onKeyDown(e: KeyboardEvent, index: number) {
    if (e.key === 'Enter') {
        e.preventDefault();
        createBullet(index);
    }

    if (e.key === 'Backspace' && bullets.value[index] === '' && bullets.value.length > 1) {
        e.preventDefault();
        removeBullet(index);
    }
}
</script>

<template>
    <div class="group/parent mt-4 grid gap-2">
        <Label
            :for="props.id"
            class="group/parent-has-focus:border-b-primary/20 border-b-1 border-dashed border-transparent border-b-muted pb-1 text-2xl"
            >{{ label }}</Label
        >

        <div class="flex flex-col gap-1">
            <div v-for="(bullet, index) in bullets" :key="index" class="group flex items-start gap-2">
                <Dot class="transition-color group-has-focus:text-primary"></Dot>

                <textarea
                    :ref="(el) => (textareas[index] = el)"
                    :id="index === 0 ? props.id : undefined"
                    class="w-full resize-none border-none bg-input/0 p-1 text-foreground/70 focus-visible:ring-0 focus-visible:outline-none"
                    :value="bullet"
                    placeholder="Bullet Point"
                    @input="(e) => onInput(e, index)"
                    @keydown="(e) => onKeyDown(e, index)"
                    rows="1"
                ></textarea>
            </div>
            <div
                @click="if (lastItemFull) createBullet(bullets.length - 1);"
                class="flex items-center gap-2 text-foreground/50 transition-opacity ease-in"
                :class="{ 'opacity-0': !lastItemFull }"
            >
                <Dot></Dot>
                <p class="block p-1">New bullet point</p>
            </div>
        </div>

        <InputError :message="props.error" />
    </div>
</template>
