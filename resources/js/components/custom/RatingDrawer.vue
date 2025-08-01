<script setup lang="ts">
const props = defineProps<{
    disabled?: boolean;
}>();
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
import RatingSlider from './RatingSlider.vue';
</script>

<template>
    <Drawer>
        <DrawerTrigger :disabled="props.disabled" class="fixed right-4 bottom-4 disabled:translate-y-[200%] sm:static sm:disabled:translate-0"
            >Create</DrawerTrigger
        >
        <DrawerContent>
            <DrawerHeader>
                <DrawerTitle>Are you absolutely sure?</DrawerTitle>
                <DrawerDescription>This action cannot be undone.</DrawerDescription>
            </DrawerHeader>

            <div class="grid p-4 py-6">
                <RatingSlider label="Urgency" description="How badly do users want this" @rating="(x) => console.log(x)" />
                <RatingSlider @rating="(x) => console.log(x)" />
                <RatingSlider @rating="(x) => console.log(x)" />
                <RatingSlider @rating="(x) => console.log(x)" />
                <RatingSlider @rating="(x) => console.log(x)" />
                <RatingSlider @rating="(x) => console.log(x)" />
            </div>

            <DrawerFooter>
                <Button>Submit</Button>
                <DrawerClose>
                    <Button variant="outline"> Cancel </Button>
                </DrawerClose>
            </DrawerFooter>
        </DrawerContent>
    </Drawer>
</template>
