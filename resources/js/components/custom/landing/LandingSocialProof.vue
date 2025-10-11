<script setup lang="ts">
import { ref, onMounted } from 'vue';

const stats = ref([
    { label: 'Ideas Created', value: 0, target: 47293, suffix: '' },
    { label: 'Gems Discovered', value: 0, target: 1847, suffix: '' },
    { label: 'Avg. Time Per Idea', value: 0, target: 28, suffix: ' min' },
]);

onMounted(() => {
    stats.value.forEach((stat, index) => {
        const duration = 2000;
        const steps = 60;
        const increment = stat.target / steps;
        const stepDuration = duration / steps;

        let current = 0;
        const timer = setInterval(() => {
            current += increment;
            if (current >= stat.target) {
                stat.value = stat.target;
                clearInterval(timer);
            } else {
                stat.value = Math.floor(current);
            }
        }, stepDuration);
    });
});
</script>

<template>
    <section class="border-y bg-primary/5 py-16">
        <div class="container px-4 sm:px-8">
            <div class="mx-auto max-w-5xl">
                <div class="grid gap-8 sm:grid-cols-3">
                    <div v-for="stat in stats" :key="stat.label" class="text-center">
                        <div class="mb-2 font-mono text-4xl font-bold tabular-nums text-primary sm:text-5xl">
                            {{ stat.value.toLocaleString() }}{{ stat.suffix }}
                        </div>
                        <div class="text-sm font-medium text-muted-foreground">
                            {{ stat.label }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
