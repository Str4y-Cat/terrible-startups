<script setup lang="ts">
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';

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
                    {{ row[head] }}
                </TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>
