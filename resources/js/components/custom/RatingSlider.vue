<script setup lang="ts">
import { Slider } from '@/components/ui/slider';
import { ref } from 'vue';
const emit = defineEmits(['rating']);
const rating = ref(0);
const props = defineProps<{
    label: string;
    description: string;
    currentValue: number;
}>();

// :model-value="[rating]"
// const rating = computed((val) => {
//     return val[0];
// });

const updateRating = (x: number[] | undefined) => {
    if (x) {
        rating.value = x[0];
        emit('rating', rating.value);
    }
};
</script>

<template>
    <div>
        <div class="text-sm">
            <p class="">{{ props.label }}</p>
            <p class="text-foreground/50">{{ props.description }}</p>
        </div>
        <div class="mb-4 flex gap-2 pe-6">
            <Slider @update:model-value="updateRating" :default-value="[props.currentValue]" :max="3" :step="1"></Slider>
            <span class="w-3">{{ props.currentValue >= 0 ? props.currentValue : '-' }}</span>
        </div>
    </div>
</template>
