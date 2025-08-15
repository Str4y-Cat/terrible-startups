<script setup lang="ts">
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { router } from '@inertiajs/vue3';
import Tag from './Tag.vue';
const props = defineProps<{
    ideas: Idea[];
}>();

interface Idea {
    title: string;
    id: string;
    date_created: string;
    rating: number;
}

const goToLink = (val: string) => {
    console.log('going to link');
    router.visit(`/ideas/${val}`);
};
</script>

<template>
    <Table class="border-separate. border-spacing-y-3">
        <!--<TableCaption>A list of your recent invoices.</TableCaption>-->
        <TableHeader>
            <TableRow class="border-muted/0">
                <TableHead class=""> Title </TableHead>
                <TableHead class="text-right opacity-0">Tags</TableHead>
                <TableHead class="hidden content-center text-right sm:block">Date created</TableHead>
                <!--

                <TableHead class="w-[100px] text-right"> Rating </TableHead>
                -->
            </TableRow>
        </TableHeader>
        <TableBody class="">
            <TableRow @click="goToLink(idea.id)" v-for="idea in props.ideas" :key="idea.id" class="cursor-pointer border-muted/20 *:py-6">
                <TableCell class="font-medium">
                    {{ idea.title }}
                </TableCell>
                <TableCell>
                    <div class="flex flex-wrap justify-end">
                        <Tag>Tag</Tag>
                        <Tag>Tag</Tag>
                        <Tag>Tag</Tag>
                        <Tag>Tag</Tag>
                    </div>
                </TableCell>
                <TableCell class="hidden text-right sm:block">{{ idea.date_created }}</TableCell>
                <!--
                <TableCell class="text-right">
                    <div
                        class="color-primary flex items-center justify-end gap-2"
                        :class="{
                            'text-idea-best': idea.rating >= 75,
                            'text-idea-average': idea.rating < 75 && idea.rating >= 50,
                            'text-idea-bad': idea.rating < 50 && idea.rating >= 25,
                            'text-idea-terrible': idea.rating < 25,
                        }"
                    >
                        {{ idea.rating }}
                        <component :is="Star" :size="17" :class="[`fill-current`]" />
                    </div>
                </TableCell>
                -->
            </TableRow>
        </TableBody>
    </Table>
</template>
