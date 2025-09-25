<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';

import { useInstallPWA } from '@/composables/usePWAInstall';
const { canInstall, isInstalled, install } = useInstallPWA();
// import { ref } from 'vue';
</script>
<template>
    <Button @click.prevent="install" :disabled="!canInstall" v-if="!isInstalled"> Install </Button>
</template>
