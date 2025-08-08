<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';

// const props = defineProps<{}>();

// const ratings = reactive(props.ratings);
</script>

<template>
    <Dialog>
        <DialogContent class="">
            <DialogHeader>
                <DialogTitle>Edit</DialogTitle>
                <DialogDescription></DialogDescription>
            </DialogHeader>

            <DialogFooter>
                <div class="flex w-full items-center gap-4">
                    <div class="w-full"></div>
                    <div>
                        <Button></Button>
                    </div>
                </div>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
