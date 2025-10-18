<script lang="ts" setup>
const isDev = false;
</script>

<template>
    <section class="" :class="{ 'border border-red-500': isDev }">
        <div class="relative z-10 flex items-center justify-center py-20 sm:py-32">
            <div class="mx-auto w-full max-w-4xl text-center" :class="{ 'border border-blue-500': isDev }">
                <slot></slot>
            </div>
        </div>
    </section>
</template>
