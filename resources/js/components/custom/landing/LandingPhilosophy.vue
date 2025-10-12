<script setup lang="ts">
</script>

<template>
    <section class="border-y bg-muted/30 py-16 sm:py-24">
        <div class="container px-4 sm:px-8">
            <div class="mx-auto max-w-5xl">
                <!-- Main message -->
                <div class="text-center">
                    <h2 class="mb-4 text-3xl font-bold tracking-tight sm:text-4xl">
                        Why Quantity Beats Quality
                    </h2>
                    <p class="mx-auto max-w-2xl text-lg text-muted-foreground">
                        In 1993, a pottery class proved it: <strong class="font-semibold text-foreground">quantity leads to quality</strong>.
                    </p>
                </div>

                <!-- Visual comparison -->
                <div class="mt-12 grid gap-8 sm:grid-cols-2">
                    <!-- Quality Group -->
                    <div class="rounded-lg border bg-card p-6">
                        <div class="mb-4 flex items-center justify-between">
                            <h3 class="text-lg font-semibold">The "Quality" Group</h3>
                            <span class="rounded-full bg-red-500/10 px-3 py-1 text-sm font-medium text-red-500">1 Pot</span>
                        </div>
                        <p class="mb-4 text-sm text-muted-foreground">
                            Graded on perfecting a single piece. Spent weeks planning, researching, perfecting.
                        </p>
                        <div class="flex items-center justify-center py-8">
                            <div class="flex size-24 items-center justify-center rounded-full border-2 border-dashed">
                                <span class="text-4xl">🏺</span>
                            </div>
                        </div>
                        <p class="text-center text-sm font-medium text-muted-foreground">
                            Result: Mediocre work
                        </p>
                    </div>

                    <!-- Quantity Group -->
                    <div class="rounded-lg border bg-card p-6 ring-2 ring-primary/20">
                        <div class="mb-4 flex items-center justify-between">
                            <h3 class="text-lg font-semibold">The "Quantity" Group</h3>
                            <span class="rounded-full bg-green-500/10 px-3 py-1 text-sm font-medium text-green-500">50 Pots</span>
                        </div>
                        <p class="mb-4 text-sm text-muted-foreground">
                            Graded on volume. Made pot after pot, learning from each iteration.
                        </p>
                        <div class="grid grid-cols-5 gap-2 py-4">
                            <div v-for="i in 10" :key="i" class="flex items-center justify-center text-2xl">
                                🏺
                            </div>
                        </div>
                        <p class="text-center text-sm font-medium text-primary">
                            Result: Exceptional work
                        </p>
                    </div>
                </div>

                <!-- Key insight -->
                <div class="mt-12 rounded-lg bg-primary/5 p-6 text-center sm:p-8">
                    <p class="text-lg font-medium text-foreground sm:text-xl">
                        While others polish one idea for months, you'll have validated dozens.
                    </p>
                    <p class="mt-2 text-muted-foreground">
                        100 ideas at 1% success rate > 1 idea at 100% effort
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>
