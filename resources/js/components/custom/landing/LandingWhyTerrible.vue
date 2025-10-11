<script setup lang="ts">
const terribleIdeas = [
    {
        idea: 'Airbnb',
        quote: 'Who would stay in a stranger\'s house?',
        value: '$75B valuation',
    },
    {
        idea: 'Twitter',
        quote: 'Nobody cares what you had for lunch',
        value: '$44B acquired',
    },
    {
        idea: 'Snapchat',
        quote: 'Photos that disappear? Why?',
        value: '$18B valuation',
    },
    {
        idea: 'Uber',
        quote: 'Illegal taxis',
        value: '$82B valuation',
    },
    {
        idea: 'Dropbox',
        quote: 'There are already file storage solutions',
        value: '$8B valuation',
    },
    {
        idea: 'Your idea',
        quote: 'Probably terrible too',
        value: '??? =Ž',
    },
];
</script>

<template>
    <section class="bg-background py-16 sm:py-24">
        <div class="container px-4 sm:px-8">
            <div class="mx-auto max-w-6xl">
                <!-- Header -->
                <div class="mb-12 text-center">
                    <h2 class="mb-4 text-3xl font-bold tracking-tight sm:text-4xl">
                        Why "Terrible Startups"?
                    </h2>
                    <p class="mx-auto max-w-2xl text-lg text-muted-foreground">
                        Every billion-dollar company started as a terrible idea.
                    </p>
                </div>

                <!-- Ideas grid -->
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    <div
                        v-for="(item, index) in terribleIdeas"
                        :key="item.idea"
                        class="rounded-lg border bg-card p-6 transition-all hover:border-primary/50 hover:shadow-md"
                        :class="{ 'ring-2 ring-primary/20': item.idea === 'Your idea' }"
                    >
                        <div class="mb-3">
                            <h3 class="text-lg font-semibold">{{ item.idea }}</h3>
                            <p class="text-xs text-muted-foreground italic">"{{ item.quote }}"</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-medium text-primary">{{ item.value }}</span>
                        </div>
                    </div>
                </div>

                <!-- Key message -->
                <div class="mt-12 rounded-lg bg-primary/5 p-6 text-center sm:p-8">
                    <p class="text-lg font-medium sm:text-xl">
                        The difference? They didn't overthink it. They built it.
                    </p>
                    <p class="mt-2 text-muted-foreground">
                        Stop judging. Start creating. Your terrible idea might just be early.
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>
