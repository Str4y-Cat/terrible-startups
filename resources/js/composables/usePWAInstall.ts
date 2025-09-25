// // composables/usePWAInstall.ts
//
// import { ref } from 'vue';
// const canInstall = ref(false);
// const installPrompt = ref<Event | null>(null);
//
// async function tryInstall() {
//     if (!canInstall.value) {
//         console.log('cannot install');
//         return;
//     }
//
//     const result = await installPrompt.value.prompt();
//     console.log(`Install prompt was: ${result.outcome}`);
//     disableInAppInstallPrompt();
// }
//
// function disableInAppInstallPrompt() {
//     installPrompt.value = null;
//     canInstall.value = false;
// }
//
// export function usePWAInstall() {
//     window.addEventListener('beforeinstallprompt', (event) => {
//         console.log('beforeinstallprompt', event);
//         event.preventDefault();
//         installPrompt.value = event;
//         canInstall.value = true;
//     });
//
//     window.addEventListener('appinstalled', () => {
//         disableInAppInstallPrompt();
//     });
//
//     return {
//         canInstallPWA: canInstall,
//         installPWA: tryInstall,
//     };
// }
//
import { readonly, ref } from 'vue';

const canInstall = ref(false);
const isInstalled = ref(false);
const installPrompt = ref<Event | null>(null);

//singleton flag
let isInitialized = false;

function reset() {
    installPrompt.value = null;
    canInstall.value = false;
}

function initializePWA() {
    if (isInitialized) return;
    isInitialized = true;

    //listen for the install prompt event
    window.addEventListener('beforeinstallprompt', (event) => {
        event.preventDefault();
        installPrompt.value = event;
        canInstall.value = true;

        console.log('PWA can be installed!', event);
    });

    //listen for a successfull installation
    window.addEventListener('appinstalled', () => {
        console.log('pwa is installed!');
        reset();
        isInstalled.value = true;
    });

    if (window.matchMedia('(display-mode: standalone)').matches) {
        isInstalled.value = true;
    }
}

async function installPWA() {
    if (!canInstall.value || !installPrompt.value) {
        console.log('PWA cannot be installed currently');
        return;
    }

    const promptEvent = installPrompt.value;
    const result = await promptEvent.prompt();
    console.log(`Result of installation is: ${result}`);

    reset();
}

export function useInstallPWA() {
    //initialize pwa singleton
    initializePWA();

    return {
        canInstall: readonly(canInstall),
        isInstalled: readonly(isInstalled),
        install: installPWA,
    };
}
