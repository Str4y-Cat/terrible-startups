<script setup lang="ts">
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { router } from '@inertiajs/vue3';
import { Star } from 'lucide-vue-next';
import Tag from './Tag.vue';
const props = defineProps<{
    ideas: Idea[];
}>();

interface Idea {
    title: string;
    id: string;
    date_created: string;
    rating: number;
    tags: object[];
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
            <TableRow class="hidden border-muted/0">
                <TableHead class=""> Title </TableHead>
                <TableHead class="text-right opacity-0">Tags</TableHead>
                <!--
                <TableHead class="hidden content-center text-right sm:block">Date created</TableHead>
                -->

                <TableHead class="w-[100px] text-right"> Rating </TableHead>
            </TableRow>
        </TableHeader>
        <TableBody class="">
            <TableRow @click="goToLink(idea.id)" v-for="idea in props.ideas" :key="idea.id" class="cursor-pointer border-muted/20 *:py-6">
                <TableCell class="text-base font-medium sm:text-lg">
                    {{ idea.title }}
                </TableCell>
                <TableCell>
                    <div class="flex flex-wrap justify-end gap-2">
                        <Tag v-for="(tag, index) in idea.tags" :key="index" class="border-none bg-primary/10 text-xs text-primary md:text-sm">{{
                            tag.value
                        }}</Tag>
                    </div>
                </TableCell>

                <!--
                <TableCell class="hidden text-right sm:block">{{ idea.date_created }}</TableCell>
                -->
                <TableCell
                    class="flex items-center justify-end gap-1 font-bold"
                    :class="{
                        'text-red-600': idea.rating < 20,
                        'text-orange-600': idea.rating >= 20 && idea.rating < 80,
                        'text-green-600': idea.rating >= 80,
                    }"
                    >{{ idea.rating }} <Star fill="currentColor" class="size-5"
                /></TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>
