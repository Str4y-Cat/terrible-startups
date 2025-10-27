<script setup lang="ts">
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { ExternalLink } from 'lucide-vue-next';

const props = defineProps<{
    content: object[];
    head: string[];
}>();
</script>

<template>
    <Table class="">
        <TableCaption></TableCaption>
        <TableHeader>
            <TableRow>
                <TableHead v-for="(head, index) in props.head" :key="index">
                    {{ head }}
                </TableHead>
            </TableRow>
        </TableHeader>
        <TableBody>
            <TableRow class="" v-for="(row, index) in props.content" :key="index">
                <TableCell class="max-w-90 min-w-40 text-wrap whitespace-normal" v-for="(head, index) in props.head" :key="index">
                    <span v-if="head != 'website'">
                        {{ row[head] }}
                    </span>
                    <a
                        class="flex gap-2 text-blue-500"
                        target="_blank"
                        :href="`https://${row[head].replace('https://', '')}`"
                        v-if="head == 'website'"
                    >
                        {{ row[head].replace('https://', '') }}
                        <ExternalLink class="size-4" />
                    </a>
                </TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>
