<script setup lang="ts">
import { Slider } from '@/components/ui/slider';
import { ref } from 'vue';
const emit = defineEmits(['rating']);
const rating = ref(0);

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
    <h1>hello</h1>
    <div class="flex gap-2">
        <Slider @update:model-value="updateRating" :default-value="[0]" :max="10" :step="1"></Slider>
        <span>{{ rating }}</span>
    </div>
</template>
