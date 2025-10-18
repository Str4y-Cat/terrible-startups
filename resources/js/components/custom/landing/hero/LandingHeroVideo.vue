<script lang="ts" setup>
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import SectionWide from '../SectionWide.vue';
</script>
<template>
    <SectionWide>
        <div class="relative mx-auto aspect-3/4 max-h-[90svh] overflow-hidden rounded-3xl border border-4 sm:aspect-4/3 lg:w-full">
            <PlaceholderPattern class="!stoke-muted-foreground"></PlaceholderPattern>
        </div>
    </SectionWide>
</template>
