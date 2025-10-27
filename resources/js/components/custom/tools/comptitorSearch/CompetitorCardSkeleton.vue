<script setup lang="ts">
import { Avatar, AvatarFallback } from '@/components/ui/avatar';
import Button from '@/components/ui/button/Button.vue';
import { Skeleton } from '@/components/ui/skeleton';
</script>

<template>
    <div class="mb-8 rounded-lg border bg-card p-6 transition">
        <div class="flex w-full flex-col items-start">
            <!-- HEADER -->
            <div class="grid w-full grid-cols-1 items-center justify-between gap-4 sm:grid-cols-2">
                <div>
                    <div class="mb-2 flex items-center gap-2">
                        <!-- AVATAR -->
                        <Avatar>
                            <AvatarFallback>
                                <Skeleton class="h-10 w-10 rounded-full" />
                            </AvatarFallback>
                        </Avatar>

                        <!-- NAME + LINK -->
                        <div>
                            <Skeleton class="mb-2 h-6 w-40 rounded" />
                            <Skeleton class="h-4 w-64 rounded" />
                        </div>
                    </div>

                    <!-- SUMMARY -->
                    <Skeleton class="mb-4 h-4 w-[80%]" />
                    <Skeleton class="mb-4 h-4 w-[90%]" />
                </div>

                <!-- KEY INFO / REGIONS / TARGET AUDIENCE -->
                <div class="grid grid-cols-1 sm:gap-2">
                    <div class="mb-4 flex flex-wrap gap-2">
                        <Skeleton v-for="n in 3" :key="n" class="h-6 w-16 rounded-full" />
                    </div>
                    <div class="mb-4 flex flex-wrap gap-2">
                        <Skeleton v-for="n in 2" :key="n" class="h-6 w-20 rounded-full" />
                    </div>
                    <div class="mb-4 flex flex-wrap gap-2">
                        <Skeleton v-for="n in 3" :key="n" class="h-6 w-24 rounded-full" />
                    </div>
                </div>
            </div>

            <!-- DIVIDER + BUTTON -->
            <div class="mt-4 flex w-full items-center gap-2">
                <div class="w-full grow border-t"></div>
                <Button variant="ghost" disabled>
                    <Skeleton class="h-4 w-20 rounded" />
                </Button>
                <div class="w-full grow border-t"></div>
            </div>

            <!-- METADATA -->
            <div class="mt-4 w-full pt-3 text-xs text-muted-foreground">
                <div class="flex items-center gap-2">
                    <Skeleton class="h-3 w-24" />
                    <div class="h-3 border border-transparent border-l-border"></div>
                    <Skeleton class="h-3 w-32" />
                    <div class="h-3 border border-transparent border-l-border"></div>
                    <Skeleton class="h-3 w-16" />
                </div>
            </div>
        </div>
    </div>
</template>
