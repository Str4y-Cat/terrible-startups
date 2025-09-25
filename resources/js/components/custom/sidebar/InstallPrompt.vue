<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';

import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { CardContent } from '@/components/ui/card';
import { Dialog, DialogClose, DialogContent, DialogHeader, DialogTrigger } from '@/components/ui/dialog';
import {
    Drawer,
    DrawerClose,
    DrawerContent,
    DrawerDescription,
    DrawerFooter,
    DrawerHeader,
    DrawerTitle,
    DrawerTrigger,
} from '@/components/ui/drawer';
import { useInstallPWA } from '@/composables/usePWAInstall';
import { createReusableTemplate, useMediaQuery } from '@vueuse/core';
import { Download, MonitorDown, Share, Smartphone } from 'lucide-vue-next';
import { computed } from 'vue';

const { canInstall, isInstalled, install } = useInstallPWA();
// import { ref } from 'vue';

const isIOS = computed(() => {
    return ['iPad Simulator', 'iPhone Simulator', 'iPod Simulator', 'iPad', 'iPhone', 'iPod'].indexOf(navigator.platform) !== -1;
});

const isFirefox = computed(() => {
    return navigator.userAgent.indexOf('Firefox') > -1;
});

const [UseTemplate, InstallGuide] = createReusableTemplate();
const isDesktop = useMediaQuery('(min-width: 768px)');
</script>
<template>
    <Button @click.prevent="install" :disabled="!canInstall" v-if="!isInstalled && !isIOS && !isFirefox">
        <Download class="size-5" /> Install app
    </Button>

    <UseTemplate>
        <CardContent class="p-4">
            <ol v-if="!isDesktop" class="ml-5 list-decimal text-xl font-bold">
                <li><span>Click the </span><Share class="mx-2 inline size-5" /> <span> icon on the browser bar</span></li>
                <li class="mt-3">Select "Add to Home Screen".</li>
            </ol>

            <ol v-if="isDesktop && isFirefox" class="ml-5 list-decimal text-xl font-bold">
                <li>Look at the browser search bar, at the top of your screen</li>
                <li class="mt-3">Select the download icon <MonitorDown class="mx-2 inline size-5" /></li>
            </ol>
        </CardContent>
    </UseTemplate>

    <Dialog v-if="!isInstalled && isDesktop && !canInstall">
        <DialogTrigger>
            <Button :disabled="canInstall" class="w-full"> <Download class="size-5" /> Install app </Button>
        </DialogTrigger>

        <DialogContent class="">
            <DialogHeader class="flex-row items-center gap-4">
                <div class="w-fit rounded-full bg-primary p-4">
                    <Smartphone />
                </div>
                <div>
                    <DrawerTitle class="">Install method</DrawerTitle>
                    <DrawerDescription>Follow the steps below to install this web app on your device</DrawerDescription>
                </div>
            </DialogHeader>

            <Alert v-if="isFirefox">
                <AlertTitle>Heads up!</AlertTitle>
                <AlertDescription>
                    Note: As you are using firefox, the steps may vary. If you are not able to follow the steps provided, please consider a different
                    browser for the install
                </AlertDescription>
            </Alert>

            <!-- Rating form -->
            <InstallGuide class="by-8" />

            <DialogFooter>
                <DialogClose as-child>
                    <Button type="button" variant="ghost" class="text-muted-foreground"> Keep using app in broswer </Button>
                </DialogClose>
            </DialogFooter>
        </DialogContent>
    </Dialog>

    <Drawer v-if="!isInstalled && !canInstall && !isDesktop">
        <DrawerTrigger>
            <Button :disabled="canInstall" class="w-full"> <Download class="size-5" /> Install app </Button>
        </DrawerTrigger>

        <DrawerContent>
            <div class="mx-auto w-full max-w-sm">
                <DrawerHeader class="flex-row items-center gap-4">
                    <div class="w-fit rounded-full bg-primary p-4">
                        <Smartphone />
                    </div>
                    <div>
                        <DrawerTitle class="">Install method</DrawerTitle>
                        <DrawerDescription>Follow the steps below to install this web app on your phone</DrawerDescription>
                    </div>
                </DrawerHeader>

                <InstallGuide class="bt-8 pb-16"></InstallGuide>

                <DrawerFooter class="pt-2">
                    <DrawerClose as-child>
                        <Button variant="outline"> Keep using app in browser </Button>
                    </DrawerClose>
                </DrawerFooter>
            </div>
        </DrawerContent>
    </Drawer>
</template>
