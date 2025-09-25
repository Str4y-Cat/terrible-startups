// composables/usePWAInstall.ts

import { ref } from 'vue';
const canInstall = ref(false);
const installPrompt = ref<Event | null>(null);

async function tryInstall() {
    if (!canInstall.value) {
        console.log('cannot install');
        return;
    }

    const result = await installPrompt.value.prompt();
    console.log(`Install prompt was: ${result.outcome}`);
    disableInAppInstallPrompt();
}

function disableInAppInstallPrompt() {
    installPrompt.value = null;
    canInstall.value = false;
}

export function usePWAInstall() {
    window.addEventListener('beforeinstallprompt', (event) => {
        console.log('beforeinstallprompt');
        event.preventDefault();
        installPrompt.value = event;
        canInstall.value = true;
    });

    window.addEventListener('appinstalled', () => {
        disableInAppInstallPrompt();
    });

    return {
        canInstallPWA: canInstall,
        installPWA: tryInstall,
    };
}
