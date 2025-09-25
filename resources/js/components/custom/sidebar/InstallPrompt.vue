<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
// import { ref } from 'vue';

// const canInstall = ref(false);
// let installPrompt = null;
//
// window.addEventListener('beforeinstallprompt', (event) => {
//     console.log('beforeinstallprompt');
//     event.preventDefault();
//     installPrompt = event;
//     canInstall.value = true;
// });
//
// window.addEventListener('appinstalled', () => {
//     disableInAppInstallPrompt();
// });
//
// async function tryInstall() {
//     if (!canInstall.value) {
//         console.log('cannot install');
//         return;
//     }
//
//     const result = await installPrompt.prompt();
//     console.log(`Install prompt was: ${result.outcome}`);
//     disableInAppInstallPrompt();
// }
//
// function disableInAppInstallPrompt() {
//     installPrompt = null;
//     canInstall.value = false;
// }
</script>
<template>
    <Button @click.prevent="console.log('boo')" :disabled="false"> Install </Button>
</template>
