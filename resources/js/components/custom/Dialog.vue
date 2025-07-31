<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import RatingSlider from './RatingSlider.vue';
</script>

<template>
    <Dialog>
        <DialogTrigger> Rate </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Rate your idea</DialogTitle>
                <DialogDescription>Be as objective as you can. Err on the pesimistic side if you are unsure</DialogDescription>
            </DialogHeader>
            <div class="grid py-6">
                <RatingSlider @rating="(x) => console.log(x)" />
                <RatingSlider @rating="(x) => console.log(x)" />
                <RatingSlider @rating="(x) => console.log(x)" />
                <RatingSlider @rating="(x) => console.log(x)" />
                <RatingSlider @rating="(x) => console.log(x)" />
                <RatingSlider @rating="(x) => console.log(x)" />
            </div>

            <DialogFooter>
                <Button>Done</Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
