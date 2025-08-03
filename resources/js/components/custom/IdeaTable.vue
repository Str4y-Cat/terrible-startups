<script setup lang="ts">
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
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
}

const invoices = [
    {
        invoice: 'INV001',
        paymentStatus: 'Paid',
        totalAmount: '$250.00',
        paymentMethod: 'Credit Card',
    },
    {
        invoice: 'INV002',
        paymentStatus: 'Pending',
        totalAmount: '$150.00',
        paymentMethod: 'PayPal',
    },
    {
        invoice: 'INV003',
        paymentStatus: 'Unpaid',
        totalAmount: '$350.00',
        paymentMethod: 'Bank Transfer',
    },
    {
        invoice: 'INV004',
        paymentStatus: 'Paid',
        totalAmount: '$450.00',
        paymentMethod: 'Credit Card',
    },
    {
        invoice: 'INV005',
        paymentStatus: 'Paid',
        totalAmount: '$550.00',
        paymentMethod: 'PayPal',
    },
    {
        invoice: 'INV006',
        paymentStatus: 'Pending',
        totalAmount: '$200.00',
        paymentMethod: 'Bank Transfer',
    },
    {
        invoice: 'INV007',
        paymentStatus: 'Unpaid',
        totalAmount: '$300.00',
        paymentMethod: 'Credit Card',
    },
];
</script>

<template>
    <Table class="border-separate. border-spacing-y-3">
        <TableCaption>A list of your recent invoices.</TableCaption>
        <TableHeader>
            <TableRow class="border-muted/0">
                <TableHead class=""> Title </TableHead>
                <TableHead>Tags</TableHead>
                <TableHead class="hidden text-right sm:static">Date created</TableHead>
                <TableHead class="w-[100px] text-right"> Rating </TableHead>
            </TableRow>
        </TableHeader>
        <TableBody class="">
            <TableRow v-for="idea in props.ideas" :key="idea.id" class="border-muted/20 *:py-6">
                <TableCell class="font-medium">
                    {{ idea.title }}
                </TableCell>
                <TableCell>
                    <Tag>Tag</Tag>
                    <Tag>Tag</Tag>
                    <Tag>Tag</Tag>
                    <Tag>Tag</Tag>
                </TableCell>
                <TableCell class="hidden text-right sm:static">{{ idea.date_created }}</TableCell>
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
            </TableRow>
        </TableBody>
    </Table>
</template>
