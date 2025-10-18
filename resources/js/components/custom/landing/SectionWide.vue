<script lang="ts" setup>
const isDev = false;
</script>
<template>
    <section class="" :class="{ 'border border-red-500': isDev }">
        <div class="mx-auto max-w-6xl" :class="{ 'border border-yellow-500': isDev }">
            <slot></slot>
        </div>
    </section>
</template>
