<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { useAutosaveField } from '@/composables/useAutosaveField';
import { Dot } from 'lucide-vue-next';
import { computed, nextTick, onMounted, ref, watch } from 'vue';

const props = defineProps<{
    bullets?: string[];
    field: string;
    idea_id: number;
}>();

// const emit = defineEmits<{
//     (e: 'update:', value: string[]): void;
// }>();

// const bullets = ref<string[]>(props.bullets ?? ['']);
const { localValue, errorMessage, isSaving } = useAutosaveField(route('ideas.update', { idea: props.idea_id }), props.field, props.bullets ?? [''], {
    deep: true,
});

// FORM
// --------------------------------------
const emit = defineEmits<{
    (e: 'processing', value: boolean): void;
}>();

watch(isSaving, (newVal) => {
    console.log('is saving');
    emit('processing', newVal);
});

//------------------------------------------------------------
// Keep track of textareas
const textareas = ref<(HTMLTextAreaElement | null)[]>([]);
onMounted(() => {
    const tempareas = document.querySelectorAll(`#bullet-container-${props.field} textarea`);
    tempareas.forEach((area) => {
        autoResize(area);
    });
});

function autoResize(el: HTMLTextAreaElement | null) {
    if (!el) return;
    el.style.height = 'auto'; // Reset height
    el.style.height = el.scrollHeight + 'px'; // Set new height
}
//------------------------------------------------------------

function onInput(e: Event, index: number) {
    const value = (e.target as HTMLTextAreaElement).value;
    autoResize(e.target as HTMLTextAreaElement);
    localValue.value[index] = value;
    // emit('update:modelValue', bullets.value);
    // console.log('PUSHING BULLET POINT CHANGES');
    // console.log(props.field, localValue.value[index]);
    //NOTE:do work here
}

const lastItemFull = computed(() => {
    // console.log(localValue.value[localValue.value.length - 1] != '');
    return localValue.value[localValue.value.length - 1] != '';
});

function createBullet(index: number) {
    localValue.value.splice(index + 1, 0, '');
    // emit('update:modelValue', bullets.value);

    // Wait for DOM update, then focus new bullet
    nextTick(() => {
        const newTextarea = textareas.value[index + 1];

        // newTextarea?.value = '';
        if (newTextarea) {
            newTextarea.focus();
        }
    });
}

function removeBullet(index: number) {
    localValue.value.splice(index, 1);

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

    if (e.key === 'Backspace' && localValue.value[index] === '' && localValue.value.length > 1) {
        e.preventDefault();
        removeBullet(index);
    }
}
</script>

<template>
    <div class="group/parent mt-2 grid gap-2">
        <div class="flex flex-col gap-1" :id="`bullet-container-${props.field}`">
            <div v-for="(bullet, index) in localValue" :key="index" class="group flex items-start gap-2">
                <Dot class="transition-color group-has-focus:text-primary"></Dot>

                <textarea
                    :ref="(el) => (textareas[index] = el)"
                    :id="index === 0 ? props.field : undefined"
                    class="w-full resize-none border-none bg-input/0 p-1 text-foreground/70 focus-visible:ring-0 focus-visible:outline-none"
                    :value="bullet"
                    placeholder="Bullet Point"
                    @input="(e) => onInput(e, index)"
                    @keydown="(e) => onKeyDown(e, index)"
                    rows="1"
                ></textarea>
            </div>
            <div
                @click="if (lastItemFull) createBullet(localValue.length - 1);"
                class="flex items-center gap-2 text-foreground/50 transition-opacity ease-in"
                :class="{ 'opacity-0': !lastItemFull }"
            >
                <Dot></Dot>
                <p class="block p-1">New bullet point</p>
            </div>
        </div>

        <InputError :message="errorMessage" />
    </div>
</template>
