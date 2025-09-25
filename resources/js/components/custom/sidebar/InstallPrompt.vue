<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { CardContent } from '@/components/ui/card';
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
import { Download, Share, Smartphone } from 'lucide-vue-next';

const { canInstall, isInstalled, install } = useInstallPWA();
// import { ref } from 'vue';

function isIOS(): boolean {
    return ['iPad Simulator', 'iPhone Simulator', 'iPod Simulator', 'iPad', 'iPhone', 'iPod'].indexOf(navigator.platform) !== -1;
}

function isFirefox(): boolean {
    return navigator.userAgent.indexOf('Firefox') > -1;
}

const [UseTemplate, InstallGuide] = createReusableTemplate();
const isDesktop = useMediaQuery('(min-width: 768px)');
</script>
<template>
    <Button @click.prevent="install" :disabled="!canInstall" v-if="!isInstalled && !isIOS() && !isFirefox()"> Install </Button>
    <h1 class="flex animate-pulse justify-center rounded bg-blue-500 py-2 text-black" v-if="isIOS()">THIS IS IOS</h1>
    <h1 class="flex animate-pulse justify-center rounded bg-orange-500 py-2 font-bold text-black" v-if="isFirefox()">THIS IS FIREFOX</h1>

    <UseTemplate>
        <CardContent class="bt-8 p-4 pb-16">
            <ol class="ml-5 list-decimal text-xl font-bold">
                <li><span>Click the </span><Share class="mx-2 inline size-5" /> <span> icon on the browser bar</span></li>
                <li class="mt-3">Select "Add to Home Screen".</li>
            </ol>
        </CardContent>
    </UseTemplate>

    <Drawer v-if="!canInstall">
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

                <InstallGuide></InstallGuide>

                <DrawerFooter class="pt-2">
                    <DrawerClose as-child>
                        <Button variant="outline"> Keep using app in browser </Button>
                    </DrawerClose>
                </DrawerFooter>
            </div>
        </DrawerContent>
    </Drawer>
</template>
